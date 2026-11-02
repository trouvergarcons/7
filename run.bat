@echo off
title ApexCorp Enterprise Portal Launcher
cls
color 0B
echo ===================================================================
echo             APEXCORP ENTERPRISE PORTAL - LAUNCHER
echo ===================================================================
echo.
echo   Choose where you want to open the project:
echo.
echo     [1] Microsoft Edge (Direct - Recommended)
echo     [2] Google Chrome
echo     [3] Default Web Browser
echo     [4] phpMyAdmin Database (MySQL Port 3307)
echo     [5] Open this folder in VS Code
echo.
echo ===================================================================
set /p choice="Enter choice [1-5] (Press Enter for Microsoft Edge): "

if "%choice%"=="" set choice=1
if "%choice%"=="1" goto edge
if "%choice%"=="2" goto chrome
if "%choice%"=="3" goto default_browser
if "%choice%"=="4" goto pma
if "%choice%"=="5" goto vscode

:edge
echo.
echo [+] Launching Microsoft Edge to: http://localhost/company/index.php
start msedge "http://localhost/company/index.php"
goto end

:chrome
echo.
echo [+] Launching Google Chrome to: http://localhost/company/index.php
start chrome "http://localhost/company/index.php"
goto end

:default_browser
echo.
echo [+] Launching in Default Browser to: http://localhost/company/index.php
start "" "http://localhost/company/index.php"
goto end

:pma
echo.
echo [+] Opening phpMyAdmin in Microsoft Edge: http://localhost/phpmyadmin/
start msedge "http://localhost/phpmyadmin/"
goto end

:vscode
echo.
echo [+] Launching VS Code in current directory...
code .
goto end

:end
echo [+] Done!
timeout /t 2 >nul
exit
