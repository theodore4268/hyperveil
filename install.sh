#!/usr/bin/env bash
# ============================================================
#  HyperVeil — install.sh
# ============================================================

PANEL_DIR="/var/www/pterodactyl"
BLUEPRINT_URL="https://github.com/BlueprintFramework/framework/releases/download/beta-2026-01/release.zip"

PURPLE='\033[0;35m'; GREEN='\033[0;32m'; RED='\033[0;31m'; NC='\033[0m'
info()    { echo -e "  ${PURPLE}[info]${NC}  $1"; }
success() { echo -e "  ${GREEN}[ok]${NC}    $1"; }
error()   { echo -e "  ${RED}[error]${NC} $1"; exit 1; }

echo -e "${PURPLE}"
echo "  ██╗  ██╗██╗   ██╗██████╗ ███████╗██████╗ ██╗   ██╗███████╗██╗██╗"
echo "  ╚═╝  ╚═╝   ╚═╝   ╚═╝     ╚══════╝╚═╝  ╚═╝   ╚═╝   ╚══════╝╚═╝╚══════╝"
echo -e "${NC}"

[ "$EUID" -ne 0 ] && error "Run as root: sudo bash install.sh"
[ ! -d "$PANEL_DIR" ] && error "Panel not found at $PANEL_DIR"
success "Panel found"

# ── Blueprint ──────────────────────────────────────────────────
if command -v blueprint &>/dev/null; then
    success "Blueprint $(blueprint -version 2>/dev/null)"
else
    info "Installing Blueprint..."
    cd "$PANEL_DIR"
    curl -Lo blueprint.zip "$BLUEPRINT_URL" || error "Download failed"
    unzip -o blueprint.zip || error "Unzip failed"
    bash blueprint.sh || error "Blueprint install failed"
    success "Blueprint installed"
fi

# ── Patch source files ─────────────────────────────────────────
info "Patching source files..."

CONSOLE="$PANEL_DIR/resources/scripts/components/server/console/Console.tsx"
NAVFILE="$PANEL_DIR/resources/scripts/components/NavigationBar.tsx"
PAGECONTENT="$PANEL_DIR/resources/scripts/components/elements/PageContentBlock.tsx"

# 1. Terminal prelude: container@pterodactyl~ → hyperveil@container
if [ -f "$CONSOLE" ]; then
    # Backup original
    cp "$CONSOLE" "${CONSOLE}.hv-backup" 2>/dev/null || true
    # Replace the yellow ANSI colour code (33m) with purple (35m) and the text
    python3 -c "
import re, sys
f = open('$CONSOLE', 'r')
content = f.read()
f.close()
content = content.replace(
    r'\u001b[1m\u001b[33mcontainer@pterodactyl~ \u001b[0m',
    r'\u001b[1m\u001b[35mhyperveil@container\u001b[0m '
)
# Also replace as escaped string in JS source
content = content.replace(
    \"'\\\\u001b[1m\\\\u001b[33mcontainer@pterodactyl~ \\\\u001b[0m'\",
    \"'\\\\u001b[1m\\\\u001b[35mhyperveil@container\\\\u001b[0m '\"
)
f = open('$CONSOLE', 'w')
f.write(content)
f.close()
print('patched')
" 2>/dev/null && success "Console prelude patched" || info "Console patch skipped (Python not available)"
fi

# 2. Remove Pterodactyl copyright footer
if [ -f "$PAGECONTENT" ]; then
    cp "$PAGECONTENT" "${PAGECONTENT}.hv-backup" 2>/dev/null || true
    # Comment out the footer <p> tag that contains the copyright
    sed -i 's|<p css={tw`mt-2 text-center text-sm text-neutral-500`}|<p css={tw`hidden`}|g' "$PAGECONTENT" 2>/dev/null || true
    success "Footer patched"
fi

# 3. Nav: change cyan active underline to purple
if [ -f "$NAVFILE" ]; then
    cp "$NAVFILE" "${NAVFILE}.hv-backup" 2>/dev/null || true
    sed -i 's/colors.cyan.600/colors.violet.500/g' "$NAVFILE" 2>/dev/null || true
    sed -i "s/theme\`colors.cyan.600\`/theme\`colors.violet.500\`/g" "$NAVFILE" 2>/dev/null || true
    success "Nav colour patched"
fi

# ── Copy Blueprint extension files ─────────────────────────────
info "Copying extension files..."
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEV="$PANEL_DIR/.blueprint/dev"
mkdir -p "$DEV/admin" "$DEV/dashboard" "$DEV/database" "$DEV/requests"
cp "$SCRIPT_DIR/conf.yml"                     "$DEV/conf.yml"
cp "$SCRIPT_DIR/admin/admin.css"              "$DEV/admin/admin.css"
cp "$SCRIPT_DIR/admin/Controller.php"         "$DEV/admin/Controller.php"
cp "$SCRIPT_DIR/admin/view.blade.php"         "$DEV/admin/view.blade.php"
cp "$SCRIPT_DIR/admin/wrapper.blade.php"      "$DEV/admin/wrapper.blade.php"
cp "$SCRIPT_DIR/dashboard/dashboard.css"      "$DEV/dashboard/dashboard.css"
cp "$SCRIPT_DIR/dashboard/wrapper.blade.php"  "$DEV/dashboard/wrapper.blade.php"
cp "$SCRIPT_DIR/requests/web.php"             "$DEV/requests/web.php"
cp "$SCRIPT_DIR/database/"*.php               "$DEV/database/"
success "Files copied"

# ── Build ──────────────────────────────────────────────────────
info "Building..."
cd "$PANEL_DIR"
blueprint -build || error "Build failed"

echo -e "\n  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${GREEN}  HyperVeil is live! 🎉${NC}"
echo -e "  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"
echo -e "  Announcements: ${PURPLE}https://your-panel/admin/extensions/hyperveil${NC}\n"
