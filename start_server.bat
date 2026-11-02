@echo off
title ApexCorp Web Server Launcher
color 0A
cls
echo ===================================================================
echo               APEXCORP WEB PORTAL - ONE-CLICK LAUNCHER
echo ===================================================================
echo.

:: Detect PHP executable
set PHP_BIN=php
where php >nul 2>nul
if %errorlevel% neq 0 (
    if exist "C:\xampp\php\php.exe" (
        set PHP_BIN=C:\xampp\php\php.exe
    ) else (
        echo [ERROR] PHP executable was not found on your system.
        echo Please install PHP or XAMPP to run this project.
        pause
        exit /b 1
    )
)

echo [+] Using PHP: %PHP_BIN%
echo [+] Starting local PHP server at http://localhost:8000 ...
echo.
echo [!] Press Ctrl+C in this window anytime to stop the server.
echo.

:: Open browser
start "" "http://localhost:8000"

:: Start built-in PHP development server
%PHP_BIN% -S localhost:8000
