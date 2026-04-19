{{-- HyperVeil — Dashboard Wrapper --}}
{{-- Injects: announcement banner, hostname branding, font import --}}

{{-- Google Fonts: Inter + JetBrains Mono --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

{{-- ============================================================
     ANNOUNCEMENT BANNER
     Edit the message, type, and visible flag below.
     Types: info | warning | danger | success
     Set visible to false to hide the banner.
     ============================================================ --}}
@php
    use Illuminate\Support\Facades\DB;

    $announcement = DB::table('hyperveil_announcement')->first();

    $colours = [
        'info'    => ['bg' => 'rgba(124,92,252,0.12)', 'border' => 'rgba(124,92,252,0.35)', 'text' => '#a78bfa', 'icon' => '◈'],
        'warning' => ['bg' => 'rgba(251,191,36,0.10)', 'border' => 'rgba(251,191,36,0.30)', 'text' => '#fbbf24', 'icon' => '⚠'],
        'danger'  => ['bg' => 'rgba(248,113,113,0.10)', 'border' => 'rgba(248,113,113,0.30)', 'text' => '#f87171', 'icon' => '✕'],
        'success' => ['bg' => 'rgba(52,211,153,0.10)', 'border' => 'rgba(52,211,153,0.30)', 'text' => '#34d399', 'icon' => '✓'],
    ];

    $c = $colours[$announcement->type ?? 'info'] ?? $colours['info'];
@endphp

@if($announcement && $announcement->visible)
<div id="hv-announcement" style="
    background: {{ $c['bg'] }};
    border-bottom: 1px solid {{ $c['border'] }};
    color: {{ $c['text'] }};
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 500;
    padding: 0.6rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    position: relative;
    z-index: 9999;
    width: 100%;
">
    <span style="display:flex;align-items:center;gap:0.5rem;">
        <span style="opacity:0.8;font-size:0.9rem;">{{ $c['icon'] }}</span>
        <span>{{ $announcement->message }}</span>
        @if($announcement->link)
            <a href="{{ $announcement->link }}"
               style="color:{{ $c['text'] }};text-decoration:underline;opacity:0.85;margin-left:0.25rem;">
                {{ $announcement->link_text ?: 'Learn more' }}
            </a>
        @endif
    </span>
    <button onclick="document.getElementById('hv-announcement').style.display='none'"
            style="background:none;border:none;color:{{ $c['text'] }};cursor:pointer;
                   opacity:0.6;font-size:1rem;padding:0;line-height:1;flex-shrink:0;"
            aria-label="Dismiss">✕</button>
</div>
@endif

{{-- ============================================================
     HOSTNAME BRANDING
     Replaces the container hostname shown in the console
     with hyperveil@container via xterm.js title injection.
     ============================================================ --}}
<script>
(function() {
    const BRAND = 'hyperveil';

    // Patch xterm terminal title / prompt prefix once it mounts
    function patchTerminal() {
        // Override document.title if it contains a raw container ID
        const titleObserver = new MutationObserver(() => {
            if (document.title.match(/[a-f0-9]{8}-/i)) {
                document.title = document.title.replace(/[a-f0-9\-]{36}/i, BRAND);
            }
        });
        titleObserver.observe(document.querySelector('title') || document.head, { childList: true, subtree: true });

        // Inject CSS that styles the first span of each xterm row
        // to show the branded prefix colour
        const style = document.createElement('style');
        style.textContent = `
            .xterm-rows > div > span:first-child[style*="color: rgb(34, 197, 94)"],
            .xterm-rows > div > span:first-child[style*="color:#22c55e"] {
                color: #7c5cfc !important;
                font-weight: 600;
            }
        `;
        document.head.appendChild(style);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', patchTerminal);
    } else {
        patchTerminal();
    }
})();
</script>

{{-- ============================================================
     HYPERVEIL FOOTER WATERMARK (subtle, bottom of page)
     ============================================================ --}}
<style>
    /* Subtle HyperVeil tag in bottom-right */
    body::after {
        content: 'HyperVeil';
        position: fixed;
        bottom: 10px;
        right: 14px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.62rem;
        font-weight: 600;
        color: rgba(124, 92, 252, 0.25);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        pointer-events: none;
        z-index: 9998;
    }
</style>
