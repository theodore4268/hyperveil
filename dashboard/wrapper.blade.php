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

{{-- HyperVeil styles injected directly into HTML --}}
<style id="hv-global">
*, *::before, *::after { font-family: 'Space Grotesk', sans-serif !important; box-sizing: border-box; }
html, body { background: #07080d !important; color: #eaedf5 !important; }
body.bg-neutral-800 { background: #07080d !important; }

/* Push app content right to make room for sidebar */
#app { margin-left: 210px !important; }

/* Copyright */
body::after {
    content: '© HyperVeil Servers 2026';
    position: fixed; bottom: 8px; left: calc(210px + 50%); transform: translateX(-50%);
    font-family: 'JetBrains Mono', monospace; font-size: 0.55rem; font-weight: 500;
    color: rgba(124,92,252,0.20); letter-spacing: 0.1em; pointer-events: none; z-index: 9997;
}

/* Mobile */
@media (max-width: 768px) {
    #app { margin-left: 0 !important; margin-top: 56px !important; }
    #hv-sidebar { width: 100% !important; height: 56px !important; flex-direction: row !important; border-right: none !important; border-bottom: 1px solid rgba(124,92,252,0.14) !important; overflow-x: auto !important; overflow-y: hidden !important; padding: 0 !important; }
    #hv-sidebar .hv-lbl { display: none !important; }
    #hv-sidebar .hv-logo { display: none !important; }
    #hv-sidebar .hv-serversel { display: none !important; }
    #hv-sidebar .hv-section { flex-direction: row !important; padding: 0 !important; }
    #hv-sidebar .hv-link { padding: 0 0.6rem !important; height: 56px !important; border-left: none !important; border-bottom: 2px solid transparent !important; border-radius: 0 !important; margin: 0 !important; }
    #hv-sidebar .hv-link.hv-active { border-left: none !important; border-bottom-color: #7c5cfc !important; }
    body::after { left: 50%; }
    #hv-banner { left: 0 !important; }
}
</style>

{{-- HyperVeil Sidebar --}}
<div id="hv-sidebar" style="position:fixed;top:0;left:0;width:210px;height:100vh;background:#0c0e15;border-right:1px solid rgba(124,92,252,0.14);display:flex;flex-direction:column;overflow-y:auto;z-index:99999;scrollbar-width:thin;">

    {{-- Logo --}}
    <div class="hv-logo" style="padding:0.95rem 1rem;border-bottom:1px solid rgba(124,92,252,0.14);display:flex;align-items:center;gap:0.55rem;flex-shrink:0;">
        <div style="width:27px;height:27px;background:rgba(124,92,252,0.10);border:1px solid rgba(124,92,252,0.14);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.78rem;color:#a78bfa;flex-shrink:0;">⬡</div>
        <div style="font-size:0.86rem;font-weight:700;letter-spacing:0.03em;color:#eaedf5;"><span style="color:#7c5cfc;">Hyper</span>Veil</div>
    </div>

    {{-- Server selector --}}
    <div class="hv-serversel" style="padding:0.55rem 0.7rem;border-bottom:1px solid rgba(255,255,255,0.055);">
        <div id="hv-srv-sel" style="background:#171a27;border:1px solid rgba(255,255,255,0.055);border-radius:8px;color:#8b8fa8;font-size:0.73rem;padding:0.35rem 0.65rem;display:flex;align-items:center;gap:0.4rem;cursor:pointer;">
            <span>▾</span><span id="hv-srv-name">Select a server</span>
        </div>
    </div>

    {{-- Servers section --}}
    <div class="hv-section" style="padding:0.7rem 0 0.1rem;display:flex;flex-direction:column;">
        <div class="hv-lbl" style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">Servers</div>
        <a href="/" class="hv-link" data-match="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⊞</span>Servers</a>
        <a href="/account" class="hv-link" data-match="account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">◎</span>Account</a>
    </div>

    {{-- Server nav (shown when inside a server) --}}
    <div class="hv-section" id="hv-server-nav" style="padding:0.7rem 0 0.1rem;display:none;flex-direction:column;">
        <div class="hv-lbl" style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">General</div>
        <a href="#" class="hv-link hv-slink" data-page="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">▶</span>Console</a>
        <a href="#" class="hv-link hv-slink" data-page="files" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">◫</span>Files</a>
        <a href="#" class="hv-link hv-slink" data-page="settings" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⚙</span>Settings</a>
        <a href="#" class="hv-link hv-slink" data-page="activity" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">◷</span>Activity</a>
        <div class="hv-lbl" style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0.6rem 1rem 0.25rem;">Management</div>
        <a href="#" class="hv-link hv-slink" data-page="databases" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⬡</span>Databases</a>
        <a href="#" class="hv-link hv-slink" data-page="schedules" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⊛</span>Schedules</a>
        <a href="#" class="hv-link hv-slink" data-page="users" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">◉</span>Users</a>
        <a href="#" class="hv-link hv-slink" data-page="backups" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⟳</span>Backups</a>
        <a href="#" class="hv-link hv-slink" data-page="network" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">⊕</span>Network</a>
        <a href="#" class="hv-link hv-slink" data-page="startup" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">▷</span>Startup</a>
    </div>

    {{-- Bottom config --}}
    <div class="hv-section" style="margin-top:auto;padding:0.6rem 0 0.5rem;border-top:1px solid rgba(255,255,255,0.055);display:flex;flex-direction:column;">
        <div class="hv-lbl" style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;">Config</div>
        <a href="/account" class="hv-link" data-match="account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;"><span style="font-size:0.72rem;width:13px;text-align:center;opacity:0.8;">◉</span>Account</a>
    </div>
</div>

<script>
(function(){
    var ACCENT = '#7c5cfc';
    var PURPLE = '#a78bfa';
    var ACTIVE_BG = 'rgba(124,92,252,0.10)';

    // ── Active nav highlight ──
    function activate(){
        var path = window.location.pathname;

        // Reset all links
        document.querySelectorAll('.hv-link').forEach(function(a){
            a.style.background = '';
            a.style.color = '#8b8fa8';
            a.style.borderLeft = '3px solid transparent';
        });

        // Highlight matching top-level links
        document.querySelectorAll('.hv-link[data-match]').forEach(function(a){
            var m = a.dataset.match;
            var isActive = m === '' ? (path === '/' || (!path.includes('/server/') && !path.includes('/account'))) : path.includes(m);
            if(isActive){
                a.style.background = ACTIVE_BG;
                a.style.color = PURPLE;
                a.style.borderLeft = '3px solid ' + ACCENT;
            }
        });

        // Server nav
        var serverMatch = path.match(/\/server\/([^\/]+)(\/.*)?/);
        var srvNav = document.getElementById('hv-server-nav');

        if(serverMatch){
            srvNav.style.display = 'flex';
            var base = '/server/' + serverMatch[1];
            var subPage = serverMatch[2] ? serverMatch[2].replace(/^\//, '').split('/')[0] : '';

            // Update server sub-links
            document.querySelectorAll('.hv-slink').forEach(function(a){
                var page = a.dataset.page;
                a.href = page ? base + '/' + page : base;
                var isActive = page === '' ? subPage === '' : subPage === page;
                if(isActive){
                    a.style.background = ACTIVE_BG;
                    a.style.color = PURPLE;
                    a.style.borderLeft = '3px solid ' + ACCENT;
                }
            });

            // Get server name
            setTimeout(function(){
                var el = document.querySelector('[class*="ServerConsole"] h1, [class*="server-name"], h1');
                var nameEl = document.getElementById('hv-srv-name');
                if(el && nameEl) nameEl.textContent = el.textContent.trim().substring(0,20);
            }, 1000);
        } else {
            srvNav.style.display = 'none';
        }
    }

    // ── Patch xterm TERMINAL_PRELUDE ──
    // The prelude is hardcoded as '\u001b[1m\u001b[33mcontainer@pterodactyl~ \u001b[0m'
    // We intercept Terminal.writeln to replace it
    function patchXterm(){
        if(window.__hvXtermPatched) return;
        try {
            var origWriteln = window.Terminal && window.Terminal.prototype && window.Terminal.prototype.writeln;
            if(!origWriteln) return;
            window.Terminal.prototype.writeln = function(data){
                if(typeof data === 'string'){
                    data = data.replace(
                        /\u001b\[1m\u001b\[33mcontainer@pterodactyl~ \u001b\[0m/g,
                        '\u001b[1m\u001b[35mhyperveil@container\u001b[0m '
                    );
                }
                return origWriteln.call(this, data);
            };
            window.__hvXtermPatched = true;
        } catch(e){}
    }

    // Hide native top nav once React mounts it
    function hideNativeNav(){
        var nav = document.querySelector('div.w-full.bg-neutral-900');
        if(nav){ nav.style.display = 'none'; }
        var subnav = document.querySelector('[class*="SubNavigation"]');
        if(subnav){ subnav.style.display = 'none'; }
    }

    // Link hover effects
    document.querySelectorAll('.hv-link').forEach(function(a){
        a.addEventListener('mouseover', function(){
            if(!this.classList.contains('hv-active')){
                this.style.background = '#1d2030';
                this.style.color = '#eaedf5';
            }
        });
        a.addEventListener('mouseout', function(){
            if(!this.classList.contains('hv-active')){
                this.style.background = '';
                this.style.color = '#8b8fa8';
            }
        });
    });

    // UUID title patch
    new MutationObserver(function(){
        if(/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title)){
            document.title = document.title.replace(/[a-f0-9-]{36}/i,'hyperveil');
        }
        patchXterm();
        hideNativeNav();
    }).observe(document.head, {childList:true,subtree:true});

    // Also observe body for React mounting
    new MutationObserver(function(){
        hideNativeNav();
        patchXterm();
    }).observe(document.body, {childList:true,subtree:true});

    // React route change detection
    var lastPath = location.pathname;
    setInterval(function(){
        if(location.pathname !== lastPath){
            lastPath = location.pathname;
            activate();
        }
    }, 200);

    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', activate);
    } else {
        activate();
    }

    setTimeout(activate, 500);
    setTimeout(activate, 1500);
})();
</script>
