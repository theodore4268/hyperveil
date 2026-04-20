# HyperVeil

> Cyber-styled dark theme for [Pterodactyl](https://pterodactyl.io) — purple accents, announcement banner with admin UI, and `hyperveil@container` console branding.

![version](https://img.shields.io/badge/version-1.1.0-7c5cfc?style=flat-square)
![pterodactyl](https://img.shields.io/badge/pterodactyl-1.12.x-a78bfa?style=flat-square)
![blueprint](https://img.shields.io/badge/blueprint-beta--2026--01-5a3fd4?style=flat-square)
![license](https://img.shields.io/badge/license-MIT-34d399?style=flat-square)

---

## Features

- **Cyber dark UI** — deep backgrounds, purple/violet accents, techy monospace console
- **Arix-inspired layout** — clean sidebar, coloured action buttons, status badges
- **Announcement banner** — dismissible top banner managed from the admin panel
- **Admin UI** — manage announcements at `/admin/extensions/hyperveil`, no file editing needed
- **`hyperveil@container` branding** — console prefix styled in accent colour
- **Mobile responsive**
- **Blueprint compatible** — works alongside other Blueprint extensions

---

## Requirements

| | Version |
|---|---|
| Pterodactyl Panel | 1.12.x |
| Blueprint | beta-2026-01 |

---

## Installation

```bash
git clone https://github.com/YOUR_USERNAME/hyperveil.git
cd hyperveil
sudo bash install.sh
```

The script installs Blueprint if missing, copies all files, and runs `blueprint -build`.

---

## File structure

```
hyperveil/
├── conf.yml                          # Blueprint manifest
├── install.sh                        # One-command installer
├── README.md
├── public/
│   └── icon.png                      # Extension icon (optional)
├── admin/
│   ├── admin.css                     # Admin panel styles
│   ├── Controller.php                # Handles GET + POST for announcement manager
│   ├── view.blade.php                # Announcement manager UI
│   └── wrapper.blade.php             # Injects fonts into admin panel
├── dashboard/
│   ├── dashboard.css                 # Client panel styles
│   └── wrapper.blade.php             # Announcement banner + hostname branding
├── database/
│   └── ..._create_hyperveil_announcement_table.php
└── requests/
    ├── app/                          # (reserved for future controllers)
    ├── views/                        # (reserved for future views)
    └── web.php                       # Route definitions
```

---

## Customising colours

All CSS variables are at the top of `dashboard/dashboard.css` and `admin/admin.css`:

```css
--hv-accent:       #7c5cfc;   /* main purple */
--hv-accent-dim:   #5a3fd4;   /* hover purple */
--hv-purple-light: #a78bfa;   /* active nav */
--hv-bg-deep:      #07080d;   /* darkest bg */
```

Change a value, push to GitHub, then re-run `sudo bash install.sh` on your server.

---

## Updating

After any panel update or theme change:

```bash
cd hyperveil && git pull
sudo bash install.sh
```

---

## Roadmap

- [x] Cyber dark theme
- [x] Announcement banner
- [x] Admin UI for announcements
- [x] `hyperveil@container` console branding
- [x] Mobile responsive
- [ ] Resource pooling (requires Blueprint + Wings work)
- [ ] Light mode

---

## License

MIT
