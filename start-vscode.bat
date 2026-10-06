@echo off
title Student Attendance System - VS Code PHP Server
if not exist "C:\xampp\php\php.exe" (
 echo XAMPP PHP was not found at C:\xampp\php\php.exe
 echo Install XAMPP or edit this file with your PHP path.
 pause
 exit /b 1
)
echo Starting PHP server...
start "Attendance Server" cmd /k "C:\xampp\php\php.exe -S 127.0.0.1:8000 -t "%~dp0""
timeout /t 2 >nul
start "" "http://127.0.0.1:8000/"
