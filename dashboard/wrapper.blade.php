{{-- HyperVeil Dashboard Wrapper v3 --}}
{{-- All styles injected via <style> tag AFTER JS to guarantee override --}}
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

{{-- HyperVeil Sidebar --}}
<div id="hv-sidebar" style="position:fixed;top:0;left:0;width:210px;height:100vh;background:#0c0e15;border-right:1px solid rgba(124,92,252,0.14);display:flex;flex-direction:column;overflow-y:auto;z-index:99999;">
    <div style="padding:0.95rem 1rem;border-bottom:1px solid rgba(124,92,252,0.14);display:flex;align-items:center;gap:0.55rem;flex-shrink:0;">
        <div style="width:27px;height:27px;background:rgba(124,92,252,0.10);border:1px solid rgba(124,92,252,0.14);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.78rem;color:#a78bfa;flex-shrink:0;">⬡</div>
        <div style="font-size:0.86rem;font-weight:700;letter-spacing:0.03em;color:#eaedf5;font-family:'Space Grotesk',sans-serif;"><span style="color:#7c5cfc;">Hyper</span>Veil</div>
    </div>
    <div style="padding:0.55rem 0.7rem;border-bottom:1px solid rgba(255,255,255,0.055);">
        <div style="background:#171a27;border:1px solid rgba(255,255,255,0.055);border-radius:8px;color:#8b8fa8;font-size:0.73rem;padding:0.35rem 0.65rem;display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;">
            <span>▾</span><span id="hv-srv-name">Select a server</span>
        </div>
    </div>
    <div style="padding:0.7rem 0 0.1rem;">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;font-family:'Space Grotesk',sans-serif;">Servers</div>
        <a href="/" class="hv-link" data-match="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;text-align:center;">⊞</span>Servers</a>
        <a href="/account" class="hv-link" data-match="/account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;text-align:center;">◎</span>Account</a>
    </div>
    <div id="hv-server-nav" style="padding:0.7rem 0 0.1rem;display:none;">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;font-family:'Space Grotesk',sans-serif;">General</div>
        <a href="#" class="hv-link hv-slink" data-page="" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">▶</span>Console</a>
        <a href="#" class="hv-link hv-slink" data-page="files" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">◫</span>Files</a>
        <a href="#" class="hv-link hv-slink" data-page="settings" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">⚙</span>Settings</a>
        <a href="#" class="hv-link hv-slink" data-page="activity" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">◷</span>Activity</a>
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0.6rem 1rem 0.25rem;font-family:'Space Grotesk',sans-serif;">Management</div>
        <a href="#" class="hv-link hv-slink" data-page="databases" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">⬡</span>Databases</a>
        <a href="#" class="hv-link hv-slink" data-page="schedules" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">⊛</span>Schedules</a>
        <a href="#" class="hv-link hv-slink" data-page="users" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">◉</span>Users</a>
        <a href="#" class="hv-link hv-slink" data-page="backups" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">⟳</span>Backups</a>
        <a href="#" class="hv-link hv-slink" data-page="network" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">⊕</span>Network</a>
        <a href="#" class="hv-link hv-slink" data-page="startup" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">▷</span>Startup</a>
    </div>
    <div style="margin-top:auto;padding:0.6rem 0 0.5rem;border-top:1px solid rgba(255,255,255,0.055);">
        <div style="font-size:0.57rem;font-weight:700;letter-spacing:0.13em;text-transform:uppercase;color:#454863;padding:0 1rem 0.25rem;font-family:'Space Grotesk',sans-serif;">Config</div>
        <a href="/account" class="hv-link" data-match="/account" style="display:flex;align-items:center;gap:0.48rem;padding:0.38rem 0.72rem;margin:1px 7px;border-radius:7px;color:#8b8fa8;font-size:0.77rem;font-weight:500;text-decoration:none;transition:all 0.13s;border-left:3px solid transparent;font-family:'Space Grotesk',sans-serif;"><span style="font-size:0.72rem;width:13px;">◉</span>Account</a>
    </div>
</div>

