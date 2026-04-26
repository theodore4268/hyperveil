{{-- HyperVeil Dashboard Wrapper v4 --}}
@php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
    $announcement = null;
    try {
        if (Schema::hasTable('hyperveil_announcement')) {
            $announcement = DB::table('hyperveil_announcement')->first();
        }
    } catch (\Exception $e) { $announcement = null; }
    $colours = [
        'info'    => ['bg'=>'rgba(124,92,252,0.10)','border'=>'rgba(124,92,252,0.28)','text'=>'#a78bfa','icon'=>'◈'],
        'warning' => ['bg'=>'rgba(251,191,36,0.10)', 'border'=>'rgba(251,191,36,0.28)', 'text'=>'#fbbf24','icon'=>'⚠'],
        'danger'  => ['bg'=>'rgba(248,113,113,0.10)','border'=>'rgba(248,113,113,0.28)','text'=>'#f87171','icon'=>'✕'],
        'success' => ['bg'=>'rgba(52,211,153,0.10)', 'border'=>'rgba(52,211,153,0.28)', 'text'=>'#34d399','icon'=>'✓'],
    ];
    $c = $colours[$announcement->type ?? 'info'] ?? $colours['info'];
@endphp

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

{{-- HyperVeil master styles - loaded in <head> via Blueprint wrapper injection --}}
<style id="hv-master">
:root {
    --hv-deep:     #07080d;
    --hv-base:     #0c0e15;
    --hv-surface:  #111420;
    --hv-elevated: #171a27;
    --hv-hover:    #1d2030;
    --hv-accent:   #7c5cfc;
    --hv-dim:      #5a3fd4;
    --hv-glow:     rgba(124,92,252,0.20);
    --hv-soft:     rgba(124,92,252,0.10);
    --hv-purple:   #a78bfa;
    --hv-t1:       #eaedf5;
    --hv-t2:       #8b8fa8;
    --hv-t3:       #454863;
    --hv-border:   rgba(124,92,252,0.14);
    --hv-bsoft:    rgba(255,255,255,0.06);
    --hv-green:    #34d399;
    --hv-yellow:   #fbbf24;
    --hv-red:      #f87171;
}

/* ── Font ── */
*, *::before, *::after { font-family: 'Space Grotesk', sans-serif !important; }

/* ── Body ── */
html, body { background: var(--hv-deep) !important; color: var(--hv-t1) !important; }
body.bg-neutral-800 { background: var(--hv-deep) !important; }

/* ── Sidebar offset ── */
#app { margin-left: 210px !important; background: var(--hv-deep) !important; min-height: 100vh !important; }

/* ── Hide native top nav ── */
div.w-full.bg-neutral-900.shadow-md { display: none !important; }

/* ── Tailwind color overrides - critical ── */
.bg-neutral-900 { background: var(--hv-base) !important; }
.bg-neutral-800 { background: var(--hv-deep) !important; }
.bg-neutral-700 { background: var(--hv-surface) !important; }
.bg-neutral-600 { background: var(--hv-elevated) !important; }
.bg-neutral-500 { background: var(--hv-hover) !important; }
.bg-black       { background: var(--hv-deep) !important; }
.bg-gray-900    { background: var(--hv-elevated) !important; }
.bg-gray-700    { background: var(--hv-elevated) !important; }
.bg-gray-600    { background: var(--hv-surface) !important; }
.bg-gray-500    { background: var(--hv-hover) !important; }
.bg-blue-600    { background: var(--hv-accent) !important; }
.bg-blue-500    { background: var(--hv-dim) !important; }

