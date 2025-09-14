// script.js - client logic, charts and AJAX calls

// Tab switching
function switchTab(tabId){
    document.querySelectorAll('.nav-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
    document.querySelector(`.nav-tab[onclick="switchTab('${tabId}')"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

// logout
function logout(){
    alert('Logging out...');
    window.location.href = 'login.php';
}

// Charts initialization
const perfChart = new Chart(document.getElementById('performanceChart').getContext('2d'), {
    type:'bar',
    data:{labels:['Thermal Comfort','Moisture Mgmt','Durability','Overall'], datasets:[{label:'Score', data:[0,0,0,0], backgroundColor:['#4caf50','#81c784','#66bb6a','#388e3c']}]},
    options:{responsive:true, scales:{y:{beginAtZero:true, max:10}}}
});
const compChart = new Chart(document.getElementById('comparisonChart').getContext('2d'), {
    type:'radar',
    data:{labels:['Cold Desert','Hot Desert','Humid Coastal','Dense Jungle'], datasets:[{label:'Suitability', data:[0,0,0,0], backgroundColor:'rgba(76,175,80,0.2)', borderColor:'#4caf50', borderWidth:2}]},
    options:{responsive:true, scales:{r:{beginAtZero:true, max:10}}}
});
const sustChart = new Chart(document.getElementById('sustainabilityChart').getContext('2d'), {
    type:'doughnut',
    data:{labels:['Carbon','Water','Chemical','Lifecycle'], datasets:[{data:[0,0,0,0], backgroundColor:['#4caf50','#81c784','#c8e6c9','#a5d6a7']}]},
    options:{responsive:true}
});
const supplyChart = new Chart(document.getElementById('supplyChainChart').getContext('2d'), {
    type:'line',
    data:{labels:['Q1','Q2','Q3','Q4'], datasets:[{label:'Efficiency',data:[0,0,0,0], borderColor:'#4caf50', backgroundColor:'rgba(76,175,80,0.2)', fill:true, tension:0.3}]},
    options:{responsive:true, scales:{y:{beginAtZero:true, max:100}}}
});

// display alert
function showAlert(msg, type='success'){
    const container = document.getElementById('alertContainer');
    const el = document.createElement('div');
    el.className = `alert ${type}`;
    el.innerText = msg;
    container.appendChild(el);
    el.style.display = 'block';
    setTimeout(()=>el.remove(),4000);
}

// Run AI analysis: collect inputs and call PHP API which calls ML service
async function runComprehensiveAnalysis(){
    const btnText = document.getElementById('analyzeText');
    btnText.innerText = '⏳ Running Analysis...';
    // gather inputs
    const payload = {
        temperature: Number(document.getElementById('temperature').value),
        humidity: Number(document.getElementById('humidity').value),
        altitude: Number(document.getElementById('altitude').value),
        terrain: document.getElementById('terrain').value,
        missionDuration: document.getElementById('missionDuration').value,
        fabric: {
            weight: Number(document.getElementById('fabricWeight').value),
            breathability: Number(document.getElementById('breathability').value),
            insulation: Number(document.getElementById('insulation').value),
            tensileStrength: Number(document.getElementById('tensileStrength').value),
            moistureAbsorption: Number(document.getElementById('moistureAbsorption').value),
            durability: Number(document.getElementById('durability').value),
            recyclability: Number(document.getElementById('recyclability').value)
        },
        analysisType: document.getElementById('analysisType').value,
        priorityWeight: document.getElementById('priorityWeight').value
    };

    try {
        const resp = await fetch('run_analysis.php', {
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body: JSON.stringify(payload)
        });
        const data = await resp.json();
        if(data.error){
            showAlert('AI service error: '+data.error,'error');
            btnText.innerText = '🚀 Run AI/ML Analysis';
            return;
        }
        // update performance UI
        const perf = data.performance;
        document.getElementById('thermalComfort').innerText = `${perf.thermalComfort}/10`;
        document.getElementById('moistureManagement').innerText = `${perf.moistureManagement}/10`;
        document.getElementById('durabilityScore').innerText = `${perf.durability}/10`;
        document.getElementById('overallSuitability').innerText = `${perf.overall.toFixed(1)}/10`;

        perfChart.data.datasets[0].data = [perf.thermalComfort, perf.moistureManagement, perf.durability, perf.overall];
        perfChart.update();

        // comparison scores
        const comp = data.multiClimateScores; // {cold:..,hot:..,coastal:..,jungle:..}
        compChart.data.datasets[0].data = [comp.cold, comp.hot, comp.coastal, comp.jungle];
        compChart.update();
        document.getElementById('coldDesertScore').innerText = `${comp.cold.toFixed(1)}/10`;
        document.getElementById('hotDesertScore').innerText = `${comp.hot.toFixed(1)}/10`;
        document.getElementById('coastalScore').innerText = `${comp.coastal.toFixed(1)}/10`;
        document.getElementById('jungleScore').innerText = `${comp.jungle.toFixed(1)}/10`;

        // sustainability
        const sust = data.sustainability;
        document.getElementById('sustainabilityScore').innerText = `${sust.overall}%`;
        sustChart.data.datasets[0].data = [sust.carbon, sust.water, sust.chemical, sust.lifecycle];
        sustChart.update();

        // supply chain
        const sc = data.supply;
        supplyChart.data.datasets[0].data = sc.trend;
        supplyChart.update();
        document.getElementById('supplyRecommendations').innerHTML = data.supply.recommendationHtml || '<div class="recommendation-item"><div class="recommendation-title">No recs</div></div>';

        // matrix
        const matrixBody = document.getElementById('matrixBody');
        matrixBody.innerHTML = data.matrixHtml;

        // recommendations panel
        document.getElementById('recommendationsContainer').innerHTML = data.recommendationsHtml;

        showAlert('Analysis Completed', 'success');
    } catch(err){
        console.error(err);
        showAlert('Unexpected error: ' + err.message, 'error');
    } finally {
        btnText.innerText = '🚀 Run AI/ML Analysis';
    }
}

// Export simple CSV (from matrix)
function exportCSV(){
    const csvRows = [];
    const rows = document.querySelectorAll('#performanceMatrix tr');
    rows.forEach(r=>{
        const cols = Array.from(r.querySelectorAll('th,td')).map(c=>`"${c.innerText.replace(/"/g,'""')}"`);
        csvRows.push(cols.join(','));
    });
    const csvString = csvRows.join('\n');
    const blob = new Blob([csvString], {type:'text/csv'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'fabric_analysis_matrix.csv';
    a.click();
}

// minimal PDF via browser print (simple fallback)
function exportPDF(){
    window.print();
}
