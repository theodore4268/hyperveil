{{-- HyperVeil: Dashboard Wrapper --}}
{{-- Injects styles directly into HTML to override React compiled bundle --}}

@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    $announcement = null;
    try {
        if (Schema::hasTable('hyperveil_announcement')) {
            $announcement = DB::table('hyperveil_announcement')->first();
        }
    } catch (\Exception $e) {
        $announcement = null;
    }
    $colours = [
        'info'    => ['bg' => 'rgba(124,92,252,0.10)', 'border' => 'rgba(124,92,252,0.28)', 'text' => '#a78bfa', 'icon' => '◈'],
        'warning' => ['bg' => 'rgba(251,191,36,0.10)',  'border' => 'rgba(251,191,36,0.28)',  'text' => '#fbbf24', 'icon' => '⚠'],
        'danger'  => ['bg' => 'rgba(248,113,113,0.10)', 'border' => 'rgba(248,113,113,0.28)', 'text' => '#f87171', 'icon' => '✕'],
        'success' => ['bg' => 'rgba(52,211,153,0.10)',  'border' => 'rgba(52,211,153,0.28)',  'text' => '#34d399', 'icon' => '✓'],
    ];
    $c = $colours[$announcement->type ?? 'info'] ?? $colours['info'];
@endphp

{{-- Announcement banner --}}
@if($announcement && $announcement->visible)
<div id="hv-banner" style="background:{{ $c['bg'] }};border-bottom:1px solid {{ $c['border'] }};color:{{ $c['text'] }};font-family:'Space Grotesk',sans-serif;font-size:0.78rem;font-weight:500;padding:0.5rem 1.25rem;display:flex;align-items:center;justify-content:space-between;gap:0.75rem;width:100%;position:relative;z-index:99999;">
    <span style="display:flex;align-items:center;gap:0.45rem;">
        <span style="opacity:0.75;">{{ $c['icon'] }}</span>
        <span>{{ $announcement->message ?? '' }}</span>
        @if($announcement->link)
            <a href="{{ $announcement->link }}" target="_blank" style="color:{{ $c['text'] }};text-decoration:underline;opacity:0.8;margin-left:4px;">{{ $announcement->link_text ?: 'Learn more' }}</a>
        @endif
    </span>
    <button onclick="document.getElementById('hv-banner').remove()" style="background:none;border:none;color:{{ $c['text'] }};opacity:0.5;cursor:pointer;font-size:0.9rem;padding:0;flex-shrink:0;">✕</button>
</div>
@endif

{{-- HyperVeil styles injected directly into HTML head to override React bundle --}}
<style id="hyperveil-styles">
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');

:root {
  --hv-bg-deep:     #07080d;
  --hv-bg-base:     #0c0e15;
  --hv-bg-surface:  #111420;
  --hv-bg-elevated: #171a27;
  --hv-bg-hover:    #1d2030;
  --hv-accent:      #7c5cfc;
  --hv-accent-dim:  #5a3fd4;
  --hv-accent-glow: rgba(124,92,252,0.20);
  --hv-accent-soft: rgba(124,92,252,0.10);
  --hv-purple:      #a78bfa;
  --hv-text-1:      #eaedf5;
  --hv-text-2:      #8b8fa8;
  --hv-text-3:      #454863;
  --hv-border:      rgba(124,92,252,0.14);
  --hv-border-soft: rgba(255,255,255,0.055);
  --hv-green: #34d399; --hv-yellow: #fbbf24; --hv-red: #f87171;
  --hv-mono: 'JetBrains Mono', monospace;
  --hv-sans: 'Space Grotesk', sans-serif;
  --hv-r: 8px; --hv-rl: 12px;
}

/* Force font everywhere */
*, *::before, *::after { font-family: var(--hv-sans) !important; box-sizing: border-box; }

/* Body */
body { background: var(--hv-bg-deep) !important; color: var(--hv-text-1) !important; }
body.bg-neutral-800 { background: var(--hv-bg-deep) !important; }

/* Top navigation */
div.w-full.bg-neutral-900 { background: var(--hv-bg-base) !important; border-bottom: 1px solid var(--hv-border) !important; box-shadow: none !important; }
a.text-2xl { color: var(--hv-purple) !important; font-weight: 700 !important; letter-spacing: 0.02em !important; }

/* Nav links */
div.navigation-link a { color: var(--hv-text-2) !important; transition: color 0.13s !important; font-size: 0.82rem !important; font-weight: 500 !important; }
div.navigation-link a:hover { color: var(--hv-text-1) !important; }
div.navigation-link a.active { color: var(--hv-purple) !important; border-bottom: 2px solid var(--hv-accent) !important; padding-bottom: 2px !important; }
div.navigation-link svg { color: inherit !important; }

/* Sub navigation */
[class*="SubNavigation"] { background: var(--hv-bg-base) !important; border-bottom: 1px solid var(--hv-border) !important; box-shadow: none !important; }
[class*="SubNavigation"] a { color: var(--hv-text-2) !important; font-size: 0.8rem !important; font-weight: 500 !important; border-bottom: 2px solid transparent !important; transition: all 0.13s !important; text-decoration: none !important; }
[class*="SubNavigation"] a:hover { color: var(--hv-text-1) !important; }
[class*="SubNavigation"] a.active { color: var(--hv-purple) !important; border-bottom-color: var(--hv-accent) !important; }

/* Page backgrounds */
[class*="ContentContainer"] { background: var(--hv-bg-deep) !important; }
[class*="Fade__Container"] { background: transparent !important; }
section { background: transparent !important; }

