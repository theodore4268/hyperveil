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

# ── Patch Pterodactyl source files ─────────────────────────────
info "Patching source files..."

CONSOLE="$PANEL_DIR/resources/scripts/components/server/console/Console.tsx"
NAVFILE="$PANEL_DIR/resources/scripts/components/NavigationBar.tsx"
PAGEFILE="$PANEL_DIR/resources/scripts/components/elements/PageContentBlock.tsx"

# 1. Console: change yellow (33m) to purple (35m) and rename container
if [ -f "$CONSOLE" ]; then
    cp "$CONSOLE" "${CONSOLE}.hv-bak" 2>/dev/null || true
    sed -i "s/\\\\u001b\[1m\\\\u001b\[33mcontainer@pterodactyl~ \\\\u001b\[0m/\\\\u001b[1m\\\\u001b[35mhyperveil@container\\\\u001b[0m /g" "$CONSOLE"
    success "Console prelude patched"
fi

# Nav patch removed - leave cyan as-is, override via CSS instead

# 3. PageContentBlock: hide pterodactyl copyright footer
if [ -f "$PAGEFILE" ]; then
    cp "$PAGEFILE" "${PAGEFILE}.hv-bak" 2>/dev/null || true
    # Replace the footer ContentContainer with an empty fragment
    python3 << 'PYEOF'
import re
f = open('/var/www/pterodactyl/resources/scripts/components/elements/PageContentBlock.tsx', 'r')
content = f.read()
f.close()
# Remove the second ContentContainer that has the pterodactyl copyright
content = re.sub(
    r'<ContentContainer css=\{tw`mb-4`\}>.*?</ContentContainer>',
    '',
    content,
    flags=re.DOTALL
)
f = open('/var/www/pterodactyl/resources/scripts/components/elements/PageContentBlock.tsx', 'w')
f.write(content)
f.close()
print('footer removed')
PYEOF
    success "Copyright footer removed"
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
