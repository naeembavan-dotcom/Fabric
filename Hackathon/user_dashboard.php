<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Army Fabric Selection & Supply Chain Optimization Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #0d2818 0%, #1a4d2e 50%, #0a1f14 100%);
    min-height: 100vh;
    color: #333;
}

/* Header */
.header {
    background: linear-gradient(135deg, #1b5e20, #2e7d32);
    color: white;
    padding: 1rem 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}

.header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><rect width="100" height="2" fill="rgba(255,255,255,0.1)"/><rect y="4" width="100" height="2" fill="rgba(255,255,255,0.05)"/><rect y="8" width="100" height="2" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.3;
}

.header-content {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header h1::before {
    content: '🎖️';
    font-size: 2rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 500;
}

.logout-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.logout-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
}

/* Navigation Tabs */
.nav-tabs {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    padding: 0 2rem;
    display: flex;
    gap: 2rem;
    overflow-x: auto;
}

.nav-tab {
    padding: 1rem 1.5rem;
    color: rgba(255,255,255,0.7);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    font-weight: 500;
    white-space: nowrap;
}

.nav-tab.active {
    color: white;
    border-bottom-color: #4caf50;
    background: rgba(255,255,255,0.1);
}

.nav-tab:hover {
    color: white;
    background: rgba(255,255,255,0.05);
}

/* Main Container */
.main-container {
    padding: 2rem;
    max-width: 1600px;
    margin: 0 auto;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Grid Layouts */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.wide-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Card Styles */
.card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1b5e20, #4caf50, #81c784);
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.2);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e8f5e8;
}

.card-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1b5e20, #4caf50);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1b5e20;
}

/* Input Styles */
.input-group {
    margin-bottom: 1rem;
}

.input-label {
    display: block;
    font-weight: 500;
    color: #2e7d32;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-field, .select-field {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e8f5e8;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.input-field:focus, .select-field:focus {
    outline: none;
    border-color: #4caf50;
    background: white;
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.input-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.input-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
}

/* Button Styles */
.btn-primary {
    background: linear-gradient(135deg, #1b5e20, #4caf50);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    margin-top: 1rem;
    position: relative;
    overflow: hidden;
}

.btn-secondary {
    background: linear-gradient(135deg, #37474f, #546e7a);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0.25rem;
}

.btn-export {
    background: linear-gradient(135deg, #f57c00, #ff9800);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0.25rem;
}

.btn-primary:hover, .btn-secondary:hover, .btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

/* Score Displays */
.score-display {
    text-align: center;
    padding: 2rem 1rem;
}

.score-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4caf50, #81c784);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
    position: relative;
}

.score-label {
    font-weight: 600;
    color: #1b5e20;
    font-size: 0.9rem;
}

/* Climate Cards */
.climate-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.climate-card {
    background: #f8fff8;
    padding: 1rem;
    border-radius: 12px;
    border: 2px solid #e8f5e8;
    text-align: center;
    transition: all 0.3s ease;
}

.climate-card:hover {
    border-color: #4caf50;
    background: #f1f8f1;
}

.climate-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.climate-name {
    font-weight: 600;
    color: #1b5e20;
    margin-bottom: 0.25rem;
}

.climate-score {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4caf50;
}

/* Comparison Table */
.comparison-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.comparison-table th,
.comparison-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e8f5e8;
}

.comparison-table th {
    background: #f8fff8;
    font-weight: 600;
    color: #1b5e20;
}

.comparison-table tr:hover {
    background: #f8fff8;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 300px;
    margin-top: 1rem;
}

.chart-container-large {
    height: 400px;
}

/* Status Grid */
.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.status-item {
    text-align: center;
    padding: 1rem;
    background: #f8fff8;
    border-radius: 12px;
    border: 2px solid #e8f5e8;
}

.status-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1b5e20;
    margin-bottom: 0.25rem;
}

.status-label {
    font-size: 0.8rem;
    color: #666;
    font-weight: 500;
}

