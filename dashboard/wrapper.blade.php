{{-- HyperVeil: Dashboard Wrapper --}}
{{-- Fonts, announcement banner, hyperveil@container branding --}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

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
        'warning' => ['bg' => 'rgba(251,191,36,0.10)', 'border' => 'rgba(251,191,36,0.28)', 'text' => '#fbbf24', 'icon' => '⚠'],
        'danger'  => ['bg' => 'rgba(248,113,113,0.10)', 'border' => 'rgba(248,113,113,0.28)', 'text' => '#f87171', 'icon' => '✕'],
        'success' => ['bg' => 'rgba(52,211,153,0.10)',  'border' => 'rgba(52,211,153,0.28)',  'text' => '#34d399', 'icon' => '✓'],
    ];

    $c = $colours[$announcement->type ?? 'info'] ?? $colours['info'];
@endphp

@if($announcement && $announcement->visible)
<div id="hv-banner" style="
    background: {{ $c['bg'] }};
    border-bottom: 1px solid {{ $c['border'] }};
    color: {{ $c['text'] }};
    font-family: 'Space Grotesk', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 0.55rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    width: 100%;
    position: relative;
    z-index: 9999;
">
    <span style="display:flex;align-items:center;gap:0.45rem;">
        <span style="opacity:0.75;">{{ $c['icon'] }}</span>
        <span>{{ $announcement->message ?? '' }}</span>
        @if($announcement->link)
            <a href="{{ $announcement->link }}" target="_blank"
               style="color:{{ $c['text'] }};text-decoration:underline;opacity:0.8;margin-left:4px;">
                {{ $announcement->link_text ?: 'Learn more' }}
            </a>
        @endif
    </span>
    <button onclick="document.getElementById('hv-banner').remove()"
            style="background:none;border:none;color:{{ $c['text'] }};opacity:0.5;cursor:pointer;font-size:0.9rem;padding:0;flex-shrink:0;"
            aria-label="Dismiss">✕</button>
</div>
@endif

{{-- hyperveil@container console branding --}}
<script>
(function () {
    // Style the xterm prefix span with HyperVeil accent colour
    const s = document.createElement('style');
    s.textContent = '.xterm-rows > div > span:first-child { color: #7c5cfc !important; font-weight: 600; }';
    document.head.appendChild(s);

    // Patch document title if it shows a raw container UUID
    new MutationObserver(function() {
        if (/[a-f0-9]{8}-[a-f0-9]{4}/i.test(document.title)) {
            document.title = document.title.replace(/[a-f0-9-]{36}/i, 'hyperveil');
        }
    }).observe(document.head, { childList: true, subtree: true });
})();
</script>
