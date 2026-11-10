<?php
// Process the student registration form and store validated details in MySQL.
declare(strict_types=1);

function renderMessage(string $title, string $message, bool $isSuccess): never
{
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $accent = $isSuccess ? '#245c45' : '#9a4935';
    http_response_code($isSuccess ? 200 : 400);
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . $safeTitle . ' | Elimu Bora College</title><link rel="stylesheet" href="styles.css"></head><body><main style="max-width:680px;margin:12vh auto;padding:32px;background:#fff;border-top:4px solid ' . $accent . '"><p style="color:' . $accent . ';font-weight:700">ELIMU BORA COLLEGE</p><h1 style="font-size:36px;color:#17241f">' . $safeTitle . '</h1><p>' . $safeMessage . '</p><a class="button button-submit" href="apply.html">Return to application</a></main></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: apply.html');
    exit;
}

$fields = ['full_name', 'email', 'phone', 'department', 'course', 'intake', 'accommodation'];
$data = [];
foreach ($fields as $field) {
    $data[$field] = trim((string) ($_POST[$field] ?? ''));
}

if (in_array('', $data, true) || empty($_POST['contact_consent'])) {
    renderMessage('Please complete the form', 'All fields and the contact permission are required. Go back and check your application details.', false);
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    renderMessage('Check your email address', 'Enter a valid email address, then submit your application again.', false);
}

try {
    // XAMPP defaults to MySQL user "root" with no password; set DB_PASSWORD if configured otherwise.
    $password = getenv('DB_PASSWORD') ?: '';
    $pdo = new PDO(
        'mysql:host=localhost;dbname=trainee_data;charset=utf8mb4',
        'root',
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $statement = $pdo->prepare(
        'INSERT INTO trainees (full_name, email, phone, department, course, intake, accommodation) VALUES (:full_name, :email, :phone, :department, :course, :intake, :accommodation)'
    );
    $statement->execute($data);
    renderMessage('Application received', 'Thank you for applying to Elimu Bora Technical Vocational College. Our admissions team will contact you soon.', true);
} catch (PDOException $exception) {
    error_log('Student registration database error: ' . $exception->getMessage());
    renderMessage('We could not submit your application', 'Please try again later or contact admissions directly for assistance.', false);
}