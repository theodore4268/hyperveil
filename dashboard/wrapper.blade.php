{{-- HyperVeil: Dashboard Wrapper --}}
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

<style id="hv-styles">
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

*, *::before, *::after { font-family: var(--hv-sans) !important; box-sizing: border-box; }
html, body { background: var(--hv-bg-deep) !important; color: var(--hv-text-1) !important; margin: 0 !important; padding: 0 !important; height: 100% !important; }
body.bg-neutral-800 { background: var(--hv-bg-deep) !important; }

/* Hide native top nav and sub nav completely */
div.w-full.bg-neutral-900.shadow-md { display: none !important; }
[class*="SubNavigation"] { display: none !important; }

/* Push main content to make room for our sidebar */
#app { margin-left: 210px !important; min-height: 100vh !important; background: var(--hv-bg-deep) !important; }
[class*="ContentContainer"] { background: var(--hv-bg-deep) !important; min-height: 100vh !important; padding: 1rem !important; }

/* Cards */
[class*="ContentBox__Styled"],
[class*="TitledGreyBox"],
.bg-neutral-700 { background: var(--hv-bg-surface) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-rl) !important; color: var(--hv-text-1) !important; }
h2[class*="ContentBox"] { color: var(--hv-text-1) !important; font-weight: 600 !important; border-bottom: 1px solid var(--hv-border-soft) !important; padding-bottom: 0.6rem !important; }

/* Inputs */
input:not([type="checkbox"]):not([type="radio"]) { background: var(--hv-bg-elevated) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-r) !important; color: var(--hv-text-1) !important; }
input:focus { border-color: var(--hv-accent) !important; outline: none !important; box-shadow: 0 0 0 3px var(--hv-accent-glow) !important; }
textarea, select { background: var(--hv-bg-elevated) !important; border: 1px solid var(--hv-border-soft) !important; border-radius: var(--hv-r) !important; color: var(--hv-text-1) !important; }
label { color: var(--hv-text-2) !important; font-size: 0.78rem !important; font-weight: 500 !important; }

/* Buttons */
button { border-radius: var(--hv-r) !important; font-family: var(--hv-sans) !important; font-weight: 600 !important; transition: all 0.13s !important; }
button[class*="style-module"] { background: var(--hv-accent) !important; color: #fff !important; border: none !important; }
button[class*="style-module"]:hover { background: var(--hv-accent-dim) !important; }

/* Terminal */
div.terminal, div.terminal.xterm, .xterm { background: var(--hv-bg-deep) !important; border: 1px solid var(--hv-border) !important; border-radius: var(--hv-rl) !important; }
.xterm-viewport { background: var(--hv-bg-deep) !important; }
.xterm-screen { background: var(--hv-bg-deep) !important; }
.xterm-rows > div > span:first-child { color: var(--hv-accent) !important; font-weight: 600 !important; }

/* Tailwind overrides */
.bg-neutral-900 { background: var(--hv-bg-base) !important; }
.bg-neutral-800 { background: var(--hv-bg-deep) !important; }
.bg-neutral-700 { background: var(--hv-bg-surface) !important; }
.bg-neutral-600 { background: var(--hv-bg-elevated) !important; }
.text-neutral-100,.text-neutral-200,.text-neutral-300 { color: var(--hv-text-1) !important; }
.text-neutral-400 { color: var(--hv-text-2) !important; }
.text-neutral-500,.text-neutral-600 { color: var(--hv-text-3) !important; }
.border-neutral-700,.border-neutral-600,.border-neutral-800 { border-color: var(--hv-border-soft) !important; }
.shadow-md,.shadow,.shadow-lg { box-shadow: 0 4px 24px rgba(0,0,0,0.4) !important; }
.hover\:bg-neutral-700:hover { background: var(--hv-bg-hover) !important; }
.hover\:bg-neutral-600:hover { background: var(--hv-bg-elevated) !important; }

/* Hide Pterodactyl/Blueprint branding */
[class*="PageContentBlock__StyledP"] { display: none !important; }
[class*="PageContentBlock__StyledA"] { display: none !important; }
a[href*="pterodactyl.io"] { display: none !important; }
a[href*="blueprint.zip"] { display: none !important; }
span.mx-2 { display: none !important; }

/* Copyright */
body::after {
    content: '© HyperVeil Servers 2026';
    position: fixed; bottom: 8px; left: 50%; transform: translateX(-50%);
    font-family: var(--hv-mono); font-size: 0.56rem; font-weight: 500;
    color: rgba(124,92,252,0.22); letter-spacing: 0.1em; pointer-events: none; z-index: 9997;
}

/* Scrollbar */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--hv-bg-base); }
::-webkit-scrollbar-thumb { background: var(--hv-accent-dim); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--hv-accent); }

