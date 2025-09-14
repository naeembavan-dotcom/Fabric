<?php
// run_analysis.php - receives JSON payload, calls ML microservice, returns unified result for front-end
header('Content-Type: application/json');

// read request
$input = json_decode(file_get_contents('php://input'), true);
if(!$input){
    echo json_encode(['error'=>'Invalid JSON payload']);
    exit;
}

// prepare calls to ML microservice (local ML service expecting certain endpoints)
$ml_base = 'http://127.0.0.1:8000'; // change if needed

// 1) Predict performance (call /predict_performance)
$perf_payload = [
    'fabric_features' => [
        'weight_g_per_m2' => $input['fabric']['weight'],
        'breathability_score' => $input['fabric']['breathability'] * 10, // scaled 1-10 -> 10-100
        'insulation_r_value' => $input['fabric']['insulation'] / 10, // keep simple scale
        'tensile_strength' => $input['fabric']['tensileStrength'],
        'moisture_absorption' => $input['fabric']['moistureAbsorption']
    ],
    'climate_features' => [
        'avg_temp_c' => $input['temperature'],
        'avg_humidity' => $input['humidity'],
        'altitude_m' => $input['altitude']
    ]
];

$ch = curl_init("$ml_base/predict_performance");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($perf_payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$perf_resp = curl_exec($ch);
$perf_err = curl_error($ch);
curl_close($ch);
if($perf_err){
    echo json_encode(['error' => 'ML perf call failed: '.$perf_err]);
    exit;
}
$perf_json = json_decode($perf_resp, true);

// 2) Sustainability
$sust_payload = ['fabric_features'=>[
    'recyclable' => $input['fabric']['recyclability'] > 50,
    'biodegradable' => false,
    'recycled_pct' => $input['fabric']['recyclability']
]];
$ch = curl_init("$ml_base/sustainability_score");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sust_payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$sust_resp = curl_exec($ch);
$sust_err = curl_error($ch);
curl_close($ch);
if($sust_err){
    echo json_encode(['error'=>'ML sustain call failed: '.$sust_err]);
    exit;
}
$sust_json = json_decode($sust_resp, true);

// 3) Recommend best (test multiple climates) using /recommend_best
// create candidates list with slight variations (simulate blends)
$candidates = [
    array_merge($perf_payload['fabric_features'], ['name'=>'Candidate A','unit_cost'=>2.5]),
    array_merge($perf_payload['fabric_features'], ['name'=>'Candidate B','unit_cost'=>3.5,'breathability_score'=> $perf_payload['fabric_features']['breathability_score']+10]),
    array_merge($perf_payload['fabric_features'], ['name'=>'Candidate C','unit_cost'=>4.0,'insulation_r_value'=> $perf_payload['fabric_features']['insulation_r_value']+0.05])
];
$climates = [
    ['avg_temp_c'=>-5,'avg_humidity'=>20,'name'=>'cold'],
    ['avg_temp_c'=>40,'avg_humidity'=>15,'name'=>'hot'],
    ['avg_temp_c'=>30,'avg_humidity'=>80,'name'=>'coastal'],
    ['avg_temp_c'=>28,'avg_humidity'=>85,'name'=>'jungle']
];
$rec_payload = ['candidates'=>$candidates,'climates'=>$climates];
$ch = curl_init("$ml_base/recommend_best");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rec_payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$rec_resp = curl_exec($ch);
$rec_err = curl_error($ch);
curl_close($ch);
if($rec_err){
    echo json_encode(['error'=>'ML recommend call failed: '.$rec_err]);
    exit;
}
$rec_json = json_decode($rec_resp, true);

// 4) Supply chain forecast (we'll mock using recommend result and simple heuristics)
$supply = [
    'trend' => [60,70,55,65], // sample percentages for quarters
    'recommendationHtml' => '<div class="recommendation-item"><div class="recommendation-title">Distribute stock to remote bases</div><div class="recommendation-desc">Increase stock at high-altitude bases by 20% during winter months.</div></div>'
];

// Initialize variables with defaults to avoid undefined variable errors
$ins = $perf_json['performance']['insulation'] ?? 0.5;
$bre = $perf_json['performance']['breathability'] ?? 50;
$dur = $perf_json['performance']['durability'] ?? 70;
$moisture_wicking = $perf_json['performance']['moisture_wicking'] ?? 60;

// Build matrix HTML (for comparison tab)
$matrixHtml = '';
foreach($climates as $cl){
    $cName = ucfirst($cl['name']);
    // compute simple overall score using perf_json
    
    // compute sample per-climate
    if($cl['name']=='cold'){
        $overall = ($ins*6 + ($bre/10)*2 + ($dur/10)*2);
    } elseif($cl['name']=='hot'){
        $overall = (($bre/10)*6 + (1-$ins)*2 + ($dur/10)*2);
    } else {
        $overall = (($bre/10)*4 + $ins*3 + ($dur/10)*3);
    }
    
    $matrixHtml .= "<tr>
        <td>{$cName}</td>
        <td>".round($ins*10,2)."</td>
        <td>".round($bre/10,2)."</td>
        <td>".round($moisture_wicking/10,2)."</td>
        <td>".round($dur/10,2)."</td>
        <td>".round($overall,2)."</td>
        <td>".(round($overall,2) > 6 ? 'Recommended' : 'Limited')."</td>
    </tr>";
}

// build recommendations HTML from rec_json
$recsHtml = '<div class="recommendation-item"><div class="recommendation-title">Top Recommendations</div>';
if(isset($rec_json['recommendations']) && is_array($rec_json['recommendations'])){
    foreach(array_slice($rec_json['recommendations'],0,3) as $r){
        $fabric_name = $r['fabric'] ?? 'Unknown Fabric';
        $score = $r['score'] ?? 'N/A';
        $unit_cost = $r['unit_cost'] ?? 'N/A';
        $sustainability = $r['sustainability'] ?? 'N/A';
        $recsHtml .= "<div class=\"recommendation-desc\">{$fabric_name}: score {$score} — cost {$unit_cost} — sustainability {$sustainability}</div>";
    }
} else {
    $recsHtml .= "<div class=\"recommendation-desc\">No specific recommendations available</div>";
}
$recsHtml .= '</div>';

// assemble response
$response = [
    'performance' => [
        'thermalComfort' => round($ins * 10, 1),
        'moistureManagement' => round($moisture_wicking / 10, 1),
        'durability' => round($dur / 10, 1),
        'overall' => round((($ins * 4) + (($bre/100) * 4) + (($dur/100) * 2)), 2)
    ],
    'multiClimateScores' => [
        'cold' => round(isset($rec_json['recommendations'][0]) ? min(10, ($rec_json['recommendations'][0]['perf_avg'] ?? 6) * 1.2) : 7,1),
        'hot' => round(isset($rec_json['recommendations'][0]) ? min(10, ($rec_json['recommendations'][0]['perf_avg'] ?? 6)) : 6.5,1),
        'coastal' => round(isset($rec_json['recommendations'][0]) ? min(10, ($rec_json['recommendations'][0]['perf_avg'] ?? 6)) : 6.5,1),
        'jungle' => round(isset($rec_json['recommendations'][0]) ? min(10, ($rec_json['recommendations'][0]['perf_avg'] ?? 6) * 0.95) : 6,1)
    ],
    'sustainability' => [
        'overall' => round($sust_json['sustainability_score'] ?? 50,1),
        'carbon' => 25,
        'water' => 30,
        'chemical' => 20,
        'lifecycle' => 25
    ],
    'supply' => $supply,
    'matrixHtml' => $matrixHtml,
    'recommendationsHtml' => $recsHtml
];

echo json_encode($response);
?>