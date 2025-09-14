<?php 
session_start(); error_reporting(0);

?>
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Army Fabric AI Dashboard</title>
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            <?php 
            if($_SESSION['user_id'] =="") { 
            ?>
                <div class="user-info">                
                <a href="login.php" class="logout-btn">Login</a>
            </div>

            <?php  } else { ?>
            <div class="user-info">
                <span>🪖 Officer Dashboard</span>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="nav-tabs">
        <div class="nav-tab active" onclick="switchTab('analysis')">🔬 Fabric Analysis</div>
        <div class="nav-tab" onclick="switchTab('comparison')">📊 Multi-Climate Comparison</div>
        <div class="nav-tab" onclick="switchTab('sustainability')">🌱 Sustainability</div>
        <div class="nav-tab" onclick="switchTab('supply-chain')">🚚 Supply Chain</div>
        <div class="nav-tab" onclick="switchTab('reports')">📄 Reports</div>
    </div>
    <div class="main-container">
        <div id="alertContainer"></div>
        <?php include __DIR__ . '/tabs/analysis.php'; ?>
        <?php include __DIR__ . '/tabs/comparison.php'; ?>
        <?php include __DIR__ . '/tabs/sustainability.php'; ?>
        <?php include __DIR__ . '/tabs/supply-chain.php'; ?>
        <?php include __DIR__ . '/tabs/reports.php'; ?>
    </div>
    <script src="script.js"></script>

    <script>
    // Enhanced JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        initializeAnimations();

        // Setup enhanced interactions
        setupEnhancedInteractions();

        // Initialize tooltips
        initializeTooltips();
    });

    function initializeAnimations() {
        // Animate cards on load
        const cards = document.querySelectorAll('.card, .dashboard-card, .content-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });

        // Animate progress bars
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-fill, .progress-inner');
            progressBars.forEach(bar => {
                const targetWidth = bar.style.width || bar.getAttribute('data-width') || '0%';
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = targetWidth;
                }, 500);
            });
        }, 1000);
    }

    function setupEnhancedInteractions() {
        // Enhanced tab switching with smooth transitions
        const navTabs = document.querySelectorAll('.nav-tab');
        navTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                // Remove active class from all tabs
                navTabs.forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');

                // Add ripple effect
                createRippleEffect(e, this);
            });
        });

        // Enhanced button interactions
        const buttons = document.querySelectorAll('.btn, button');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                createRippleEffect(e, this);
            });
        });
    }

    function createRippleEffect(e, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: rgba(212, 175, 55, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
        z-index: 1;
    `;

        element.style.position = 'relative';
        element.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);

        // Add ripple keyframes if not exists
        if (!document.getElementById('ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ripple-styles';
            style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
            document.head.appendChild(style);
        }
    }

    function initializeTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.position = 'relative';
            });
        });
    }

    // Enhanced alert system
    function showEnhancedAlert(message, type = 'success', duration = 5000) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;

        const icon = type === 'success' ? '✅' :
            type === 'warning' ? '⚠️' :
            type === 'error' ? '❌' : 'ℹ️';

        alert.innerHTML = `
        <span style="font-size: 1.2rem;">${icon}</span>
        <div>
            <strong>${message}</strong>
        </div>
        <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: inherit; font-size: 1.2rem; cursor: pointer;">×</button>
    `;

        alertContainer.appendChild(alert);

        setTimeout(() => {
            if (alert.parentElement) {
                alert.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => alert.remove(), 300);
            }
        }, duration);

        // Add slideOut animation if not exists
        if (!document.getElementById('slideout-styles')) {
            const style = document.createElement('style');
            style.id = 'slideout-styles';
            style.textContent = `
            @keyframes slideOut {
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
            document.head.appendChild(style);
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.altKey) {
            switch (e.key) {
                case '1':
                    e.preventDefault();
                    document.querySelector('[onclick*="analysis"]')?.click();
                    break;
                case '2':
                    e.preventDefault();
                    document.querySelector('[onclick*="comparison"]')?.click();
                    break;
                case '3':
                    e.preventDefault();
                    document.querySelector('[onclick*="sustainability"]')?.click();
                    break;
                case '4':
                    e.preventDefault();
                    document.querySelector('[onclick*="supply-chain"]')?.click();
                    break;
                case '5':
                    e.preventDefault();
                    document.querySelector('[onclick*="reports"]')?.click();
                    break;
            }
        }
    });

    // Enhanced logout function
    function logout() {
        if (confirm('🛡️ Are you sure you want to logout from the Army Fabric AI System?')) {
            showEnhancedAlert('Logging out securely...', 'warning', 2000);
            <?php 
            session_destroy();
            header('Location: login.php');
            exit();
            ?>
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        }
    }

    // Welcome message
    setTimeout(() => {
        showEnhancedAlert('🎖️ Welcome to Army Fabric AI Dashboard. All systems operational.', 'success', 4000);
    }, 1000);
    </script>
</body>

</html>