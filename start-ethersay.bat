@echo off
echo ========================================
echo   EtherSay - Local Network Chat
echo ========================================
echo.
echo Starting all services...
echo.

REM Get local IP address
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /c:"IPv4 Address"') do (
    set "ip=%%a"
    goto :found
)
:found
set ip=%ip:~1%

echo Your Local IP: %ip%
echo.
echo Access from:
echo - This computer: http://localhost:8000
echo - Other devices: http://%ip%:8000
echo.
echo ========================================
echo.

REM Start Laravel dev server
start "Laravel Server" cmd /k "echo Laravel Development Server && php artisan serve --host=0.0.0.0 && pause"

REM Wait a bit
timeout /t 2 /nobreak > nul

REM Start Reverb
start "Reverb WebSocket" cmd /k "echo Reverb WebSocket Server && php artisan reverb:start && pause"

echo.
echo All services started!
echo.
echo Press any key to open browser...
pause > nul

start http://localhost:8000

echo.
echo To stop all services, close all terminal windows.
echo.
pause
