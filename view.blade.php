@extends('layouts.admin')

@section('title', 'HyperVeil — Announcements')

@section('content-header')
    <h1 style="font-family:'Inter',sans-serif;color:#e8eaf0;font-weight:700;letter-spacing:0.02em;">
        <span style="color:#7c5cfc;">⬡</span> HyperVeil
        <small style="color:#8b8fa8;font-weight:400;font-size:0.75em;margin-left:0.5rem;">Announcement Manager</small>
    </h1>
    <ol class="breadcrumb" style="background:transparent;padding:0;">
        <li><a href="/admin" style="color:#7c5cfc;">Admin</a></li>
        <li class="active" style="color:#8b8fa8;">HyperVeil</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        {{-- Success flash --}}
        @if(session('success'))
        <div style="
            background: rgba(52,211,153,0.10);
            border: 1px solid rgba(52,211,153,0.30);
            border-radius: 8px;
            color: #34d399;
            font-family: 'Inter',sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        ">
            <span>✓</span> {{ session('success') }}
        </div>
        @endif

        {{-- Live preview --}}
        <div style="margin-bottom:1.25rem;">
            <p style="color:#8b8fa8;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin-bottom:0.5rem;">
                Live Preview
            </p>
            <div id="hv-preview" style="
                background: rgba(124,92,252,0.12);
                border: 1px solid rgba(124,92,252,0.35);
                border-radius: 8px;
                color: #a78bfa;
                font-family: 'Inter',sans-serif;
                font-size: 0.82rem;
                font-weight: 500;
                padding: 0.6rem 1.25rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
                transition: all 0.2s;
            ">
                <span id="hv-preview-text" style="display:flex;align-items:center;gap:0.5rem;">
                    <span id="hv-preview-icon" style="opacity:0.8;">◈</span>
                    <span id="hv-preview-msg">{{ $announcement->message }}</span>
                </span>
                <span style="opacity:0.4;font-size:0.9rem;">✕</span>
            </div>
        </div>

        {{-- Form card --}}
        <div style="
            background: #161920;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            overflow: hidden;
        ">
            {{-- Card header --}}
            <div style="
                background: #1c1f2a;
                border-bottom: 1px solid rgba(255,255,255,0.06);
                padding: 1rem 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            ">
                <span style="color:#7c5cfc;font-size:1rem;">◈</span>
                <span style="color:#e8eaf0;font-weight:600;font-size:0.9rem;font-family:'Inter',sans-serif;">
                    Announcement Settings
                </span>
            </div>

            {{-- Form body --}}
            <div style="padding:1.5rem;">
                <form method="POST" action="/admin/extensions/hyperveil">
                    @csrf

                    {{-- Visible toggle --}}
                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        background:#1c1f2a;
                        border:1px solid rgba(255,255,255,0.06);
                        border-radius:8px;
                        padding:0.875rem 1rem;
                        margin-bottom:1.25rem;
                    ">
                        <div>
                            <p style="color:#e8eaf0;font-weight:500;font-size:0.875rem;margin:0;font-family:'Inter',sans-serif;">
                                Show announcement
                            </p>
                            <p style="color:#8b8fa8;font-size:0.75rem;margin:0.2rem 0 0;font-family:'Inter',sans-serif;">
                                Toggle the banner on or off for all users
                            </p>
                        </div>
                        {{-- Toggle switch --}}
                        <label style="position:relative;display:inline-block;width:44px;height:24px;flex-shrink:0;">
                            <input type="checkbox" name="visible" id="hv-visible"
                                   {{ $announcement->visible ? 'checked' : '' }}
                                   style="opacity:0;width:0;height:0;position:absolute;">
                            <span id="hv-toggle-track" style="
                                position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;
                                background:{{ $announcement->visible ? '#7c5cfc' : '#2a2d3a' }};
                                border-radius:24px;transition:background 0.2s;
                            "></span>
                            <span id="hv-toggle-thumb" style="
                                position:absolute;content:'';height:18px;width:18px;
                                left:{{ $announcement->visible ? '23px' : '3px' }};bottom:3px;
                                background:#fff;border-radius:50%;transition:left 0.2s;
                            "></span>
                        </label>
                    </div>

                    {{-- Type selector --}}
                    <div style="margin-bottom:1.25rem;">
                        <label style="color:#8b8fa8;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Inter',sans-serif;">
                            Type
                        </label>
                        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;" id="hv-type-grid">
                            @foreach(['info' => ['◈','#7c5cfc','rgba(124,92,252,0.15)'], 'success' => ['✓','#34d399','rgba(52,211,153,0.12)'], 'warning' => ['⚠','#fbbf24','rgba(251,191,36,0.12)'], 'danger' => ['✕','#f87171','rgba(248,113,113,0.12)']] as $type => $meta)
                            <label style="cursor:pointer;">
                                <input type="radio" name="type" value="{{ $type }}"
                                       {{ $announcement->type === $type ? 'checked' : '' }}
                                       style="display:none;" class="hv-type-radio">
                                <div class="hv-type-btn" data-type="{{ $type }}"
                                     data-color="{{ $meta[1] }}" data-bg="{{ $meta[2] }}" data-icon="{{ $meta[0] }}"
                                     style="
                                    background: {{ $announcement->type === $type ? $meta[2] : '#1c1f2a' }};
                                    border: 1px solid {{ $announcement->type === $type ? $meta[1] : 'rgba(255,255,255,0.06)' }};
                                    border-radius: 8px;
                                    padding: 0.6rem;
                                    text-align: center;
                                    transition: all 0.15s;
                                ">
                                    <div style="font-size:1rem;color:{{ $meta[1] }};">{{ $meta[0] }}</div>
                                    <div style="font-size:0.7rem;color:#8b8fa8;font-family:'Inter',sans-serif;margin-top:2px;text-transform:capitalize;">{{ $type }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Message --}}
                    <div style="margin-bottom:1.25rem;">
                        <label style="color:#8b8fa8;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Inter',sans-serif;">
                            Message
                        </label>
                        <textarea name="message" id="hv-message" rows="3"
                                  maxlength="500"
                                  placeholder="Enter your announcement..."
                                  style="
                            width:100%;background:#1c1f2a;border:1px solid rgba(255,255,255,0.08);
                            border-radius:8px;color:#e8eaf0;font-family:'Inter',sans-serif;
                            font-size:0.875rem;padding:0.75rem 1rem;resize:vertical;
                            outline:none;transition:border-color 0.15s;
                        ">{{ $announcement->message }}</textarea>
                        <p style="color:#4a4e63;font-size:0.7rem;margin:0.25rem 0 0;font-family:'Inter',sans-serif;">
                            <span id="hv-char-count">{{ strlen($announcement->message) }}</span>/500 characters
                        </p>
                    </div>

                    {{-- Optional link --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:1.5rem;">
                        <div>
                            <label style="color:#8b8fa8;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Inter',sans-serif;">
                                Link URL <span style="color:#4a4e63;font-weight:400;text-transform:none;">(optional)</span>
                            </label>
                            <input type="url" name="link" value="{{ $announcement->link }}"
                                   placeholder="https://discord.gg/..."
                                   style="
                                width:100%;background:#1c1f2a;border:1px solid rgba(255,255,255,0.08);
                                border-radius:8px;color:#e8eaf0;font-family:'Inter',sans-serif;
                                font-size:0.875rem;padding:0.6rem 1rem;outline:none;
                                transition:border-color 0.15s;
                            ">
                        </div>
                        <div>
                            <label style="color:#8b8fa8;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Inter',sans-serif;">
                                Link Text <span style="color:#4a4e63;font-weight:400;text-transform:none;">(optional)</span>
                            </label>
                            <input type="text" name="link_text" value="{{ $announcement->link_text }}"
                                   placeholder="Join Discord"
                                   maxlength="60"
                                   style="
                                width:100%;background:#1c1f2a;border:1px solid rgba(255,255,255,0.08);
                                border-radius:8px;color:#e8eaf0;font-family:'Inter',sans-serif;
                                font-size:0.875rem;padding:0.6rem 1rem;outline:none;
                                transition:border-color 0.15s;
                            ">
                        </div>
                    </div>

                    {{-- Save button --}}
                    <button type="submit" style="
                        background:#7c5cfc;color:#fff;border:none;border-radius:8px;
                        font-family:'Inter',sans-serif;font-size:0.875rem;font-weight:600;
                        padding:0.7rem 1.75rem;cursor:pointer;transition:background 0.15s;
                        letter-spacing:0.02em;
                    " onmouseover="this.style.background='#5a3fd4'" onmouseout="this.style.background='#7c5cfc'">
                        Save Announcement
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    // Type colours
    const colours = {
        info:    { bg: 'rgba(124,92,252,0.12)', border: 'rgba(124,92,252,0.35)', text: '#a78bfa',  icon: '◈' },
        success: { bg: 'rgba(52,211,153,0.10)',  border: 'rgba(52,211,153,0.30)',  text: '#34d399',  icon: '✓' },
        warning: { bg: 'rgba(251,191,36,0.10)',  border: 'rgba(251,191,36,0.30)',  text: '#fbbf24',  icon: '⚠' },
        danger:  { bg: 'rgba(248,113,113,0.10)', border: 'rgba(248,113,113,0.30)', text: '#f87171',  icon: '✕' },
    };

    const preview     = document.getElementById('hv-preview');
    const previewMsg  = document.getElementById('hv-preview-msg');
    const previewIcon = document.getElementById('hv-preview-icon');
    const message     = document.getElementById('hv-message');
    const charCount   = document.getElementById('hv-char-count');
    const visibleChk  = document.getElementById('hv-visible');
    const track       = document.getElementById('hv-toggle-track');
    const thumb       = document.getElementById('hv-toggle-thumb');

    let currentType = '{{ $announcement->type }}';

    // Update preview colours
    function applyType(type) {
        currentType = type;
        const c = colours[type];
        preview.style.background   = c.bg;
        preview.style.borderColor  = c.border;
        preview.style.color        = c.text;
        previewIcon.textContent    = c.icon;
    }

    // Live message preview
    message.addEventListener('input', function () {
        previewMsg.textContent = this.value || 'Your announcement here...';
        charCount.textContent  = this.value.length;
    });

    // Type radio buttons
    document.querySelectorAll('.hv-type-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const type = this.dataset.type;
            const radio = this.closest('label').querySelector('input[type=radio]');
            radio.checked = true;

            // Reset all buttons
            document.querySelectorAll('.hv-type-btn').forEach(b => {
                b.style.background   = '#1c1f2a';
                b.style.borderColor  = 'rgba(255,255,255,0.06)';
            });

            // Highlight selected
            this.style.background  = this.dataset.bg;
            this.style.borderColor = this.dataset.color;

            applyType(type);
        });
    });

    // Toggle switch
    visibleChk.addEventListener('change', function () {
        if (this.checked) {
            track.style.background = '#7c5cfc';
            thumb.style.left       = '23px';
        } else {
            track.style.background = '#2a2d3a';
            thumb.style.left       = '3px';
        }
    });

    // Input focus styles
    document.querySelectorAll('input[type=text], input[type=url], textarea').forEach(el => {
        el.addEventListener('focus', () => el.style.borderColor = '#7c5cfc');
        el.addEventListener('blur',  () => el.style.borderColor = 'rgba(255,255,255,0.08)');
    });

    // Init preview
    applyType('{{ $announcement->type }}');
    previewMsg.textContent = '{{ addslashes($announcement->message) }}';
})();
</script>
@endsection
