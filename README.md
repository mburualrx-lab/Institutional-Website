# Elimu Bora Technical Vocational College

## Run with XAMPP

1. Install XAMPP, then keep this project folder under `C:\xampp\htdocs`. In this installation, the folder is `C:\xampp\htdocs\Institution website`.
2. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
3. Import `trainee_data.sql` once through phpMyAdmin (`http://localhost/phpmyadmin`) or the MySQL command line. This creates the `trainee_data` database and its `trainees` table.
4. You can browse the static pages with VS Code Live Server (usually `http://127.0.0.1:5500`), but keep XAMPP Apache and MySQL running too. The application form posts to `http://localhost/Institution%20website/register.php` on Apache, which runs the PHP and saves the application. Live Server itself cannot run PHP.

The application form on `apply.html` posts to `register.php`, which connects to `trainee_data` as MySQL user `root` with an empty password, as in a default XAMPP installation. If your MySQL root account has a password, configure the `DB_PASSWORD` environment variable for Apache before starting it. Successful applications are saved in the `trainees` table.

Replace the sample phone number, email address, and location in `INDEX.HTML` with the college's official contact details before publishing. The workshop image and Google Fonts are loaded from external services and need an internet connection.