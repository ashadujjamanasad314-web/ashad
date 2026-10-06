STUDENT ATTENDANCE MANAGEMENT SYSTEM - VS CODE MODE
===================================================

Recommended setup: VS Code + XAMPP MySQL + PHP built-in development server.

1. Install XAMPP (Apache is not required for this mode; MySQL is required).
2. Start MySQL from XAMPP Control Panel.
3. Import database/student_attendance.sql in http://localhost/phpmyadmin
4. Open this folder in VS Code.
5. Make sure C:\xampp\php\php.exe exists. XAMPP includes PHP.
6. Double-click start-vscode.bat OR in VS Code terminal run:
   C:\xampp\php\php.exe -S 127.0.0.1:8000 -t .
7. Open Chrome: http://127.0.0.1:8000/

Default login: admin / admin123

IMPORTANT: VS Code is the editor. PHP must run through a PHP server; Live Server is not a PHP server.
This project now supports both:
- VS Code PHP server: http://127.0.0.1:8000/
- XAMPP Apache: http://localhost/student-attendance-system/

If MySQL uses a password, edit config/database.php.