/* Mobile */
@media (max-width: 768px) {
    #app { margin-left: 0 !important; margin-top: 56px !important; }
    #hv-sidebar { width: 100% !important; height: 56px !important; flex-direction: row !important; border-right: none !important; border-bottom: 1px solid var(--hv-border) !important; overflow-x: auto !important; overflow-y: hidden !important; }
    #hv-sidebar .hv-sb-section { display: flex !important; flex-direction: row !important; padding: 0 !important; }
    #hv-sidebar .hv-sb-label { display: none !important; }
    #hv-sidebar .hv-sb-logo { display: none !important; }
    #hv-topbar { display: none !important; }
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
<div id="hv-sidebar" style="position:fixed;top:0;left:0;width:210px;height:100vh;background:var(--hv-bg-base);border-right:1px solid var(--hv-border);display:flex;flex-direction:column;overflow-y:auto;z-index:99999;">

    {{-- Logo --}}
    <div class="hv-sb-logo" style="padding:1rem;border-bottom:1px solid var(--hv-border);display:flex;align-items:center;gap:0.6rem;flex-shrink:0;">
        <div style="width:28px;height:28px;background:var(--hv-accent-soft);border:1px solid var(--hv-border);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.8rem;color:var(--hv-purple);flex-shrink:0;">⬡</div>
        <div style="font-size:0.88rem;font-weight:700;letter-spacing:0.03em;"><span style="color:var(--hv-accent);">Hyper</span>Veil</div>
    </div>

    {{-- Server selector --}}
    <div style="padding:0.6rem 0.75rem;border-bottom:1px solid var(--hv-border-soft);">
        <div style="background:var(--hv-bg-elevated);border:1px solid var(--hv-border-soft);border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.75rem;padding:0.38rem 0.7rem;display:flex;align-items:center;gap:0.4rem;cursor:pointer;" onclick="document.querySelector('[class*=ServerDropdown], [class*=server-selector], select')?.click()">
            <span>▾</span> <span id="hv-server-name">Select a server</span>
        </div>
    </div>

    {{-- Nav sections --}}
    <div class="hv-sb-section" style="padding:0.75rem 0 0.15rem;">
        <div class="hv-sb-label" style="font-size:0.58rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:var(--hv-text-3);padding:0 1rem 0.28rem;">Servers</div>
        <a href="/" style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;" onmouseover="this.style.background='var(--hv-bg-hover)';this.style.color='var(--hv-text-1)'" onmouseout="this.style.background='';this.style.color='var(--hv-text-2)'"><span style="font-size:0.75rem;width:13px;text-align:center;">⊞</span>Servers</a>
        <a href="/account" style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;" onmouseover="this.style.background='var(--hv-bg-hover)';this.style.color='var(--hv-text-1)'" onmouseout="this.style.background='';this.style.color='var(--hv-text-2)'"><span style="font-size:0.75rem;width:13px;text-align:center;">◎</span>Account</a>
    </div>

    <div class="hv-sb-section" id="hv-server-nav" style="padding:0.75rem 0 0.15rem;display:none;">
        <div class="hv-sb-label" style="font-size:0.58rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:var(--hv-text-3);padding:0 1rem 0.28rem;">General</div>
        <a href="console"    class="hv-nav-link" data-page="console"    style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">▶</span>Console</a>
        <a href="files"      class="hv-nav-link" data-page="files"      style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">◫</span>Files</a>
        <a href="settings"   class="hv-nav-link" data-page="settings"   style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">⚙</span>Settings</a>
        <a href="activity"   class="hv-nav-link" data-page="activity"   style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">◷</span>Activity</a>
        <div class="hv-sb-label" style="font-size:0.58rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:var(--hv-text-3);padding:0.6rem 1rem 0.28rem;">Management</div>
        <a href="databases"  class="hv-nav-link" data-page="databases"  style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">⬡</span>Databases</a>
        <a href="schedules"  class="hv-nav-link" data-page="schedules"  style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">⊛</span>Schedules</a>
        <a href="users"      class="hv-nav-link" data-page="users"      style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">◉</span>Users</a>
        <a href="backups"    class="hv-nav-link" data-page="backups"    style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">⟳</span>Backups</a>
        <a href="network"    class="hv-nav-link" data-page="network"    style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">⊕</span>Network</a>
        <a href="startup"    class="hv-nav-link" data-page="startup"    style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.75rem;width:13px;text-align:center;">▷</span>Startup</a>
    </div>

    {{-- Bottom account --}}
    <div style="margin-top:auto;padding:0.75rem 0 0.5rem;border-top:1px solid var(--hv-border-soft);">
        <div class="hv-sb-label" style="font-size:0.58rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:var(--hv-text-3);padding:0 1rem 0.28rem;">Config</div>
        <a href="/account" style="display:flex;align-items:center;gap:0.5rem;padding:0.4rem 0.75rem;margin:1px 7px;border-radius:var(--hv-r);color:var(--hv-text-2);font-size:0.78rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;" onmouseover="this.style.background='var(--hv-bg-hover)'" onmouseout="this.style.background=''"><span style="font-size:0.75rem;width:13px;text-align:center;">◉</span>Account</a>
    </div>
</div>

<script>
(function(){
    // Active nav highlight
    function setActive(){
        var path = window.location.pathname;
        document.querySelectorAll('.hv-nav-link').forEach(function(a){
            var page = a.dataset.page;
            if(path.indexOf(page) > -1){
                a.style.background = 'var(--hv-accent-soft)';
                a.style.color = 'var(--hv-purple)';
                a.style.borderLeft = '3px solid var(--hv-accent)';
            }
        });

        // Show server nav if on a server page
        if(path.indexOf('/server/') > -1){
            var sn = document.getElementById('hv-server-nav');
            if(sn) sn.style.display = 'block';

            // Build relative links
            var base = path.match(/\/server\/[^\/]+/);
            if(base){
                document.querySelectorAll('.hv-nav-link').forEach(function(a){
                    a.href = base[0] + '/' + a.dataset.page;
                });
            }

            // Try get server name from page
            setTimeout(function(){
                var title = document.querySelector('h1, [class*="ServerName"], [class*="server-name"]');
                if(title){
                    var el = document.getElementById('hv-server-name');
                    if(el) el.textContent = title.textContent.trim().substring(0,22);
                }
            }, 800);
        }
    }

    // xterm branding
    var s = document.createElement('style');
    s.textContent = '.xterm-rows > div > span:first-child { color: #7c5cfc !important; font-weight: 600 !important; }';
    document.head.appendChild(s);

    // UUID title patch
    new MutationObserver(function(){
        if(/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title)){
            document.title = document.title.replace(/[a-f0-9-]{36}/i,'hyperveil');
        }
    }).observe(document.head,{childList:true,subtree:true});

    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', setActive);
    } else {
        setActive();
    }

    // Re-run on React route changes
    var lastPath = location.pathname;
    setInterval(function(){
        if(location.pathname !== lastPath){
            lastPath = location.pathname;
            setActive();
        }
    }, 300);
})();
</script>