.text-neutral-100, .text-neutral-200, .text-neutral-300 { color: var(--hv-t1) !important; }
.text-neutral-400 { color: var(--hv-t2) !important; }
.text-neutral-500, .text-neutral-600 { color: var(--hv-t3) !important; }
.text-gray-50, .text-gray-100, .text-gray-200 { color: var(--hv-t1) !important; }
.text-gray-300 { color: var(--hv-t2) !important; }
.text-gray-400 { color: var(--hv-t3) !important; }
.text-blue-50  { color: #fff !important; }
.text-cyan-400 { color: var(--hv-purple) !important; }
.text-cyan-500 { color: var(--hv-accent) !important; }

.border-neutral-700, .border-neutral-600, .border-neutral-800, .border-black { border-color: var(--hv-bsoft) !important; }
.hover\:border-neutral-500:hover { border-color: var(--hv-border) !important; }
.hover\:bg-neutral-700:hover { background: var(--hv-hover) !important; }
.hover\:bg-neutral-600:hover { background: var(--hv-elevated) !important; }
.hover\:bg-blue-500:hover { background: var(--hv-dim) !important; }
.hover\:text-neutral-100:hover, .hover\:text-neutral-300:hover { color: var(--hv-t1) !important; }
.focus\:border-cyan-500:focus, .active\:border-cyan-500:active, .border-cyan-500 { border-color: var(--hv-accent) !important; }
.shadow, .shadow-md, .shadow-lg { box-shadow: 0 4px 24px rgba(0,0,0,0.4) !important; }

/* ── Page ── */
[class*="ContentContainer"] { background: var(--hv-deep) !important; }
[class*="Fade__Container"]  { background: transparent !important; }
section { background: transparent !important; }

/* ── Server rows (GreyRowBox / StatusIndicatorBox) ── */
[class*="GreyRowBox"], [class*="StatusIndicatorBox"] {
    background: var(--hv-surface) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-radius: 10px !important;
    transition: all 0.13s !important;
}
[class*="GreyRowBox"]:hover, [class*="StatusIndicatorBox"]:hover {
    background: var(--hv-elevated) !important;
    border-color: var(--hv-border) !important;
}
[class*="GreyRowBox"] .icon {
    background: var(--hv-soft) !important;
    border: 1px solid var(--hv-border) !important;
    border-radius: 50% !important;
}

/* ── ContentBox ── */
[class*="ContentBox"] {
    background: var(--hv-surface) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-radius: 12px !important;
}
[class*="ContentBox"] h2 {
    color: var(--hv-t1) !important;
    font-weight: 600 !important;
    border-bottom: 1px solid var(--hv-bsoft) !important;
}

/* ── TitledGreyBox ── */
.bg-neutral-700.rounded, [class*="TitledGreyBox"] {
    background: var(--hv-surface) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-radius: 10px !important;
}
.bg-neutral-900.rounded-t {
    background: var(--hv-elevated) !important;
    border-bottom: 1px solid var(--hv-bsoft) !important;
}

/* ── Power buttons ── */
button[class*="button"][class*="primary"] {
    background: rgba(52,211,153,0.15) !important;
    color: var(--hv-green) !important;
    border: 1px solid rgba(52,211,153,0.3) !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    transition: all 0.13s !important;
}
button[class*="button"][class*="primary"]:hover:not(:disabled) { background: rgba(52,211,153,0.28) !important; }
button[class*="button"][class*="primary"]:disabled { opacity: 0.35 !important; }

button[class*="button"][class*="text"] {
    background: var(--hv-elevated) !important;
    color: var(--hv-t2) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    transition: all 0.13s !important;
}
button[class*="button"][class*="text"]:hover:not(:disabled) { background: var(--hv-hover) !important; color: var(--hv-t1) !important; }

button[class*="button"][class*="danger"] {
    background: rgba(248,113,113,0.12) !important;
    color: var(--hv-red) !important;
    border: 1px solid rgba(248,113,113,0.28) !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    transition: all 0.13s !important;
}
button[class*="button"][class*="danger"]:hover:not(:disabled) { background: rgba(248,113,113,0.25) !important; }

/* Generic buttons */
button { border-radius: 8px !important; font-weight: 600 !important; transition: all 0.13s !important; }

/* ── StatBlocks ── */
[class*="stat_block"] {
    background: var(--hv-surface) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-radius: 10px !important;
    box-shadow: none !important;
    transition: border-color 0.13s !important;
}
[class*="stat_block"]:hover { border-color: var(--hv-border) !important; }
[class*="stat_block"] [class*="icon"] {
    background: var(--hv-soft) !important;
    border: 1px solid var(--hv-border) !important;
    border-radius: 8px !important;
}
[class*="stat_block"] [class*="icon"] svg { color: var(--hv-purple) !important; }
[class*="stat_block"] [class*="icon"].bg-red-500 { background: rgba(248,113,113,0.15) !important; border-color: rgba(248,113,113,0.3) !important; }
[class*="stat_block"] [class*="icon"].bg-red-500 svg { color: var(--hv-red) !important; }
[class*="stat_block"] [class*="icon"].bg-yellow-500 { background: rgba(251,191,36,0.12) !important; border-color: rgba(251,191,36,0.28) !important; }
[class*="stat_block"] [class*="icon"].bg-yellow-500 svg { color: var(--hv-yellow) !important; }
[class*="stat_block"] p, [class*="stat_block"] .text-gray-400, [class*="stat_block"] .text-gray-300 { color: var(--hv-t2) !important; font-size: 0.72rem !important; }

/* ── Charts ── */
[class*="chart_container"] {
    background: var(--hv-surface) !important;
    border: 1px solid var(--hv-bsoft) !important;
    border-bottom: 3px solid var(--hv-dim) !important;
    border-radius: 10px !important;
    box-shadow: none !important;
}
[class*="chart_container"] h3 { color: var(--hv-t2) !important; font-size: 0.75rem !important; text-transform: uppercase !important; letter-spacing: 0.06em !important; }

/* ── Terminal ── */
[class*="terminal"] > [class*="container"] {
    background: var(--hv-deep) !important;
    border: 1px solid var(--hv-border) !important;
    border-radius: 10px 10px 0 0 !important;
    border-bottom: none !important;
}
.xterm-viewport { background: var(--hv-deep) !important; }

/* Console tabs */
[class*="overflows_container"] {
    background: var(--hv-elevated) !important;
    border-radius: 8px 8px 0 0 !important;
    border-bottom: 1px solid var(--hv-bsoft) !important;
}

/* Command input */
input[class*="command_input"] {
    background: var(--hv-elevated) !important;
    color: var(--hv-t1) !important;
    font-family: 'JetBrains Mono', monospace !important;
    border-color: transparent !important;
    border-radius: 0 0 10px 10px !important;
    caret-color: var(--hv-accent) !important;
}
input[class*="command_input"]:focus { border-color: var(--hv-accent) !important; outline: none !important; box-shadow: none !important; }
[class*="command_icon"] { color: var(--hv-accent) !important; }

/* ── File rows ── */
[class*="file_row"] {
    background: var(--hv-surface) !important;
    border: 1px solid rgba(255,255,255,0.04) !important;
    border-radius: 8px !important;
    margin-bottom: 2px !important;
    transition: all 0.13s !important;
}
[class*="file_row"]:hover { background: var(--hv-elevated) !important; border-color: var(--hv-border) !important; }
[class*="file_row"] [class*="details"] { color: var(--hv-t2) !important; }
[class*="file_row"]:hover [class*="details"] { color: var(--hv-t1) !important; }

/* ── Inputs ── */
input:not([type='checkbox']):not([class*="command_input"]), textarea, select {
    background: var(--hv-elevated) !important;
    border-color: var(--hv-bsoft) !important;
    border-radius: 8px !important;
    color: var(--hv-t1) !important;
    transition: border-color 0.13s !important;
}
input:not([class*="command_input"]):focus, textarea:focus {
    border-color: var(--hv-accent) !important;
    box-shadow: 0 0 0 3px var(--hv-glow) !important;
    outline: none !important;
}
label { color: var(--hv-t2) !important; font-size: 0.78rem !important; font-weight: 500 !important; }

/* ── Dialogs/Modals ── */
[role="dialog"] {
    background: var(--hv-elevated) !important;
    border: 1px solid var(--hv-border) !important;
    border-radius: 12px !important;
}

/* ── Hide ALL Pterodactyl branding ── */
[class*="PageContentBlock__StyledP"],
[class*="PageContentBlock__StyledA"],
a[href*="pterodactyl.io"],
a[href*="blueprint.zip"],
span.mx-2 { display: none !important; }

/* Hide the © 2015 - 2026 footer completely */
[class*="PageContentBlock"] > [class*="StyledContentContainer2"],
[class*="clrtss"] { display: none !important; }

/* ── Scrollbar ── */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--hv-base); }
::-webkit-scrollbar-thumb { background: var(--hv-dim); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--hv-accent); }