/* Cards */
[class*="ContentBox__Styled"] { background: var(--hv-bg-surface) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-rl) !important; color: var(--hv-text-1) !important; }
[class*="TitledGreyBox"] { background: var(--hv-bg-surface) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-rl) !important; }
h2[class*="ContentBox"] { color: var(--hv-text-1) !important; font-weight: 600 !important; border-bottom: 1px solid var(--hv-border-soft) !important; padding-bottom: 0.75rem !important; margin-bottom: 0.75rem !important; }

/* Server console page stat cards */
[class*="StatBlock"], [class*="stat-block"], [class*="ServerStats"] { background: var(--hv-bg-surface) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-rl) !important; }

/* Inputs */
input:not([type="checkbox"]):not([type="radio"]) { background: var(--hv-bg-elevated) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-r) !important; color: var(--hv-text-1) !important; transition: border-color 0.13s, box-shadow 0.13s !important; }
input:not([type="checkbox"]):not([type="radio"]):focus { border-color: var(--hv-accent) !important; outline: none !important; box-shadow: 0 0 0 3px var(--hv-accent-glow) !important; }
textarea { background: var(--hv-bg-elevated) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-r) !important; color: var(--hv-text-1) !important; }
select { background: var(--hv-bg-elevated) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-r) !important; color: var(--hv-text-1) !important; }
label { color: var(--hv-text-2) !important; font-size: 0.78rem !important; font-weight: 500 !important; }
p.input-help { color: var(--hv-text-3) !important; font-size: 0.72rem !important; }

/* Buttons - primary (blue by default in ptero) */
button[class*="style-module"] { border-radius: var(--hv-r) !important; font-family: var(--hv-sans) !important; font-weight: 600 !important; transition: all 0.13s !important; }
/* Detect background color and restyle */
button { border-radius: var(--hv-r) !important; font-family: var(--hv-sans) !important; font-weight: 600 !important; }

/* Start button (green) */
button[class*="green"], .text-green-700 button { background: rgba(52,211,153,0.15) !important; color: var(--hv-green) !important; border: 1px solid rgba(52,211,153,0.3) !important; }
/* Stop button (red) */  
button[class*="red"], .text-red-700 button { background: rgba(248,113,113,0.12) !important; color: var(--hv-red) !important; border: 1px solid rgba(248,113,113,0.3) !important; }

/* Terminal */
div.terminal, div.terminal.xterm, .xterm { background: var(--hv-bg-deep) !important; border-radius: var(--hv-rl) !important; }
.xterm-viewport { background: var(--hv-bg-deep) !important; border-radius: var(--hv-rl) !important; }
.xterm-screen { background: var(--hv-bg-deep) !important; }
.xterm-rows > div > span:first-child { color: var(--hv-accent) !important; font-weight: 600 !important; }

/* Tailwind neutral overrides - these are what Pterodactyl uses everywhere */
.bg-neutral-900 { background: var(--hv-bg-base) !important; }
.bg-neutral-800 { background: var(--hv-bg-deep) !important; }
.bg-neutral-700 { background: var(--hv-bg-surface) !important; }
.bg-neutral-600 { background: var(--hv-bg-elevated) !important; }
.bg-neutral-500 { background: var(--hv-bg-hover) !important; }
.text-neutral-100, .text-neutral-200, .text-neutral-300 { color: var(--hv-text-1) !important; }
.text-neutral-400 { color: var(--hv-text-2) !important; }
.text-neutral-500, .text-neutral-600 { color: var(--hv-text-3) !important; }
.border-neutral-700, .border-neutral-600, .border-neutral-800 { border-color: var(--hv-border-soft) !important; }
.hover\:bg-neutral-700:hover { background: var(--hv-bg-hover) !important; }
.hover\:bg-neutral-600:hover { background: var(--hv-bg-elevated) !important; }

/* Hover states on nav/rows */
.hover\:text-neutral-100:hover { color: var(--hv-text-1) !important; }
.hover\:text-neutral-300:hover { color: var(--hv-text-1) !important; }

/* Shadow/ring */
.shadow-md, .shadow, .shadow-lg { box-shadow: 0 4px 24px rgba(0,0,0,0.4) !important; }
.ring-1 { --tw-ring-color: var(--hv-border-soft) !important; }

/* Scrollbar */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--hv-bg-base); }
::-webkit-scrollbar-thumb { background: var(--hv-accent-dim); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--hv-accent); }

/* Hide Pterodactyl/Blueprint branding */
a[href*="pterodactyl.io"] { display: none !important; }
a[href*="blueprint.zip"] { display: none !important; }
[class*="PageContentBlock__StyledP"] { display: none !important; }
[class*="PageContentBlock__StyledA"] { display: none !important; }
span.mx-2 { display: none !important; }

/* Copyright */
body::before {
    content: '© HyperVeil Servers 2026';
    position: fixed;
    bottom: 8px;
    left: 50%;
    transform: translateX(-50%);
    font-family: var(--hv-mono);
    font-size: 0.58rem;
    font-weight: 500;
    color: rgba(124,92,252,0.22);
    letter-spacing: 0.1em;
    pointer-events: none;
    z-index: 9998;
}

/* Mobile */
@media (max-width: 768px) {
    [class*="SubNavigation"] a { font-size: 0.7rem !important; }
    .xterm { font-size: 0.68rem !important; }
}
</style>

<script>
(function(){
    // hyperveil@container console branding
    var s = document.createElement('style');
    s.textContent = '.xterm-rows > div > span:first-child { color: #7c5cfc !important; font-weight: 600 !important; }';
    document.head.appendChild(s);

    // UUID title patch
    new MutationObserver(function(){
        if (/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title)){
            document.title = document.title.replace(/[a-f0-9-]{36}/i, 'hyperveil');
        }
    }).observe(document.head, { childList: true, subtree: true });
})();
</script>
