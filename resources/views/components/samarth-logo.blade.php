{{--
    SAMARTH Logo Component
    English text with multi-color gradient brush style logo
--}}
<style>
    .samarth-logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: transform 0.3s ease;
    }
    
    .samarth-logo:hover {
        transform: scale(1.02);
    }
    
    .samarth-logo svg {
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
    }
    
    .samarth-logo-text {
        font-family: 'Poppins', 'Arial Black', 'Helvetica Neue', sans-serif;
        font-weight: 900;
        font-size: inherit;
    }
</style>

<a href="{{ route('login') }}" class="samarth-logo" style="{{ $style ?? '' }}">
    <svg width="{{ $width ?? '60' }}" height="{{ $height ?? '40' }}" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="samarthGradient{{ $id ?? '' }}" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#2196F3" />
                <stop offset="25%" style="stop-color:#9C27B0" />
                <stop offset="50%" style="stop-color:#F44336" />
                <stop offset="75%" style="stop-color:#FFEB3B" />
                <stop offset="100%" style="stop-color:#4CAF50" />
            </linearGradient>
        </defs>
        
        <g class="samarth-text">
            <text x="50%" y="65%" text-anchor="middle" font-size="80" font-weight="900" 
                  style="font-family: 'Poppins', 'Arial Black', 'Helvetica Neue', sans-serif;"
                  fill="url(#samarthGradient{{ $id ?? '' }})">
                SAMARTH
            </text>
        </g>
        
        <path d="M330 40 L370 20 L365 55" fill="none" stroke="url(#samarthGradient{{ $id ?? '' }})" stroke-width="5" stroke-linecap="round"/>
    </svg>
</a>

