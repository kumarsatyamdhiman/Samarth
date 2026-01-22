@extends('layouts.app')

@section('title')
    <title>Year Progress - SAMARTH</title>
@endsection

@section('styles')
<style>
    :root {
        --saffron: #ea580c;
        --green: #15803d;
        --sky: #0ea5e9;
        --gold: #fbbf24;
        --dark: #020617;
    }
    
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        background: var(--dark);
        color: white;
        font-family: 'Outfit', 'Noto Sans Devanagari', sans-serif;
        overflow: hidden;
    }
    
    /* Full screen container */
    .animation-container {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: linear-gradient(180deg, #020617 0%, #0f172a 50%, #1e1b4b 100%);
    }
    
    /* Canvas layers */
    #bgCanvas, #wheelCanvas, #particleCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }
    
    #bgCanvas { z-index: 1; }
    #wheelCanvas { z-index: 2; }
    #particleCanvas { z-index: 3; }
    
    /* HUD Elements */
    .hud-container {
        position: fixed;
        z-index: 10;
        pointer-events: none;
    }
    
    .day-counter {
        top: 40px;
        right: 20px;
        text-align: right;
    }
    
    .day-counter .number {
        font-size: 3rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--gold), var(--saffron));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }
    
    .day-counter .label {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    .day-counter .status {
        font-size: 0.875rem;
        color: var(--green);
        font-weight: 600;
        margin-top: 5px;
    }
    
    /* Motivational quotes */
    .quote-container {
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        max-width: 90%;
    }
    
    .quote-text {
        font-size: 1.125rem;
        font-weight: 600;
        line-height: 1.6;
        color: white;
        text-shadow: 0 2px 20px rgba(234, 88, 12, 0.5);
        animation: pulseText 2s ease-in-out infinite;
    }
    
    .quote-progress {
        font-size: 0.875rem;
        color: var(--gold);
        margin-top: 10px;
    }
    
    @keyframes pulseText {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.9; transform: scale(1.02); }
    }
    
    /* Progress arc text */
    .arc-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 5;
    }
    
    .arc-text .main {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
    }
    
    .arc-text .sub {
        font-size: 0.875rem;
        color: var(--gold);
        margin-top: 5px;
    }
    
    /* Close button */
    .close-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 20;
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .close-btn:hover {
        background: rgba(234, 88, 12, 0.3);
        border-color: var(--saffron);
        transform: scale(1.1);
    }
    
    .close-btn i {
        color: white;
        font-size: 1.25rem;
    }
    
    /* Time indicator */
    .time-indicator {
        top: 40px;
        left: 20px;
    }
    
    .time-indicator .current-time {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }
    
    .time-indicator .time-period {
        font-size: 0.75rem;
        color: var(--sky);
    }
    
    /* Progress bar */
    .progress-bar-container {
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
    }
    
    .progress-bar {
        height: 6px;
        background: rgba(255,255,255,0.1);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--saffron), var(--gold), var(--green));
        border-radius: 3px;
        transition: width 0.5s ease;
    }
    
    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.625rem;
        color: rgba(255,255,255,0.5);
        margin-top: 5px;
    }
    
    /* Smart village indicators */
    .village-indicators {
        position: absolute;
        bottom: 120px;
        left: 20px;
        display: flex;
        gap: 15px;
        z-index: 6;
    }
    
    .village-indicator {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.6);
    }
    
    .village-indicator .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--green);
        animation: glowDot 2s ease-in-out infinite;
    }
    
    @keyframes glowDot {
        0%, 100% { box-shadow: 0 0 5px var(--green); }
        50% { box-shadow: 0 0 15px var(--green), 0 0 25px var(--green); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 480px) {
        .day-counter .number { font-size: 2.5rem; }
        .arc-text .main { font-size: 1.25rem; }
        .quote-text { font-size: 1rem; }
    }
    
    /* Entrance animation */
    .entrance-overlay {
        position: fixed;
        inset: 0;
        background: var(--dark);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 1s ease, visibility 1s ease;
    }
    
    .entrance-overlay.hidden {
        opacity: 0;
        visibility: hidden;
    }
    
    .entrance-content {
        text-align: center;
    }
    
    .entrance-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .entrance-spinner {
        width: 60px;
        height: 60px;
        border: 3px solid rgba(255,255,255,0.1);
        border-top-color: var(--saffron);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<!-- Entrance Overlay -->
<div class="entrance-overlay" id="entranceOverlay">
    <div class="entrance-content">
        <div class="entrance-spinner"></div>
        <h2 style="margin-top: 20px; color: white;">Year Progress</h2>
    </div>
</div>

<!-- Main Animation Container -->
<div class="animation-container">
    <!-- Background Canvas -->
    <canvas id="bgCanvas"></canvas>
    
    <!-- Wheel Canvas -->
    <canvas id="wheelCanvas"></canvas>
    
    <!-- Particle Canvas -->
    <canvas id="particleCanvas"></canvas>
    
    <!-- Close Button -->
    <button class="close-btn" onclick="closeAnimation()">
        <i class="fas fa-times"></i>
    </button>
    
    <!-- Time Indicator (Left) -->
    <div class="hud-container time-indicator">
        <div class="current-time" id="currentTime">14:02</div>
        <div class="time-period" id="timePeriod">☀️ Afternoon</div>
    </div>
    
    <!-- Day Counter (Right) -->
    <div class="hud-container day-counter">
        <div class="number" id="dayNumber">22</div>
        <div class="label">of 365 Days</div>
        <div class="status" id="statusText">🔥 Momentum Rising</div>
    </div>
    
    <!-- Center Arc Text -->
    <div class="arc-text">
        <div class="main">22/365</div>
        <div class="sub">Days Conquered</div>
    </div>
    
    <!-- Smart Village Indicators -->
    <div class="village-indicators">
        <div class="village-indicator">
            <span class="dot"></span>
            <span>☀️ Solar Active</span>
        </div>
        <div class="village-indicator">
            <span class="dot" style="animation-delay: 0.5s;"></span>
            <span>📡 IoT Connected</span>
        </div>
        <div class="village-indicator">
            <span class="dot" style="animation-delay: 1s;"></span>
            <span>🌾 Smart Farm</span>
        </div>
    </div>
    
    <!-- Quote Container -->
    <div class="hud-container quote-container">
        <div class="quote-text" id="mainQuote">"Every Day Builds the Future"</div>
        <div class="quote-progress" id="progressQuote">343 Days to Mastery</div>
    </div>
    
    <!-- Progress Bar -->
    <div class="hud-container progress-bar-container">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width: 6%;"></div>
        </div>
        <div class="progress-labels">
            <span>Jan 22</span>
            <span>6% Complete</span>
            <span>Dec 31</span>
        </div>
    </div>
</div>

<script>
// ==================== CONFIGURATION ====================
const CONFIG = {
    // Target date: January 22, 2026
    targetDate: new Date(2026, 0, 22),
    totalDays: 365,
    colors: {
        passed: '#ea580c',      // Saffron - days passed
        remaining: 'rgba(255,255,255,0.08)',  // Faded - days remaining
        gold: '#fbbf24',        // Gold - milestones
        green: '#15803d',       // Green - progress
        sky: '#0ea5e9',         // Sky blue
        sun: '#fbbf24',         // Sun color
        moon: '#e2e8f0',        // Moon color
    },
    wheelRadius: 0,
    centerX: 0,
    centerY: 0,
};

// ==================== STATE ====================
let state = {
    currentDay: 22,
    rotation: 0,
    particles: [],
    stars: [],
    clouds: [],
    lastTime: 0,
    istHour: 14, // 2 PM
    istMinute: 2,
};

// ==================== CANVAS SETUP ====================
const bgCanvas = document.getElementById('bgCanvas');
const wheelCanvas = document.getElementById('wheelCanvas');
const particleCanvas = document.getElementById('particleCanvas');
const bgCtx = bgCanvas.getContext('2d');
const wheelCtx = wheelCanvas.getContext('2d');
const particleCtx = particleCanvas.getContext('2d');

function resizeCanvases() {
    const width = window.innerWidth;
    const height = window.innerHeight;
    
    [bgCanvas, wheelCanvas, particleCanvas].forEach(canvas => {
        canvas.width = width;
        canvas.height = height;
    });
    
    // Center of screen for wheel
    CONFIG.centerX = width / 2;
    CONFIG.centerY = height / 2;
    CONFIG.wheelRadius = Math.min(width, height) * 0.32;
}

window.addEventListener('resize', resizeCanvases);
resizeCanvases();

// ==================== TIME & DATE ====================
function updateTime() {
    const now = new Date();
    // IST is UTC+5:30
    const istOffset = 5.5 * 60 * 60 * 1000;
    const istTime = new Date(now.getTime() + istOffset);
    
    state.istHour = istTime.getHours();
    state.istMinute = istTime.getMinutes();
    
    // Update HUD
    document.getElementById('currentTime').textContent = 
        `${state.istHour.toString().padStart(2, '0')}:${state.istMinute.toString().padStart(2, '0')}`;
    
    // Update time period
    let period, periodIcon;
    if (state.istHour >= 5 && state.istHour < 12) {
        period = '🌅 Morning';
    } else if (state.istHour >= 12 && state.istHour < 17) {
        period = '☀️ Afternoon';
    } else if (state.istHour >= 17 && state.istHour < 20) {
        period = '🌆 Evening';
    } else {
        period = '🌙 Night';
    }
    document.getElementById('timePeriod').textContent = period;
}

function getDayOfYear(date) {
    const start = new Date(date.getFullYear(), 0, 0);
    const diff = date - start;
    const oneDay = 1000 * 60 * 60 * 24;
    return Math.floor(diff / oneDay);
}

// ==================== BACKGROUND DRAWING ====================
function initBackground() {
    // Create stars
    for (let i = 0; i < 100; i++) {
        state.stars.push({
            x: Math.random(),
            y: Math.random() * 0.6,
            size: Math.random() * 2 + 0.5,
            twinkle: Math.random() * Math.PI * 2,
            speed: Math.random() * 0.02 + 0.01
        });
    }
    
    // Create clouds
    for (let i = 0; i < 5; i++) {
        state.clouds.push({
            x: Math.random(),
            y: 0.1 + Math.random() * 0.3,
            width: 100 + Math.random() * 150,
            speed: 0.001 + Math.random() * 0.002,
            opacity: 0.3 + Math.random() * 0.3
        });
    }
}

function drawBackground(time) {
    bgCtx.clearRect(0, 0, bgCanvas.width, bgCanvas.height);
    
    // Sky gradient based on time
    const gradient = bgCtx.createLinearGradient(0, 0, 0, bgCanvas.height);
    
    if (state.istHour >= 6 && state.istHour < 18) {
        // Day time
        gradient.addColorStop(0, '#0ea5e9');
        gradient.addColorStop(0.3, '#38bdf8');
        gradient.addColorStop(0.6, '#7dd3fc');
        gradient.addColorStop(1, '#e0f2fe');
    } else if (state.istHour >= 18 && state.istHour < 20) {
        // Evening
        gradient.addColorStop(0, '#1e3a5f');
        gradient.addColorStop(0.4, '#ea580c');
        gradient.addColorStop(0.7, '#f97316');
        gradient.addColorStop(1, '#fbbf24');
    } else {
        // Night
        gradient.addColorStop(0, '#020617');
        gradient.addColorStop(0.5, '#0f172a');
        gradient.addColorStop(1, '#1e1b4b');
    }
    
    bgCtx.fillStyle = gradient;
    bgCtx.fillRect(0, 0, bgCanvas.width, bgCanvas.height);
    
    // Draw stars (at night)
    if (state.istHour < 6 || state.istHour >= 20) {
        state.stars.forEach(star => {
            const twinkle = Math.sin(time * star.speed + star.twinkle) * 0.5 + 0.5;
            bgCtx.beginPath();
            bgCtx.arc(
                star.x * bgCanvas.width,
                star.y * bgCanvas.height,
                star.size * twinkle,
                0,
                Math.PI * 2
            );
            bgCtx.fillStyle = `rgba(255, 255, 255, ${twinkle})`;
            bgCtx.fill();
        });
    }
    
    // Draw clouds (during day)
    if (state.istHour >= 6 && state.istHour < 20) {
        state.clouds.forEach(cloud => {
            cloud.x += cloud.speed;
            if (cloud.x > 1.2) cloud.x = -0.2;
            
            bgCtx.save();
            bgCtx.globalAlpha = cloud.opacity;
            drawCloud(bgCtx, cloud.x * bgCanvas.width, cloud.y * bgCanvas.height, cloud.width);
            bgCtx.restore();
        });
    }
    
    // Draw sun or moon
    drawCelestialBody(time);
    
    // Draw rural landscape silhouette
    drawLandscape(time);
}

function drawCloud(ctx, x, y, width) {
    ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
    ctx.beginPath();
    ctx.arc(x, y, width * 0.25, 0, Math.PI * 2);
    ctx.arc(x + width * 0.25, y - width * 0.1, width * 0.3, 0, Math.PI * 2);
    ctx.arc(x + width * 0.55, y, width * 0.25, 0, Math.PI * 2);
    ctx.fill();
}

function drawCelestialBody(time) {
    const cx = CONFIG.centerX;
    const cy = CONFIG.centerY;
    const orbitRadius = CONFIG.wheelRadius + 60;
    
    // Calculate position based on time
    const dayProgress = (state.istHour + state.istMinute / 60) / 24;
    const angle = (dayProgress * Math.PI * 2) - Math.PI / 2; // Start from top
    
    const x = cx + Math.cos(angle) * orbitRadius;
    const y = cy + Math.sin(angle) * orbitRadius;
    
    if (state.istHour >= 6 && state.istHour < 18) {
        // Sun
        const glowRadius = 30 + Math.sin(time * 0.003) * 5;
        
        // Outer glow
        const gradient = bgCtx.createRadialGradient(x, y, 0, x, y, glowRadius * 2);
        gradient.addColorStop(0, 'rgba(251, 191, 36, 0.8)');
        gradient.addColorStop(0.5, 'rgba(251, 191, 36, 0.3)');
        gradient.addColorStop(1, 'rgba(251, 191, 36, 0)');
        
        bgCtx.beginPath();
        bgCtx.arc(x, y, glowRadius * 2, 0, Math.PI * 2);
        bgCtx.fillStyle = gradient;
        bgCtx.fill();
        
        // Sun core
        bgCtx.beginPath();
        bgCtx.arc(x, y, 20, 0, Math.PI * 2);
        bgCtx.fillStyle = CONFIG.colors.sun;
        bgCtx.fill();
        
        // Sun rays
        for (let i = 0; i < 8; i++) {
            const rayAngle = (i / 8) * Math.PI * 2 + time * 0.001;
            const rayX = x + Math.cos(rayAngle) * 35;
            const rayY = y + Math.sin(rayAngle) * 35;
            
            bgCtx.beginPath();
            bgCtx.moveTo(x, y);
            bgCtx.lineTo(rayX, rayY);
            bgCtx.strokeStyle = 'rgba(251, 191, 36, 0.5)';
            bgCtx.lineWidth = 2;
            bgCtx.stroke();
        }
    } else {
        // Moon
        const glowRadius = 25 + Math.sin(time * 0.002) * 3;
        
        // Moon glow
        const gradient = bgCtx.createRadialGradient(x, y, 0, x, y, glowRadius * 1.5);
        gradient.addColorStop(0, 'rgba(226, 232, 240, 0.6)');
        gradient.addColorStop(1, 'rgba(226, 232, 240, 0)');
        
        bgCtx.beginPath();
        bgCtx.arc(x, y, glowRadius * 1.5, 0, Math.PI * 2);
        bgCtx.fillStyle = gradient;
        bgCtx.fill();
        
        // Moon core
        bgCtx.beginPath();
        bgCtx.arc(x, y, 15, 0, Math.PI * 2);
        bgCtx.fillStyle = CONFIG.colors.moon;
        bgCtx.fill();
        
        // Moon craters
        bgCtx.beginPath();
        bgCtx.arc(x - 4, y - 2, 4, 0, Math.PI * 2);
        bgCtx.fillStyle = 'rgba(148, 163, 184, 0.5)';
        bgCtx.fill();
        
        bgCtx.beginPath();
        bgCtx.arc(x + 5, y + 4, 3, 0, Math.PI * 2);
        bgCtx.fill();
    }
    
    // Trail particles
    if (Math.random() < 0.1) {
        createTrailParticle(x, y, state.istHour >= 6 && state.istHour < 18);
    }
}

function drawLandscape(time) {
    const h = bgCanvas.height;
    const w = bgCanvas.width;
    
    // Multi-layer landscape
    const layers = [
        { y: 0.7, color: 'rgba(15, 23, 42, 0.9)', height: 80 },
        { y: 0.75, color: 'rgba(30, 41, 59, 0.8)', height: 60 },
        { y: 0.8, color: 'rgba(51, 65, 85, 0.7)', height: 50 },
        { y: 0.85, color: 'rgba(71, 85, 105, 0.6)', height: 40 },
    ];
    
    layers.forEach(layer => {
        bgCtx.beginPath();
        bgCtx.moveTo(0, h * layer.y);
        
        // Mountains
        for (let x = 0; x <= w; x += 50) {
            const noise = Math.sin(x * 0.01 + time * 0.0001) * 20;
            bgCtx.lineTo(x, h * layer.y - layer.height + noise);
        }
        
        bgCtx.lineTo(w, h);
        bgCtx.lineTo(0, h);
        bgCtx.closePath();
        bgCtx.fillStyle = layer.color;
        bgCtx.fill();
    });
    
    // Smart village elements (lights)
    if (state.currentDay > 0) {
        const lightCount = Math.min(state.currentDay, 20);
        for (let i = 0; i < lightCount; i++) {
            const x = (w / lightCount) * i + (w / lightCount / 2);
            const y = h * 0.72;
            const size = 2 + Math.sin(time * 0.005 + i) * 1;
            
            bgCtx.beginPath();
            bgCtx.arc(x, y, size, 0, Math.PI * 2);
            bgCtx.fillStyle = 'rgba(251, 191, 36, 0.8)';
            bgCtx.fill();
            
            // Glow
            bgCtx.beginPath();
            bgCtx.arc(x, y, size * 3, 0, Math.PI * 2);
            bgCtx.fillStyle = `rgba(251, 191, 36, ${0.2 + Math.sin(time * 0.005 + i) * 0.1})`;
            bgCtx.fill();
        }
    }
}

// ==================== WHEEL DRAWING ====================
function drawWheel(time) {
    wheelCtx.clearRect(0, 0, wheelCanvas.width, wheelCanvas.height);
    
    const cx = CONFIG.centerX;
    const cy = CONFIG.centerY;
    const radius = CONFIG.wheelRadius;
    const segmentAngle = (Math.PI * 2) / CONFIG.totalDays;
    const strokeWidth = 25;
    
    // Rotate the wheel slowly
    state.rotation += 0.0005;
    
    wheelCtx.save();
    wheelCtx.translate(cx, cy);
    wheelCtx.rotate(state.rotation);
    
    // Draw all segments
    for (let i = 0; i < CONFIG.totalDays; i++) {
        const startAngle = i * segmentAngle - Math.PI / 2;
        const endAngle = startAngle + segmentAngle - 0.02;
        
        wheelCtx.beginPath();
        wheelCtx.arc(0, 0, radius, startAngle, endAngle);
        wheelCtx.strokeStyle = i < state.currentDay ? CONFIG.colors.passed : CONFIG.colors.remaining;
        wheelCtx.lineWidth = strokeWidth;
        wheelCtx.lineCap = 'butt';
        wheelCtx.stroke();
    }
    
    // Draw glowing effect on current position
    const currentAngle = state.currentDay * segmentAngle - Math.PI / 2;
    const glowX = Math.cos(currentAngle) * radius;
    const glowY = Math.sin(currentAngle) * radius;
    
    const glow = wheelCtx.createRadialGradient(glowX, glowY, 0, glowX, glowY, 40);
    glow.addColorStop(0, 'rgba(234, 88, 12, 0.8)');
    glow.addColorStop(1, 'rgba(234, 88, 12, 0)');
    
    wheelCtx.beginPath();
    wheelCtx.arc(glowX, glowY, 40, 0, Math.PI * 2);
    wheelCtx.fillStyle = glow;
    wheelCtx.fill();
    
    // Inner ring (decorative)
    wheelCtx.beginPath();
    wheelCtx.arc(0, 0, radius - strokeWidth - 10, 0, Math.PI * 2);
    wheelCtx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
    wheelCtx.lineWidth = 2;
    wheelCtx.stroke();
    
    // Outer ring (decorative)
    wheelCtx.beginPath();
    wheelCtx.arc(0, 0, radius + strokeWidth / 2 + 5, 0, Math.PI * 2);
    wheelCtx.strokeStyle = 'rgba(251, 191, 36, 0.3)';
    wheelCtx.lineWidth = 1;
    wheelCtx.stroke();
    
    wheelCtx.restore();
    
    // Draw milestone markers
    drawMilestones();
}

function drawMilestones() {
    const cx = CONFIG.centerX;
    const cy = CONFIG.centerY;
    const radius = CONFIG.wheelRadius;
    const segmentAngle = (Math.PI * 2) / CONFIG.totalDays;
    
    // Major milestones (every 30 days)
    [30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330, 360].forEach(day => {
        if (day <= state.currentDay) {
            const angle = day * segmentAngle - Math.PI / 2 + state.rotation;
            const x = cx + Math.cos(angle) * (radius + 20);
            const y = cy + Math.sin(angle) * (radius + 20);
            
            wheelCtx.beginPath();
            wheelCtx.arc(x, y, 4, 0, Math.PI * 2);
            wheelCtx.fillStyle = CONFIG.colors.gold;
            wheelCtx.fill();
            
            // Sparkle effect
            if (state.currentDay === day && Math.random() < 0.3) {
                createSparkle(x, y);
            }
        }
    });
}

// ==================== PARTICLE SYSTEM ====================
function createTrailParticle(x, y, isSun) {
    state.particles.push({
        x: x,
        y: y,
        vx: (Math.random() - 0.5) * 2,
        vy: (Math.random() - 0.5) * 2,
        life: 1,
        decay: 0.02,
        size: 3 + Math.random() * 3,
        color: isSun ? CONFIG.colors.sun : CONFIG.colors.moon,
        type: 'trail'
    });
}

function createSparkle(x, y) {
    for (let i = 0; i < 5; i++) {
        state.particles.push({
            x: x,
            y: y,
            vx: (Math.random() - 0.5) * 8,
            vy: (Math.random() - 0.5) * 8,
            life: 1,
            decay: 0.03,
            size: 2 + Math.random() * 3,
            color: CONFIG.colors.gold,
            type: 'sparkle'
        });
    }
}

function createFirework(x, y) {
    const colors = [CONFIG.colors.passed, CONFIG.colors.gold, CONFIG.colors.green];
    for (let i = 0; i < 20; i++) {
        const angle = (i / 20) * Math.PI * 2;
        state.particles.push({
            x: x,
            y: y,
            vx: Math.cos(angle) * (3 + Math.random() * 3),
            vy: Math.sin(angle) * (3 + Math.random() * 3),
            life: 1,
            decay: 0.015,
            size: 2 + Math.random() * 2,
            color: colors[Math.floor(Math.random() * colors.length)],
            type: 'firework'
        });
    }
}

function updateParticles() {
    particleCtx.clearRect(0, 0, particleCanvas.width, particleCanvas.height);
    
    state.particles = state.particles.filter(p => {
        p.x += p.vx;
        p.y += p.vy;
        p.life -= p.decay;
        p.vx *= 0.98;
        p.vy *= 0.98;
        
        if (p.life > 0) {
            particleCtx.beginPath();
            particleCtx.arc(p.x, p.y, p.size * p.life, 0, Math.PI * 2);
            particleCtx.fillStyle = p.color.replace(')', `, ${p.life})`).replace('rgb', 'rgba').replace('#', '');
            
            // Convert hex to rgba
            if (p.color.startsWith('#')) {
                const r = parseInt(p.color.slice(1, 3), 16);
                const g = parseInt(p.color.slice(3, 5), 16);
                const b = parseInt(p.color.slice(5, 7), 16);
                particleCtx.fillStyle = `rgba(${r}, ${g}, ${b}, ${p.life})`;
            }
            
            particleCtx.fill();
            return true;
        }
        return false;
    });
}

// ==================== HUD UPDATES ====================
function updateHUD() {
    const progress = (state.currentDay / CONFIG.totalDays) * 100;
    
    // Update progress bar
    document.getElementById('progressFill').style.width = `${progress}%`;
    document.querySelector('.progress-labels span:nth-child(2)').textContent = 
        `${Math.round(progress)}% Complete`;
    
    // Update day counter
    document.getElementById('dayNumber').textContent = state.currentDay;
    
    // Update status text
    const statuses = [
        '🌱 Just Beginning',
        '🔥 Gaining Momentum',
        '⚡ Building Power',
        '🚀 Taking Flight',
        '⭐ Approaching Peak',
        '🏆 Almost There!'
    ];
    const statusIndex = Math.min(Math.floor(state.currentDay / 60), statuses.length - 1);
    document.getElementById('statusText').textContent = statuses[statusIndex];
    
    // Update quotes
    const quotes = [
        '"Every Day Builds the Future"',
        '"Progress Fuels Purpose"',
        '"Small Steps, Big Dreams"',
        '"Your Journey Inspires"',
        '"Keep Moving Forward"',
        '"Excellence Takes Time"'
    ];
    const quoteIndex = Math.floor(state.currentDay / 60) % quotes.length;
    document.getElementById('mainQuote').textContent = quotes[quoteIndex];
    
    const daysLeft = CONFIG.totalDays - state.currentDay;
    document.getElementById('progressQuote').textContent = 
        `${daysLeft} Days to Mastery`;
}

// ==================== ANIMATION LOOP ====================
function animate(time) {
    drawBackground(time);
    drawWheel(time);
    updateParticles();
    
    requestAnimationFrame(animate);
}

// ==================== ENTRANCE ANIMATION ====================
function showEntrance() {
    const overlay = document.getElementById('entranceOverlay');
    
    setTimeout(() => {
        overlay.classList.add('hidden');
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 1000);
    }, 1500);
}

// ==================== CLOSE ANIMATION ====================
function closeAnimation() {
    const overlay = document.getElementById('entranceOverlay');
    overlay.style.display = 'flex';
    overlay.classList.remove('hidden');
    
    setTimeout(() => {
        // Go back to home
        window.history.back();
    }, 500);
}

// ==================== INITIALIZATION ====================
function init() {
    updateTime();
    setInterval(updateTime, 1000);
    initBackground();
    updateHUD();
    showEntrance();
    
    // Trigger firework on milestone days
    if (state.currentDay % 30 === 0) {
        setTimeout(() => {
            const angle = (state.currentDay / CONFIG.totalDays) * Math.PI * 2 - Math.PI / 2;
            const x = CONFIG.centerX + Math.cos(angle) * CONFIG.wheelRadius;
            const y = CONFIG.centerY + Math.sin(angle) * CONFIG.wheelRadius;
            createFirework(x, y);
        }, 2000);
    }
    
    requestAnimationFrame(animate);
}

// Start when DOM is ready
document.addEventListener('DOMContentLoaded', init);
</script>
@endsection

