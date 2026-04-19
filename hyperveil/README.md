# HyperVeil

> Cyber-styled dark theme for [Pterodactyl](https://pterodactyl.io) — purple accents, clean cards, announcement banners, and `hyperveil@container` console branding.

![version](https://img.shields.io/badge/version-1.0.0-7c5cfc?style=flat-square)
![pterodactyl](https://img.shields.io/badge/pterodactyl-1.12.x-a78bfa?style=flat-square)
![blueprint](https://img.shields.io/badge/requires-blueprint-5a3fd4?style=flat-square)
![license](https://img.shields.io/badge/license-MIT-34d399?style=flat-square)

---

## Features

- **Cyber dark UI** — deep backgrounds, purple/violet accents, techy monospace console
- **Arix-inspired layout** — clean sidebar, coloured action buttons, status badges
- **Announcement banner** — dismissible top banner with `info`, `warning`, `danger`, and `success` types
- **`hyperveil@container` branding** — console prefix styled in your accent colour
- **Mobile responsive** — works great on phones and tablets
- **Blueprint compatible** — install other Blueprint extensions alongside it

---

## Requirements

| Requirement | Version |
|---|---|
| Pterodactyl Panel | 1.12.x |
| Blueprint | Latest |
| Node.js | 18+ |
| Yarn | 1.x |

---

## Installation

### One-command install

Run this on your panel server as root:

```bash
git clone https://github.com/YOUR_USERNAME/hyperveil.git
cd hyperveil
sudo bash install.sh
```

The script will:
1. Check for Blueprint and install it if missing
2. Copy all theme files into Blueprint's dev directory
3. Run `blueprint -build` to apply the theme

### Manual install

If you prefer to do it step by step:

```bash
# 1. Install Blueprint if you haven't already
cd /var/www/pterodactyl
curl -Lo blueprint.zip https://github.com/BlueprintFramework/framework/releases/latest/download/blueprint.zip
unzip blueprint.zip && bash blueprint.sh

# 2. Copy theme files
cp -r dashboard admin assets conf.yml /var/www/pterodactyl/.blueprint/dev/

# 3. Build
cd /var/www/pterodactyl
blueprint -build
```

---

## Customisation

### Changing the announcement banner

Edit `dashboard/wrapper.blade.php` and find the `$announcement` array near the top:

```php
$announcement = [
    'visible'   => true,           // true or false
    'type'      => 'info',         // info | warning | danger | success
    'message'   => 'Your message here',
    'link'      => 'https://...',  // optional link
    'link_text' => 'Click here',   // optional link label
];
```

After editing, rebuild:
```bash
cd /var/www/pterodactyl && blueprint -build
```

### Changing colours

All colours are defined as CSS variables at the top of `dashboard/dashboard.css`:

```css
:root {
  --hv-accent:       #7c5cfc;   /* main purple */
  --hv-accent-dim:   #5a3fd4;   /* darker purple for hover */
  --hv-purple-light: #a78bfa;   /* light purple for active nav */
  --hv-bg-deep:      #0a0b0f;   /* darkest background */
  --hv-bg-base:      #0f1117;   /* sidebar background */
  --hv-bg-surface:   #161920;   /* card background */
  /* ... */
}
```

Change any hex value and rebuild.

### Changing the console hostname

The console branding is in `dashboard/wrapper.blade.php`. Find:

```js
const BRAND = 'hyperveil';
```

Change `'hyperveil'` to whatever you want.

---

## Updating

After a Pterodactyl panel update, just re-run the install script to reapply:

```bash
cd hyperveil && sudo bash install.sh
```

---

## Contributing

This is a solo project but PRs and issues are welcome.

- Fork the repo
- Make your changes
- Open a PR with a description of what you changed
- Tag `@claude` in the PR for an automated review

---

## File structure

```
hyperveil/
├── conf.yml                      # Blueprint extension manifest
├── install.sh                    # One-command installer
├── README.md                     # This file
├── assets/
│   └── icon.png                  # Extension icon (shown in Blueprint admin)
├── dashboard/
│   ├── dashboard.css             # Client panel CSS overrides
│   └── wrapper.blade.php         # Announcement banner + hostname branding
└── admin/
    ├── admin.css                 # Admin panel CSS overrides
    └── wrapper.blade.php         # Admin font injection
```

---

## Roadmap

- [x] Cyber dark theme
- [x] Announcement banner
- [x] `hyperveil@container` console branding
- [x] Mobile responsive
- [ ] Server resource pooling (requires Blueprint + Wings work)
- [ ] Admin panel announcement editor (no file editing needed)
- [ ] Light mode variant

---

## License

MIT — do whatever you want with it, credit appreciated but not required.
