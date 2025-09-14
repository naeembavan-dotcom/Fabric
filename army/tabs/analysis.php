<div id="analysis" class="tab-content active">
    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header"><div class="card-icon">🌡️</div><h3 class="card-title">Climate & Environmental Data</h3></div>
            <div class="input-row-3">
                <div class="input-group"><label class="input-label">Temperature (°C)</label><input type="number" class="input-field" id="temperature" value="25"></div>
                <div class="input-group"><label class="input-label">Humidity (%)</label><input type="number" class="input-field" id="humidity" value="60"></div>
                <div class="input-group"><label class="input-label">Altitude (m)</label><input type="number" class="input-field" id="altitude" value="1000"></div>
            </div>
            <div class="input-group"><label class="input-label">Terrain Type</label><select class="select-field" id="terrain"><option value="cold-desert">Cold Desert</option><option value="hot-desert">Hot Desert</option><option value="humid-coastal">Humid Coastal</option><option value="dense-jungle">Dense Jungle</option></select></div>
            <div class="input-group"><label class="input-label">Mission Duration</label><select class="select-field" id="missionDuration"><option value="short">Short</option><option value="medium">Medium</option><option value="long">Long</option></select></div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-icon">🧵</div><h3 class="card-title">Fabric Properties</h3></div>
            <div class="input-row"><div class="input-group"><label class="input-label">Weight (gsm)</label><input type="number" class="input-field" id="fabricWeight" value="200"></div><div class="input-group"><label class="input-label">Breathability (1-10)</label><input type="number" class="input-field" id="breathability" value="6" min="1" max="10"></div></div>
            <div class="input-row"><div class="input-group"><label class="input-label">Insulation (1-10)</label><input type="number" class="input-field" id="insulation" value="5" min="1" max="10"></div><div class="input-group"><label class="input-label">Tensile Strength (MPa)</label><input type="number" class="input-field" id="tensileStrength" value="45"></div></div>
            <div class="input-row"><div class="input-group"><label class="input-label">Moisture Absorption (%)</label><input type="number" class="input-field" id="moistureAbsorption" value="15"></div><div class="input-group"><label class="input-label">Durability (1-10)</label><input type="number" class="input-field" id="durability" value="7" min="1" max="10"></div></div>
            <div class="input-group"><label class="input-label">Recyclability (%)</label><input type="number" class="input-field" id="recyclability" value="65" min="0" max="100"></div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-icon">🤖</div><h3 class="card-title">AI/ML Analysis Control</h3></div>
            <div class="input-group"><label class="input-label">Analysis Type</label><select class="select-field" id="analysisType"><option value="performance">Performance</option><option value="multi-objective">Multi-Objective</option></select></div>
            <div class="input-group"><label class="input-label">Priority Weighting</label><select class="select-field" id="priorityWeight"><option value="balanced">Balanced</option><option value="performance">Performance</option><option value="sustainability">Sustainability</option></select></div>
            <button class="btn-primary" onclick="runComprehensiveAnalysis()"><span id="analyzeText">🚀 Run AI/ML Analysis</span></button>
        </div>
    </div>

    <div class="wide-grid">
        <div class="card">
            <div class="card-header"><div class="card-icon">📈</div><h3 class="card-title">Fabric Performance Prediction</h3></div>
            <div class="chart-container"><canvas id="performanceChart"></canvas></div>
            <div class="status-grid">
                <div class="status-item"><div class="status-value" id="thermalComfort">--</div><div class="status-label">Thermal Comfort</div></div>
                <div class="status-item"><div class="status-value" id="moistureManagement">--</div><div class="status-label">Moisture Management</div></div>
                <div class="status-item"><div class="status-value" id="durabilityScore">--</div><div class="status-label">Expected Durability</div></div>
                <div class="status-item"><div class="status-value" id="overallSuitability">--</div><div class="status-label">Overall Suitability</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><div class="card-icon">💡</div><h3 class="card-title">AI Recommendations</h3></div>
            <div id="recommendationsContainer">
                <div class="recommendation-item"><div class="recommendation-title">📋 Ready for Analysis</div><div class="recommendation-desc">Configure and run AI analysis.</div></div>
            </div>
        </div>
    </div>
</div>