<script>
// ── Run styles injection AFTER React mounts ──
(function(){
    function injectStyles(){
        if(document.getElementById('hv-injected')) return;
        var style = document.createElement('style');
        style.id = 'hv-injected';
        style.textContent = `
            /* ── Font ── */
            *, *::before, *::after { font-family: 'Space Grotesk', sans-serif !important; }

            /* ── Body & layout ── */
            html, body { background: #07080d !important; color: #eaedf5 !important; }
            body.bg-neutral-800 { background: #07080d !important; }
            #app { margin-left: 210px !important; background: #07080d !important; }

            /* ── Hide native nav ── */
            div.w-full.bg-neutral-900.shadow-md { display: none !important; }

            /* ── Page containers ── */
            [class*="ContentContainer"] { background: #07080d !important; }
            [class*="Fade__Container"] { background: transparent !important; }
            section { background: transparent !important; }

            /* ── Server name ── */
            h1.font-header { color: #eaedf5 !important; font-weight: 700 !important; }
            p.text-sm.line-clamp-2 { color: #8b8fa8 !important; }

            /* ── Power buttons ── */
            button[class*="button"][class*="primary"] {
                background: rgba(52,211,153,0.15) !important;
                color: #34d399 !important;
                border: 1px solid rgba(52,211,153,0.3) !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
            }
            button[class*="button"][class*="primary"]:hover:not(:disabled) { background: rgba(52,211,153,0.28) !important; }
            button[class*="button"][class*="primary"]:disabled { opacity: 0.4 !important; }

            button[class*="button"][class*="text"] {
                background: #171a27 !important;
                color: #8b8fa8 !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
            }
            button[class*="button"][class*="text"]:hover:not(:disabled) { background: #1d2030 !important; color: #eaedf5 !important; }

            button[class*="button"][class*="danger"] {
                background: rgba(248,113,113,0.12) !important;
                color: #f87171 !important;
                border: 1px solid rgba(248,113,113,0.28) !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
            }
            button[class*="button"][class*="danger"]:hover:not(:disabled) { background: rgba(248,113,113,0.25) !important; }

            /* ── StatBlocks ── */
            [class*="stat_block"] {
                background: #111420 !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-radius: 10px !important;
                box-shadow: none !important;
            }
            [class*="stat_block"] [class*="icon"] {
                background: rgba(124,92,252,0.10) !important;
                border: 1px solid rgba(124,92,252,0.18) !important;
                border-radius: 8px !important;
            }
            [class*="stat_block"] [class*="icon"] svg { color: #a78bfa !important; }
            [class*="stat_block"] [class*="status_bar"] { background: #5a3fd4 !important; opacity: 0.5; }
            [class*="stat_block"] .bg-red-500 { background: rgba(248,113,113,0.15) !important; }
            [class*="stat_block"] .bg-red-500 svg { color: #f87171 !important; }
            [class*="stat_block"] .bg-yellow-500 { background: rgba(251,191,36,0.12) !important; }
            [class*="stat_block"] .bg-yellow-500 svg { color: #fbbf24 !important; }
            [class*="stat_block"] p { color: #8b8fa8 !important; font-size: 0.72rem !important; }
            [class*="stat_block"] .text-gray-400, [class*="stat_block"] .text-gray-300 { color: #454863 !important; }

            /* ── Terminal ── */
            [class*="terminal"] > [class*="container"] {
                background: #07080d !important;
                border: 1px solid rgba(124,92,252,0.18) !important;
                border-radius: 10px 10px 0 0 !important;
                border-bottom: none !important;
            }
            .bg-black { background: #07080d !important; }
            .xterm-viewport { background: #07080d !important; border-radius: 10px !important; }

            /* Command input */
            input[class*="command_input"] {
                background: #171a27 !important;
                color: #eaedf5 !important;
                font-family: 'JetBrains Mono', monospace !important;
                border-color: transparent !important;
                border-radius: 0 0 10px 10px !important;
                caret-color: #7c5cfc !important;
            }
            input[class*="command_input"]:focus,
            input[class*="command_input"]:active {
                border-color: #7c5cfc !important;
                outline: none !important;
                box-shadow: none !important;
            }
            [class*="command_icon"] { color: #7c5cfc !important; }

            /* Console tabs */
            [class*="overflows_container"] {
                background: #171a27 !important;
                border-radius: 8px 8px 0 0 !important;
            }

            /* ── Charts: .chart_container bg-gray-600 ── */
            [class*="chart_container"] {
                background: #111420 !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-bottom: 3px solid #5a3fd4 !important;
                border-radius: 10px !important;
                box-shadow: none !important;
            }
            [class*="chart_container"] h3 { color: #8b8fa8 !important; font-size: 0.78rem !important; text-transform: uppercase !important; letter-spacing: 0.06em !important; }
            [class*="chart_container"]:hover h3 { color: #eaedf5 !important; }

            /* ── File rows ── */
            [class*="file_row"] {
                background: #111420 !important;
                border-radius: 8px !important;
                margin-bottom: 2px !important;
                border: 1px solid rgba(255,255,255,0.04) !important;
            }
            [class*="file_row"]:hover { background: #171a27 !important; border-color: rgba(124,92,252,0.18) !important; }
            [class*="file_row"] [class*="details"] { color: #8b8fa8 !important; }
            [class*="file_row"]:hover [class*="details"] { color: #eaedf5 !important; }
            [class*="file_row"] .text-neutral-400 { color: #454863 !important; }

            /* ── TitledGreyBox ── */
            .bg-neutral-700.rounded, [class*="TitledGreyBox"] {
                background: #111420 !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-radius: 10px !important;
            }
            .bg-neutral-900.rounded-t {
                background: #171a27 !important;
                border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            }

            /* ── ContentBox ── */
            [class*="ContentBox"] {
                background: #111420 !important;
                border: 1px solid rgba(255,255,255,0.06) !important;
                border-radius: 12px !important;
            }

            /* ── Inputs ── */
            input:not([type='checkbox']):not([class*="command_input"]),
            textarea, select {
                background: #171a27 !important;
                border-color: rgba(255,255,255,0.06) !important;
                border-radius: 8px !important;
                color: #eaedf5 !important;
            }
            input:focus:not([class*="command_input"]), textarea:focus {
                border-color: #7c5cfc !important;
                box-shadow: 0 0 0 3px rgba(124,92,252,0.20) !important;
                outline: none !important;
            }
            label { color: #8b8fa8 !important; }

            /* ── Tailwind overrides ── */
            .bg-neutral-900 { background: #0c0e15 !important; }
            .bg-neutral-800 { background: #07080d !important; }
            .bg-neutral-700 { background: #111420 !important; }
            .bg-neutral-600 { background: #171a27 !important; }
            .bg-neutral-500 { background: #1d2030 !important; }
            .bg-gray-900 { background: #171a27 !important; }
            .bg-gray-700 { background: #171a27 !important; }
            .bg-gray-600 { background: #111420 !important; }
            .bg-gray-500 { background: #1d2030 !important; }

            .text-neutral-100,.text-neutral-200,.text-neutral-300 { color: #eaedf5 !important; }
            .text-neutral-400 { color: #8b8fa8 !important; }
            .text-neutral-500,.text-neutral-600 { color: #454863 !important; }
            .text-gray-50,.text-gray-100,.text-gray-200 { color: #eaedf5 !important; }
            .text-gray-300 { color: #8b8fa8 !important; }
            .text-gray-400 { color: #454863 !important; }

            .border-neutral-700,.border-neutral-600,.border-neutral-800,.border-black { border-color: rgba(255,255,255,0.06) !important; }
            .hover\\:border-neutral-500:hover { border-color: rgba(124,92,252,0.18) !important; }
            .hover\\:bg-neutral-700:hover { background: #1d2030 !important; }
            .hover\\:bg-neutral-600:hover { background: #171a27 !important; }
            .hover\\:text-neutral-100:hover,.hover\\:text-neutral-300:hover { color: #eaedf5 !important; }

            /* Blue → purple */
            .bg-blue-600 { background: #7c5cfc !important; }
            .bg-blue-500 { background: #5a3fd4 !important; }
            .hover\\:bg-blue-500:hover { background: #5a3fd4 !important; }
            .text-blue-50 { color: #fff !important; }

            /* Cyan → purple */
            .text-cyan-400 { color: #a78bfa !important; }
            .border-cyan-500,.focus\\:border-cyan-500:focus,.active\\:border-cyan-500:active { border-color: #7c5cfc !important; }

            /* Shadow */
            .shadow,.shadow-md,.shadow-lg { box-shadow: 0 4px 24px rgba(0,0,0,0.4) !important; }

            /* ── Hide ALL Pterodactyl branding ── */
            [class*="PageContentBlock__StyledP"],
            [class*="PageContentBlock__StyledA"],
            a[href*="pterodactyl.io"],
            a[href*="blueprint.zip"],
            span.mx-2 { display: none !important; }

            /* ── Scrollbar ── */
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: #0c0e15; }
            ::-webkit-scrollbar-thumb { background: #5a3fd4; border-radius: 99px; }
            ::-webkit-scrollbar-thumb:hover { background: #7c5cfc; }

            /* ── Copyright ── */
            #hv-copyright {
                position: fixed; bottom: 8px;
                left: calc(210px + ((100vw - 210px) / 2));
                transform: translateX(-50%);
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.54rem; font-weight: 500;
                color: rgba(124,92,252,0.22);
                letter-spacing: 0.1em; pointer-events: none; z-index: 9997;
            }

            /* ── Mobile ── */
            @media (max-width: 768px) {
                #app { margin-left: 0 !important; margin-top: 56px !important; }
                #hv-sidebar { width: 100% !important; height: 56px !important; flex-direction: row !important; border-right: none !important; border-bottom: 1px solid rgba(124,92,252,0.14) !important; overflow-x: auto !important; overflow-y: hidden !important; }
                #hv-banner { left: 0 !important; top: 56px !important; }
                #hv-copyright { left: 50% !important; }
            }
        `;
        document.head.appendChild(style);

        // Copyright element
        if(!document.getElementById('hv-copyright')){
            var cr = document.createElement('div');
            cr.id = 'hv-copyright';
            cr.textContent = '© HyperVeil Servers 2026';
            document.body.appendChild(cr);
        }
    }

    // ── Patch xterm TERMINAL_PRELUDE ──
    // Intercept Terminal.write and writeln to replace container@pterodactyl
    function patchXterm(){
        if(window.__hvPatched) return;
        // Try patching via MutationObserver watching for xterm canvas
        var xtermObs = new MutationObserver(function(){
            if(!window.__hvPatched && window.Terminal && window.Terminal.prototype){
                ['write','writeln'].forEach(function(method){
                    var orig = window.Terminal.prototype[method];
                    if(orig && !orig.__hv){
                        window.Terminal.prototype[method] = function(data){
                            if(typeof data === 'string'){
                                data = data.replace(/container@pterodactyl~/g, 'hyperveil@container');
                                data = data.replace(/\u001b\[1m\u001b\[33mcontainer@pterodactyl~ \u001b\[0m/g,
                                    '\u001b[1m\u001b[35mhyperveil@container\u001b[0m ');
                            }
                            return orig.call(this, data);
                        };
                        window.Terminal.prototype[method].__hv = true;
                    }
                });
                window.__hvPatched = true;
                xtermObs.disconnect();
            }
        });
        xtermObs.observe(document.body, {childList:true, subtree:true});
    }

    // ── Active nav ──
    function activate(){
        var path = window.location.pathname;
        document.querySelectorAll('.hv-link').forEach(function(a){
            a.style.background = '';
            a.style.color = '#8b8fa8';
            a.style.borderLeft = '3px solid transparent';
        });
        // Top level
        document.querySelectorAll('.hv-link[data-match]').forEach(function(a){
            var m = a.dataset.match;
            var active = m === '' ? path === '/' : path.startsWith(m);
            if(active){ a.style.background='rgba(124,92,252,0.10)'; a.style.color='#a78bfa'; a.style.borderLeft='3px solid #7c5cfc'; }
        });
        // Server nav
        var sm = path.match(/\/server\/([^\/]+)(\/(.+))?/);
        var sn = document.getElementById('hv-server-nav');
        if(sm){
            sn.style.display = 'block';
            var base = '/server/' + sm[1];
            var sub = sm[3] ? sm[3].split('/')[0] : '';
            document.querySelectorAll('.hv-slink').forEach(function(a){
                var pg = a.dataset.page;
                a.href = pg ? base+'/'+pg : base;
                if(pg === sub || (pg===''&&sub==='')){
                    a.style.background='rgba(124,92,252,0.10)';
                    a.style.color='#a78bfa';
                    a.style.borderLeft='3px solid #7c5cfc';
                }
            });
            // Server name
            setTimeout(function(){
                var el = document.querySelector('h1.font-header');
                var ne = document.getElementById('hv-srv-name');
                if(el && ne) ne.textContent = el.textContent.trim().substring(0,20);
            }, 800);
        } else { sn.style.display = 'none'; }
    }

    // Link hover
    document.querySelectorAll('.hv-link').forEach(function(a){
        a.addEventListener('mouseover', function(){
            if(this.style.color !== 'rgb(167, 139, 250)'){
                this.style.background='#1d2030'; this.style.color='#eaedf5';
            }
        });
        a.addEventListener('mouseout', function(){
            if(this.style.color !== 'rgb(167, 139, 250)'){
                this.style.background=''; this.style.color='#8b8fa8';
            }
        });
    });

    // UUID title patch
    new MutationObserver(function(){
        if(/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title))
            document.title = document.title.replace(/[a-f0-9-]{36}/i,'hyperveil');
    }).observe(document.head, {childList:true, subtree:true});

    // Inject styles when body changes (React mounts)
    new MutationObserver(function(){ injectStyles(); }).observe(document.body, {childList:true, subtree:true});

    // React route change
    var lastPath = location.pathname;
    setInterval(function(){
        if(location.pathname !== lastPath){ lastPath=location.pathname; activate(); }
    }, 200);

    injectStyles();
    patchXterm();

    if(document.readyState==='loading'){
        document.addEventListener('DOMContentLoaded', function(){ injectStyles(); activate(); });
    } else { activate(); }

    setTimeout(function(){ injectStyles(); activate(); }, 500);
    setTimeout(function(){ injectStyles(); activate(); }, 1500);
})();
</script>
