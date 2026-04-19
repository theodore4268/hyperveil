#!/usr/bin/env bash
# ============================================================
#  HyperVeil — install.sh
#  Installs Blueprint (if needed) then builds the HyperVeil
#  theme extension onto your Pterodactyl panel.
# ============================================================

set -e

PANEL_DIR="/var/www/pterodactyl"
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

banner() {
    echo -e "${PURPLE}"
    echo "  ██╗  ██╗██╗   ██╗██████╗ ███████╗██████╗ ██╗   ██╗███████╗██╗██╗     "
    echo "  ██║  ██║╚██╗ ██╔╝██╔══██╗██╔════╝██╔══██╗██║   ██║██╔════╝██║██║     "
    echo "  ███████║ ╚████╔╝ ██████╔╝█████╗  ██████╔╝██║   ██║█████╗  ██║██║     "
    echo "  ██╔══██║  ╚██╔╝  ██╔═══╝ ██╔══╝  ██╔══██╗╚██╗ ██╔╝██╔══╝  ██║██║     "
    echo "  ██║  ██║   ██║   ██║     ███████╗██║  ██║ ╚████╔╝ ███████╗██║███████╗"
    echo "  ╚═╝  ╚═╝   ╚═╝   ╚═╝     ╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚═╝╚══════╝"
    echo -e "${NC}"
    echo -e "  ${PURPLE}Cyber Panel Theme for Pterodactyl${NC}"
    echo ""
}

info()    { echo -e "  ${BLUE}[info]${NC}    $1"; }
success() { echo -e "  ${GREEN}[ok]${NC}      $1"; }
warn()    { echo -e "  ${YELLOW}[warn]${NC}    $1"; }
error()   { echo -e "  ${RED}[error]${NC}   $1"; exit 1; }
step()    { echo -e "\n  ${PURPLE}▸${NC} $1"; }

# ── Root check ──────────────────────────────────────────────
if [ "$EUID" -ne 0 ]; then
    error "Please run as root: sudo bash install.sh"
fi

banner

# ── Panel directory check ────────────────────────────────────
step "Checking panel directory..."
if [ ! -d "$PANEL_DIR" ]; then
    error "Panel not found at $PANEL_DIR. Edit PANEL_DIR in this script if yours is different."
fi
success "Panel found at $PANEL_DIR"

# ── Blueprint check / install ────────────────────────────────
step "Checking for Blueprint..."
if command -v blueprint &>/dev/null; then
    BV=$(blueprint -version 2>/dev/null || echo "unknown")
    success "Blueprint already installed (version: $BV)"
else
    warn "Blueprint not found — installing now..."
    cd "$PANEL_DIR"
    curl -Lo blueprint.zip https://github.com/BlueprintFramework/framework/releases/download/beta-2026-01/release.zip
    unzip -o blueprint.zip
    bash blueprint.sh
    success "Blueprint installed"
fi

# ── Copy extension files ─────────────────────────────────────
step "Copying HyperVeil extension files..."

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEV_DIR="$PANEL_DIR/.blueprint/dev"

mkdir -p "$DEV_DIR/dashboard"
mkdir -p "$DEV_DIR/admin"
mkdir -p "$DEV_DIR/assets"

cp "$SCRIPT_DIR/conf.yml"                    "$DEV_DIR/conf.yml"
cp "$SCRIPT_DIR/dashboard/dashboard.css"     "$DEV_DIR/dashboard/dashboard.css"
cp "$SCRIPT_DIR/dashboard/wrapper.blade.php" "$DEV_DIR/dashboard/wrapper.blade.php"
cp "$SCRIPT_DIR/admin/admin.css"             "$DEV_DIR/admin/admin.css"
cp "$SCRIPT_DIR/admin/wrapper.blade.php"     "$DEV_DIR/admin/wrapper.blade.php"

# Copy icon if it exists
if [ -f "$SCRIPT_DIR/assets/icon.png" ]; then
    cp "$SCRIPT_DIR/assets/icon.png" "$DEV_DIR/assets/icon.png"
fi

success "Files copied to $DEV_DIR"

# ── Build ────────────────────────────────────────────────────
step "Building HyperVeil theme..."
cd "$PANEL_DIR"
blueprint -build
success "Theme built and applied!"

# ── Done ─────────────────────────────────────────────────────
echo ""
echo -e "  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "  ${GREEN}  HyperVeil is live on your panel!${NC}"
echo -e "  ${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "  To update the theme after making changes:"
echo -e "  ${PURPLE}  cd $PANEL_DIR && blueprint -build${NC}"
echo ""
echo -e "  To edit the announcement banner:"
echo -e "  ${PURPLE}  nano $DEV_DIR/dashboard/wrapper.blade.php${NC}"
echo ""
