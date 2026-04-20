#!/usr/bin/env bash
# ============================================================
#  HyperVeil — install.sh
#  Installs Blueprint then builds the HyperVeil theme.
#  Run as root: sudo bash install.sh
# ============================================================

PANEL_DIR="/var/www/pterodactyl"
BLUEPRINT_URL="https://github.com/BlueprintFramework/framework/releases/download/beta-2026-01/release.zip"

PURPLE='\033[0;35m'
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

info()    { echo -e "  ${PURPLE}[info]${NC}  $1"; }
success() { echo -e "  ${GREEN}[ok]${NC}    $1"; }
error()   { echo -e "  ${RED}[error]${NC} $1"; exit 1; }

echo -e "${PURPLE}"
echo "  ██╗  ██╗██╗   ██╗██████╗ ███████╗██████╗ ██╗   ██╗███████╗██╗██╗      "
echo "  ██║  ██║╚██╗ ██╔╝██╔══██╗██╔════╝██╔══██╗╚██╗ ██╔╝██╔════╝██║██║      "
echo "  ███████║ ╚████╔╝ ██████╔╝█████╗  ██████╔╝ ╚████╔╝ █████╗  ██║██║      "
echo "  ██╔══██║  ╚██╔╝  ██╔═══╝ ██╔══╝  ██╔══██╗  ╚██╔╝  ██╔══╝  ██║██║      "
echo "  ██║  ██║   ██║   ██║     ███████╗██║  ██║   ██║   ███████╗██║███████╗ "
echo "  ╚═╝  ╚═╝   ╚═╝   ╚═╝     ╚══════╝╚═╝  ╚═╝   ╚═╝   ╚══════╝╚═╝╚══════╝"
echo -e "${NC}"

# ── Root check ───────────────────────────────────────────────
[ "$EUID" -ne 0 ] && error "Please run as root: sudo bash install.sh"

# ── Panel check ──────────────────────────────────────────────
[ ! -d "$PANEL_DIR" ] && error "Panel not found at $PANEL_DIR"
success "Panel found at $PANEL_DIR"

# ── Blueprint ────────────────────────────────────────────────
if command -v blueprint &>/dev/null; then
    success "Blueprint already installed ($(blueprint -version 2>/dev/null || echo 'unknown'))"
else
    info "Installing Blueprint..."
    cd "$PANEL_DIR" || error "Cannot cd to $PANEL_DIR"
    curl -Lo blueprint.zip "$BLUEPRINT_URL" || error "Failed to download Blueprint"
    unzip -o blueprint.zip || error "Failed to unzip Blueprint"
    bash blueprint.sh || error "Blueprint installer failed"
    success "Blueprint installed"
fi

# ── Copy extension files ─────────────────────────────────────
info "Copying HyperVeil files..."
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

# ── Build ────────────────────────────────────────────────────
info "Building HyperVeil..."
cd "$PANEL_DIR" || error "Cannot cd to $PANEL_DIR"
blueprint -build || error "blueprint -build failed — check output above"
success "Done!"

echo ""
echo -e "  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${GREEN}  HyperVeil is live! 🎉${NC}"
echo -e "  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "  Manage announcements:"
echo -e "  ${PURPLE}  https://your-panel/admin/extensions/hyperveil${NC}"
echo ""
echo -e "  To rebuild after changes:"
echo -e "  ${PURPLE}  cd $PANEL_DIR && blueprint -build${NC}"
echo ""
