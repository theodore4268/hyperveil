@extends('layouts.admin')
@section('title', 'HyperVeil')

@section('content-header')
    <h1 style="font-family:'Space Grotesk',sans-serif;color:#eaedf5;font-weight:700;">
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

    @if(session('success'))
    <div style="background:rgba(52,211,153,0.10);border:1px solid rgba(52,211,153,0.28);border-radius:8px;color:#34d399;font-family:'Space Grotesk',sans-serif;font-size:0.85rem;font-weight:500;padding:0.75rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
        ✓ {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:rgba(248,113,113,0.10);border:1px solid rgba(248,113,113,0.28);border-radius:8px;color:#f87171;font-family:'Space Grotesk',sans-serif;font-size:0.85rem;padding:0.75rem 1rem;margin-bottom:1.25rem;">
        @foreach($errors->all() as $error)
            <div>✕ {{ $error }}</div>
        @endforeach
    </div>
    @endif

    {{-- Live preview --}}
    <p style="color:#4a4e63;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin-bottom:0.4rem;font-family:'Space Grotesk',sans-serif;">Live Preview</p>
    <div id="hv-preview" style="background:rgba(124,92,252,0.10);border:1px solid rgba(124,92,252,0.28);border-radius:8px;color:#a78bfa;font-family:'Space Grotesk',sans-serif;font-size:0.8rem;font-weight:500;padding:0.55rem 1rem;display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;transition:all 0.2s;">
        <span style="display:flex;align-items:center;gap:0.4rem;">
            <span id="hv-prev-icon" style="opacity:0.75;">◈</span>
            <span id="hv-prev-msg">{{ $announcement->message ?? '' }}</span>
        </span>
        <span style="opacity:0.35;font-size:0.85rem;">✕</span>
    </div>

    {{-- Form --}}
    <div style="background:#121520;border:1px solid rgba(255,255,255,0.055);border-radius:12px;overflow:hidden;">

        <div style="background:#181b26;border-bottom:1px solid rgba(255,255,255,0.055);padding:0.9rem 1.25rem;display:flex;align-items:center;gap:0.5rem;">
            <span style="color:#7c5cfc;">◈</span>
            <span style="color:#eaedf5;font-weight:600;font-size:0.875rem;font-family:'Space Grotesk',sans-serif;">Announcement Settings</span>
        </div>

        <div style="padding:1.5rem;">
        <form method="POST" action="/admin/extensions/hyperveil">
            @csrf

            {{-- Toggle --}}
            <div style="display:flex;align-items:center;justify-content:space-between;background:#181b26;border:1px solid rgba(255,255,255,0.055);border-radius:8px;padding:0.85rem 1rem;margin-bottom:1.25rem;">
                <div>
                    <p style="color:#eaedf5;font-weight:500;font-size:0.875rem;margin:0;font-family:'Space Grotesk',sans-serif;">Show announcement</p>
                    <p style="color:#8b8fa8;font-size:0.75rem;margin:0.2rem 0 0;font-family:'Space Grotesk',sans-serif;">Toggle the banner on or off for all users</p>
                </div>
                <label style="position:relative;display:inline-block;width:44px;height:24px;flex-shrink:0;cursor:pointer;">
                    <input type="checkbox" name="visible" id="hv-visible" {{ ($announcement->visible ?? false) ? 'checked' : '' }} style="opacity:0;width:0;height:0;position:absolute;">
                    <span id="hv-track" style="position:absolute;top:0;left:0;right:0;bottom:0;border-radius:24px;transition:background 0.2s;background:{{ ($announcement->visible ?? false) ? '#7c5cfc' : '#2a2d3a' }};"></span>
                    <span id="hv-thumb" style="position:absolute;width:18px;height:18px;bottom:3px;border-radius:50%;background:#fff;transition:left 0.2s;left:{{ ($announcement->visible ?? false) ? '23px' : '3px' }};"></span>
                </label>
            </div>

            {{-- Type --}}
            <div style="margin-bottom:1.25rem;">
                <label style="color:#8b8fa8;font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Space Grotesk',sans-serif;">Type</label>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;">
                    @foreach(['info'=>['◈','#7c5cfc','rgba(124,92,252,0.15)','rgba(124,92,252,0.28)'],'success'=>['✓','#34d399','rgba(52,211,153,0.12)','rgba(52,211,153,0.28)'],'warning'=>['⚠','#fbbf24','rgba(251,191,36,0.12)','rgba(251,191,36,0.28)'],'danger'=>['✕','#f87171','rgba(248,113,113,0.12)','rgba(248,113,113,0.28)']] as $type=>$m)
                    <label style="cursor:pointer;">
                        <input type="radio" name="type" value="{{ $type }}" class="hv-type-radio"
                               {{ ($announcement->type ?? 'info')===$type?'checked':'' }} style="display:none;">
                        <div class="hv-type-btn" data-type="{{ $type }}" data-color="{{ $m[1] }}" data-bg="{{ $m[2] }}" data-border="{{ $m[3] }}" data-icon="{{ $m[0] }}"
                             style="background:{{ ($announcement->type ?? 'info')===$type?$m[2]:'#181b26' }};border:1px solid {{ ($announcement->type ?? 'info')===$type?$m[3]:'rgba(255,255,255,0.055)' }};border-radius:8px;padding:0.6rem;text-align:center;transition:all 0.13s;">
                            <div style="font-size:1rem;color:{{ $m[1] }};">{{ $m[0] }}</div>
                            <div style="font-size:0.68rem;color:#8b8fa8;font-family:'Space Grotesk',sans-serif;margin-top:2px;text-transform:capitalize;">{{ $type }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Message --}}
            <div style="margin-bottom:1.25rem;">
                <label style="color:#8b8fa8;font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Space Grotesk',sans-serif;">Message</label>
                <textarea name="message" id="hv-msg" rows="3" maxlength="500"
                          placeholder="Enter your announcement..."
                          style="width:100%;background:#181b26;border:1px solid rgba(255,255,255,0.08);border-radius:8px;color:#eaedf5;font-family:'Space Grotesk',sans-serif;font-size:0.875rem;padding:0.7rem 1rem;resize:vertical;outline:none;transition:border-color 0.13s;">{{ $announcement->message ?? '' }}</textarea>
                <p style="color:#4a4e63;font-size:0.68rem;margin:0.2rem 0 0;font-family:'Space Grotesk',sans-serif;"><span id="hv-count">{{ strlen((string)($announcement->message ?? '')) }}</span>/500</p>
            </div>

            {{-- Link --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:1.5rem;">
                <div>
                    <label style="color:#8b8fa8;font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Space Grotesk',sans-serif;">Link URL <span style="color:#4a4e63;font-weight:400;text-transform:none;">(optional)</span></label>
                    <input type="url" name="link" value="{{ $announcement->link }}" placeholder="https://discord.gg/..."
                           style="width:100%;background:#181b26;border:1px solid rgba(255,255,255,0.08);border-radius:8px;color:#eaedf5;font-family:'Space Grotesk',sans-serif;font-size:0.875rem;padding:0.6rem 1rem;outline:none;transition:border-color 0.13s;">
                </div>
                <div>
                    <label style="color:#8b8fa8;font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:0.5rem;font-family:'Space Grotesk',sans-serif;">Link Text <span style="color:#4a4e63;font-weight:400;text-transform:none;">(optional)</span></label>
                    <input type="text" name="link_text" value="{{ $announcement->link_text }}" placeholder="Join Discord" maxlength="60"
                           style="width:100%;background:#181b26;border:1px solid rgba(255,255,255,0.08);border-radius:8px;color:#eaedf5;font-family:'Space Grotesk',sans-serif;font-size:0.875rem;padding:0.6rem 1rem;outline:none;transition:border-color 0.13s;">
                </div>
            </div>

            <button type="submit"
                    style="background:#7c5cfc;color:#fff;border:none;border-radius:8px;font-family:'Space Grotesk',sans-serif;font-size:0.875rem;font-weight:600;padding:0.65rem 1.75rem;cursor:pointer;transition:background 0.13s;letter-spacing:0.02em;"
                    onmouseover="this.style.background='#5a3fd4'" onmouseout="this.style.background='#7c5cfc'">
                Save Announcement
            </button>

        </form>
        </div>
    </div>

</div>
</div>

<script>
(function(){
    const colours = {
        info:    {bg:'rgba(124,92,252,0.10)',border:'rgba(124,92,252,0.28)',text:'#a78bfa',icon:'◈'},
        success: {bg:'rgba(52,211,153,0.10)', border:'rgba(52,211,153,0.28)', text:'#34d399',icon:'✓'},
        warning: {bg:'rgba(251,191,36,0.10)', border:'rgba(251,191,36,0.28)', text:'#fbbf24',icon:'⚠'},
        danger:  {bg:'rgba(248,113,113,0.10)',border:'rgba(248,113,113,0.28)',text:'#f87171',icon:'✕'},
    };

    const preview   = document.getElementById('hv-preview');
    const prevMsg   = document.getElementById('hv-prev-msg');
    const prevIcon  = document.getElementById('hv-prev-icon');
    const msg       = document.getElementById('hv-msg');
    const count     = document.getElementById('hv-count');
    const visible   = document.getElementById('hv-visible');
    const track     = document.getElementById('hv-track');
    const thumb     = document.getElementById('hv-thumb');

    function setType(type) {
        const c = colours[type];
        preview.style.background  = c.bg;
        preview.style.borderColor = c.border;
        preview.style.color       = c.text;
        prevIcon.textContent      = c.icon;
    }

    setType({{ json_encode($announcement->type ?? 'info') }});

    msg.addEventListener('input', function(){
        prevMsg.textContent = this.value || 'Your announcement here...';
        count.textContent   = this.value.length;
    });

    document.querySelectorAll('.hv-type-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            this.closest('label').querySelector('input').checked = true;
            document.querySelectorAll('.hv-type-btn').forEach(b => {
                b.style.background  = '#181b26';
                b.style.borderColor = 'rgba(255,255,255,0.055)';
            });
            this.style.background  = this.dataset.bg;
            this.style.borderColor = this.dataset.border;
            setType(this.dataset.type);
        });
    });

    visible.addEventListener('change', function(){
        track.style.background = this.checked ? '#7c5cfc' : '#2a2d3a';
        thumb.style.left       = this.checked ? '23px'   : '3px';
    });

    document.querySelectorAll('input[type=text],input[type=url],textarea').forEach(el => {
        el.addEventListener('focus', () => el.style.borderColor = '#7c5cfc');
        el.addEventListener('blur',  () => el.style.borderColor = 'rgba(255,255,255,0.08)');
    });
})();
</script>
@endsection