/* ── Mobile ── */
@media (max-width: 768px) {
    #app { margin-left: 0 !important; margin-top: 56px !important; }
    #hv-sidebar { width: 100% !important; height: 56px !important; flex-direction: row !important; border-right: none !important; border-bottom: 1px solid var(--hv-border) !important; overflow-x: auto !important; overflow-y: hidden !important; }
    #hv-banner { left: 0 !important; top: 56px !important; }
}
</style>

{{-- Announcement banner --}}
@if($announcement && $announcement->visible)
<div id="hv-banner" style="position:fixed;top:0;left:210px;right:0;z-index:99998;background:{{ $c['bg'] }};border-bottom:1px solid {{ $c['border'] }};color:{{ $c['text'] }};font-family:'Space Grotesk',sans-serif;font-size:0.78rem;font-weight:500;padding:0.48rem 1.25rem;display:flex;align-items:center;justify-content:space-between;gap:0.75rem;">
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

{{-- HyperVeil Sidebar --}}
<div id="hv-sidebar" style="position:fixed;top:0;left:0;width:210px;height:100vh;background:#0c0e15;border-right:1px solid rgba(124,92,252,0.14);display:flex;flex-direction:column;overflow-y:auto;z-index:99999;">
    <div style="padding:0.95rem 1rem;border-bottom:1px solid rgba(124,92,252,0.14);display:flex;align-items:center;gap:0.55rem;flex-shrink:0;">
        <div style="width:27px;height:27px;background:rgba(124,92,252,0.10);border:1px solid rgba(124,92,252,0.14);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.78rem;color:#a78bfa;flex-shrink:0;">⬡</div>
        <div style="font-size:0.86rem;font-weight:700;letter-spacing:0.03em;color:#eaedf5;"><span style="color:#7c5cfc;">Hyper</span>Veil</div>
    </div>
    <div style="padding:0.55rem 0.7rem;border-bottom:1px solid rgba(255,255,255,0.055);">
        <div style="background:#171a27;border:1px solid rgba(255,255,255,0.055);border-radius:8px;color:#8b8fa8;font-size:0.73rem;padding:0.35rem 0.65rem;display:flex;align-items:center;gap:0.4rem;">
            <span>▾</span><span id="hv-srv-name">Select a server</span>
        </div>
    </div>
    <div style="padding:0.7rem 0 0.1rem;">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">Servers</div>
        <a href="/" class="hv-link" data-match="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;">⊞</span>Servers</a>
        <a href="/account" class="hv-link" data-match="/account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;">◎</span>Account</a>
    </div>
    <div id="hv-server-nav" style="padding:0.7rem 0 0.1rem;display:none;">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">General</div>
        <a href="#" class="hv-link hv-slink" data-page="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">▶</span>Console</a>
        <a href="#" class="hv-link hv-slink" data-page="files" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">◫</span>Files</a>
        <a href="#" class="hv-link hv-slink" data-page="settings" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">⚙</span>Settings</a>
        <a href="#" class="hv-link hv-slink" data-page="activity" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">◷</span>Activity</a>
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0.6rem 1rem 0.25rem;">Management</div>
        <a href="#" class="hv-link hv-slink" data-page="databases" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">⬡</span>Databases</a>
        <a href="#" class="hv-link hv-slink" data-page="schedules" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">⊛</span>Schedules</a>
        <a href="#" class="hv-link hv-slink" data-page="users" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">◉</span>Users</a>
        <a href="#" class="hv-link hv-slink" data-page="backups" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">⟳</span>Backups</a>
        <a href="#" class="hv-link hv-slink" data-page="network" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">⊕</span>Network</a>
        <a href="#" class="hv-link hv-slink" data-page="startup" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">▷</span>Startup</a>
    </div>
    <div style="margin-top:auto;padding:0.6rem 0 0.5rem;border-top:1px solid rgba(255,255,255,0.055);">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">Config</div>
        <a href="/account" class="hv-link" data-match="/account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;">◉</span>Account</a>
    </div>
