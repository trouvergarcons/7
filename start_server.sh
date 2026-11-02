#!/bin/bash
# ApexCorp Web Portal - Linux / Mac Launcher

echo "==================================================================="
echo "              APEXCORP WEB PORTAL - LAUNCHER"
echo "==================================================================="
echo ""

if ! command -v php &> /dev/null; then
    echo "[ERROR] PHP is not installed or not in PATH."
    echo "Please install PHP to run this project."
    exit 1
fi

echo "[+] Starting local PHP server at http://localhost:8000 ..."
echo "[!] Press Ctrl+C anytime to stop the server."
echo ""

# Open browser depending on OS
if [[ "$OSTYPE" == "darwin"* ]]; then
    open "http://localhost:8000"
elif command -v xdg-open &> /dev/null; then
    xdg-open "http://localhost:8000"
fi

php -S localhost:8000