/* Recommendations */
.recommendation-item {
    background: #f1f8e9;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    border-left: 4px solid #4caf50;
}

.recommendation-title {
    font-weight: 600;
    color: #1b5e20;
    margin-bottom: 0.25rem;
}

.recommendation-desc {
    font-size: 0.9rem;
    color: #555;
    line-height: 1.4;
}

/* Export Section */
.export-section {
    background: #f8fff8;
    padding: 1.5rem;
    border-radius: 12px;
    border: 2px solid #e8f5e8;
    text-align: center;
}

.export-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 1rem;
}

/* Alert Styles */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    display: none;
    position: fixed;
    top: 100px;
    right: 20px;
    z-index: 1000;
    min-width: 300px;
}

.alert.success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert.warning {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.alert.error {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

/* Loading Animation */
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .wide-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .main-container {
        padding: 1rem;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .input-row, .input-row-3 {
        grid-template-columns: 1fr;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .nav-tabs {
        padding: 0 1rem;
        gap: 1rem;
    }
    
    .climate-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .export-buttons {
        flex-direction: column;
        align-items: center;
    }
}

/* Card Wide */
.card-wide {
    grid-column: 1 / -1;
}
</style>
</head>
<body>

<div class="header">
    <div class="header-content">
        <h1>AI/ML Fabric Selection & Supply Chain Optimization</h1>
        <div class="user-info">
            <span>🪖 Officer Dashboard</span>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </div>
</div>

<div class="nav-tabs">
    <div class="nav-tab active" onclick="switchTab('analysis')">🔬 Fabric Analysis</div>
    <div class="nav-tab" onclick="switchTab('comparison')">📊 Multi-Climate Comparison</div>
    <div class="nav-tab" onclick="switchTab('sustainability')">🌱 Sustainability Assessment</div>
    <div class="nav-tab" onclick="switchTab('supply-chain')">🚚 Supply Chain Optimization</div>
    <div class="nav-tab" onclick="switchTab('reports')">📄 Reports & Export</div>
</div>

<div class="main-container">
    <div id="alertContainer"></div>
    
    <!-- Fabric Analysis Tab -->
    <div id="analysis" class="tab-content active">
        <div class="dashboard-grid">
            <!-- Climate & Environmental Data -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🌡️</div>
                    <h3 class="card-title">Climate & Environmental Data</h3>
                </div>
                <div class="input-row-3">
                    <div class="input-group">
                        <label class="input-label">Temperature (°C)</label>
                        <input type="number" class="input-field" id="temperature" value="25">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Humidity (%)</label>
                        <input type="number" class="input-field" id="humidity" value="60">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Altitude (m)</label>
                        <input type="number" class="input-field" id="altitude" value="1000">
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-label">Terrain Type</label>
                    <select class="select-field" id="terrain">
                        <option value="cold-desert">Cold Desert (Ladakh)</option>
                        <option value="hot-desert">Hot Desert (Rajasthan)</option>
                        <option value="humid-coastal">Humid Coastal Areas</option>
                        <option value="dense-jungle">Dense Jungle</option>
                        <option value="mountain">High Mountain</option>
                        <option value="urban">Urban Combat</option>
                    </select>
                </div>
                <div class="input-group">
                    <label class="input-label">Mission Duration</label>
                    <select class="select-field" id="missionDuration">
                        <option value="short">Short Term (< 24 hours)</option>
                        <option value="medium">Medium Term (1-7 days)</option>
                        <option value="long">Long Term (> 1 week)</option>
                        <option value="extended">Extended Deployment</option>
                    </select>
                </div>
            </div>

            <!-- Fabric Properties Input -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🧵</div>
                    <h3 class="card-title">Fabric Properties</h3>
                </div>
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label">Weight (gsm)</label>
                        <input type="number" class="input-field" id="fabricWeight" value="200">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Breathability (1-10)</label>
                        <input type="number" class="input-field" id="breathability" min="1" max="10" value="6">
                    </div>
                </div>
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label">Insulation (1-10)</label>
                        <input type="number" class="input-field" id="insulation" min="1" max="10" value="5">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Tensile Strength (MPa)</label>
                        <input type="number" class="input-field" id="tensileStrength" value="45">
                    </div>
                </div>
                <div class="input-row">
                    <div class="input-group">
                        <label class="input-label">Moisture Absorption (%)</label>
                        <input type="number" class="input-field" id="moistureAbsorption" value="15">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Durability (1-10)</label>
                        <input type="number" class="input-field" id="durability" min="1" max="10" value="7">
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-label">Recyclability (%)</label>
                    <input type="number" class="input-field" id="recyclability" min="0" max="100" value="65">
                </div>
            </div>

            <!-- AI Analysis Controls -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🤖</div>
                    <h3 class="card-title">AI/ML Analysis Control</h3>
                </div>
                <div class="input-group">
                    <label class="input-label">Analysis Type</label>
                    <select class="select-field" id="analysisType">
                        <option value="performance">Performance Prediction</option>
                        <option value="multi-objective">Multi-Objective Optimization</option>
                        <option value="sustainability">Sustainability Focus</option>
                        <option value="cost-performance">Cost-Performance Balance</option>
                    </select>
                </div>
                <div class="input-group">
                    <label class="input-label">Priority Weighting</label>
                    <select class="select-field" id="priorityWeight">
                        <option value="balanced">Balanced Approach</option>
                        <option value="performance">Performance Priority</option>
                        <option value="cost">Cost Optimization</option>
                        <option value="sustainability">Sustainability Priority</option>
                        <option value="durability">Durability Focus</option>
                    </select>
                </div>
                <button class="btn-primary" onclick="runComprehensiveAnalysis()">
                    <span id="analyzeText">🚀 Run AI/ML Analysis</span>
                </button>
            </div>
        </div>

        <div class="wide-grid">
            <!-- Fabric Performance Results -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">📈</div>
                    <h3 class="card-title">Fabric Performance Prediction</h3>
                </div>
                <div class="chart-container">
                    <canvas id="performanceChart"></canvas>
                </div>
                <div class="status-grid">
                    <div class="status-item">
                        <div class="status-value" id="thermalComfort">--</div>
                        <div class="status-label">Thermal Comfort</div>
                    </div>
                    <div class="status-item">
                        <div class="status-value" id="moistureManagement">--</div>
                        <div class="status-label">Moisture Management</div>
                    </div>
                    <div class="status-item">
                        <div class="status-value" id="durabilityScore">--</div>
                        <div class="status-label">Expected Durability</div>
                    </div>
                    <div class="status-item">
                        <div class="status-value" id="overallSuitability">--</div>
                        <div class="status-label">Overall Suitability</div>
                    </div>
                </div>
            </div>

            <!-- AI Recommendations -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">💡</div>
                    <h3 class="card-title">AI Recommendations</h3>
                </div>
                <div id="recommendationsContainer">
                    <div class="recommendation-item">
                        <div class="recommendation-title">📋 Ready for Analysis</div>
                        <div class="recommendation-desc">Configure your parameters and run the AI analysis to get intelligent recommendations for fabric selection across multiple climates.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-Climate Comparison Tab -->
    <div id="comparison" class="tab-content">
        <div class="card card-wide">
            <div class="card-header">
                <div class="card-icon">🌍</div>
                <h3 class="card-title">Multi-Climate Fabric Performance Comparison</h3>
            </div>
            <div class="climate-grid" id="climateGrid">
                <div class="climate-card">
                    <div class="climate-icon">🏔️</div>
                    <div class="climate-name">Cold Desert (Ladakh)</div>
                    <div class="climate-score" id="coldDesertScore">--</div>
                </div>
                <div class="climate-card">
                    <div class="climate-icon">🏜️</div>
                    <div class="climate-name">Hot Desert (Rajasthan)</div>
                    <div class="climate-score" id="hotDesertScore">--</div>
                </div>
                <div class="climate-card">
                    <div class="climate-icon">🌊</div>
                    <div class="climate-name">Humid Coastal</div>
                    <div class="climate-score" id="coastalScore">--</div>
                </div>
                <div class="climate-card">
                    <div class="climate-icon">🌲</div>
                    <div class="climate-name">Dense Jungle</div>
                    <div class="climate-score" id="jungleScore">--</div>
                </div>
            </div>
            <div class="chart-container-large">
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>

        <div class="card card-wide">
            <div class="card-header">
                <div class="card-icon">📋</div>
                <h3 class="card-title">Detailed Performance Matrix</h3>
            </div>
            <table class="comparison-table" id="performanceMatrix">
                <thead>
                    <tr>
                        <th>Climate/Terrain</th>
                        <th>Thermal Performance</th>
                        <th>Breathability</th>
                        <th>Moisture Management</th>
                        <th>Durability</th>
                        <th>Overall Score</th>
                        <th>Recommendation</th>
                    </tr>
                </thead>
                <tbody id="matrixBody">
                    <tr>
                        <td colspan="7" style="text-align: center; color: #666;">Run analysis to generate performance matrix</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sustainability Assessment Tab -->
    <div id="sustainability" class="tab-content">
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🌱</div>
                    <h3 class="card-title">Sustainability Score</h3>
                </div>
                <div class="score-display">
                    <div class="score-circle" id="sustainabilityScore">N/A</div>
                    <div class="score-label">Eco-Friendliness Rating</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">♻️</div>
                    <h3 class="card-title">Recyclability Assessment</h3>
                </div>
                <div class="score-display">
                    <div class="score-circle" id="recyclabilityScore">N/A</div>
                    <div class="score-label">Recyclability Index</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🌿</div>
                    <h3 class="card-title">Biodegradability Index</h3>
                </div>
                <div class="score-display">
                    <div class="score-circle" id="biodegradabilityScore">N/A</div>
                    <div class="score-label">Biodegradation Rate</div>
                </div>
            </div>
        </div>

        <div class="card card-wide">
            <div class="card-header">
                <div class="card-icon">📊</div>
                <h3 class="card-title">Sustainability Metrics Breakdown</h3>
            </div>
            <div class="chart-container">
                <canvas id="sustainabilityChart"></canvas>
            </div>
            <div class="status-grid">
                <div class="status-item">
                    <div class="status-value" id="carbonFootprint">--</div>
                    <div class="status-label">Carbon Footprint</div>
                </div>
                <div class="status-item">
                    <div class="status-value" id="waterUsage">--</div>
                    <div class="status-label">Water Usage</div>
                </div>
                <div class="status-item">
                    <div class="status-value" id="chemicalImpact">--</div>
                    <div class="status-label">Chemical Impact</div>
                </div>
                <div class="status-item">
                    <div class="status-value" id="lifeCycleScore">--</div>
                    <div class="status-label">Life Cycle Score</div>
                </div>
            </div>
        </div>
    </div>

       <!-- Supply Chain Optimization Tab -->
    <div id="supply-chain" class="tab-content">
        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">🚚</div>
                    <h3 class="card-title">Supply Chain Performance</h3>
                </div>
                <div class="chart-container">
                    <canvas id="supplyChainChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">📦</div>
                    <h3 class="card-title">Inventory & Material Recommendations</h3>
                </div>
                <div id="supplyRecommendations">
                    <div class="recommendation-item">
                        <div class="recommendation-title">Configure parameters to see recommendations</div>
                        <div class="recommendation-desc">Adjust mission type, fabric, and quantity to generate optimized supply plans.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports & Export Tab -->
    <div id="reports" class="tab-content">
        <div class="export-section">
            <h3>Export AI/ML Reports</h3>
            <div class="export-buttons">
                <button class="btn-export" onclick="exportPDF()">📄 Export PDF</button>
                <button class="btn-export" onclick="exportCSV()">📊 Export CSV</button>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchTab(tabId) {
    document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

    document.querySelector(`.nav-tab[onclick="switchTab('${tabId}')"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

// Dummy logout function
function logout() {
    alert("Logging out...");
    window.location.href = "login.php";
}

// Dummy AI/ML Analysis Function
function runComprehensiveAnalysis() {
    document.getElementById('analyzeText').innerText = '⏳ Running Analysis...';
    setTimeout(() => {
        document.getElementById('thermalComfort').innerText = '8/10';
        document.getElementById('moistureManagement').innerText = '7/10';
        document.getElementById('durabilityScore').innerText = '9/10';
        document.getElementById('overallSuitability').innerText = '8.5/10';

        // Recommendations
        const rec = document.getElementById('recommendationsContainer');
        rec.innerHTML = `
            <div class="recommendation-item">
                <div class="recommendation-title">✅ Optimal Fabric Found</div>
                <div class="recommendation-desc">Breathable, durable, and suitable for multi-terrain deployment.</div>
            </div>
            <div class="recommendation-item">
                <div class="recommendation-title">💡 Sustainability Suggestion</div>
                <div class="recommendation-desc">Consider fabrics with higher recyclability for extended deployment missions.</div>
            </div>
        `;
        document.getElementById('analyzeText').innerText = '🚀 Run AI/ML Analysis';
        showAlert("Analysis Completed Successfully!", "success");
    }, 2000);
}

// Alerts
function showAlert(msg, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertEl = document.createElement('div');
    alertEl.className = `alert ${type}`;
    alertEl.innerText = msg;
    alertContainer.appendChild(alertEl);
    alertEl.style.display = 'block';
    setTimeout(() => alertEl.remove(), 4000);
}

// Dummy Export Functions
function exportPDF() {
    alert("Exporting PDF... (to be implemented with jsPDF)");
}

function exportCSV() {
    alert("Exporting CSV... (to be implemented)");
}

// Chart.js placeholders
const performanceChart = new Chart(document.getElementById('performanceChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['Thermal Comfort', 'Moisture Management', 'Durability', 'Overall'],
        datasets: [{
            label: 'Score',
            data: [0,0,0,0],
            backgroundColor: ['#4caf50','#81c784','#66bb6a','#388e3c']
        }]
    },
    options: { responsive:true, scales:{ y:{ beginAtZero:true, max:10 } } }
});

const comparisonChart = new Chart(document.getElementById('comparisonChart').getContext('2d'), {
    type: 'radar',
    data: {
        labels: ['Cold Desert','Hot Desert','Humid Coastal','Dense Jungle'],
        datasets:[{
            label:'Fabric Suitability Score',
            data:[0,0,0,0],
            backgroundColor:'rgba(76,175,80,0.2)',
            borderColor:'#4caf50',
            borderWidth:2
        }]
    },
    options:{ responsive:true, scales:{ r:{ beginAtZero:true, max:10 } } }
});

const sustainabilityChart = new Chart(document.getElementById('sustainabilityChart').getContext('2d'), {
    type:'doughnut',
    data:{
        labels:['Carbon','Water Usage','Chemical Impact','Life Cycle'],
        datasets:[{ data:[0,0,0,0], backgroundColor:['#4caf50','#81c784','#c8e6c9','#a5d6a7'] }]
    },
    options:{ responsive:true }
});

const supplyChainChart = new Chart(document.getElementById('supplyChainChart').getContext('2d'), {
    type:'line',
    data:{
        labels:['Q1','Q2','Q3','Q4'],
        datasets:[{
            label:'Efficiency',
            data:[0,0,0,0],
            borderColor:'#4caf50',
            backgroundColor:'rgba(76,175,80,0.2)',
            fill:true,
            tension:0.3
        }]
    },
    options:{ responsive:true, scales:{ y:{ beginAtZero:true, max:100 } } }
});
</script>
</body>
</html>