</div>

{{-- Copyright --}}
<div id="hv-cr" style="position:fixed;bottom:8px;left:calc(210px + (100vw - 210px)/2);transform:translateX(-50%);font-family:'JetBrains Mono',monospace;font-size:0.54rem;font-weight:500;color:rgba(124,92,252,0.22);letter-spacing:0.1em;pointer-events:none;z-index:9997;white-space:nowrap;">© HyperVeil Servers 2026</div>

<script>
(function(){
    var A='#7c5cfc', P='#a78bfa', AB='rgba(124,92,252,0.10)';

    function activate(){
        var path = window.location.pathname;
        document.querySelectorAll('.hv-link').forEach(function(a){
            a.style.background=''; a.style.color='#8b8fa8'; a.style.borderLeft='3px solid transparent';
        });
        document.querySelectorAll('.hv-link[data-match]').forEach(function(a){
            var m=a.dataset.match;
            var on = m==='' ? (path==='/'||(!path.startsWith('/server/')&&!path.startsWith('/account'))) : path.startsWith(m);
            if(on){ a.style.background=AB; a.style.color=P; a.style.borderLeft='3px solid '+A; }
        });
        var sm=path.match(/\/server\/([^\/]+)(\/([^\/]+))?/);
        var sn=document.getElementById('hv-server-nav');
        if(sm){
            sn.style.display='block';
            var base='/server/'+sm[1], sub=sm[3]||'';
            document.querySelectorAll('.hv-slink').forEach(function(a){
                var pg=a.dataset.page;
                a.href=pg?base+'/'+pg:base;
                if(pg===sub){ a.style.background=AB; a.style.color=P; a.style.borderLeft='3px solid '+A; }
            });
            setTimeout(function(){
                var el=document.querySelector('h1.font-header');
                var ne=document.getElementById('hv-srv-name');
                if(el&&ne) ne.textContent=el.textContent.trim().substring(0,20);
            },800);
        } else { sn.style.display='none'; }
    }

    document.querySelectorAll('.hv-link').forEach(function(a){
        a.addEventListener('mouseover',function(){ if(this.style.color!=='rgb(167, 139, 250)'){ this.style.background='#1d2030'; this.style.color='#eaedf5'; }});
        a.addEventListener('mouseout',function(){ if(this.style.color!=='rgb(167, 139, 250)'){ this.style.background=''; this.style.color='#8b8fa8'; }});
    });

    // Hide native nav repeatedly to catch React re-renders
    function hideNav(){
        var nav=document.querySelector('div.w-full.bg-neutral-900');
        if(nav) nav.style.setProperty('display','none','important');
    }

    new MutationObserver(function(){ hideNav(); }).observe(document.body,{childList:true,subtree:true});
    new MutationObserver(function(){
        if(/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title))
            document.title=document.title.replace(/[a-f0-9-]{36}/i,'hyperveil');
    }).observe(document.head,{childList:true,subtree:true});

    var lastPath=location.pathname;
    setInterval(function(){ if(location.pathname!==lastPath){ lastPath=location.pathname; activate(); } },200);

    hideNav(); activate();
    setTimeout(function(){ hideNav(); activate(); },300);
    setTimeout(function(){ hideNav(); activate(); },1000);
    setTimeout(function(){ hideNav(); activate(); },2500);
})();
</script>
