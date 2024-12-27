<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include Composer's autoloader

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = htmlspecialchars($_POST['firstName'] ?? '');
        $lastName = htmlspecialchars($_POST['lastName'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $message = htmlspecialchars($_POST['message'] ?? '');

        if (!$email || empty($firstName) || empty($lastName) || empty($message)) {
            http_response_code(400);
            echo 'All fields are required, and the email must be valid.';
            exit;
        }

        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alliesaltcoin@gmail.com'; // Replace with your email
        $mail->Password = 'xrehsqvshmqnhkev'; // Use App Password for Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Content
        $mail->setFrom($email, "$firstName $lastName");
        $mail->addAddress('kaisarsaiful@gmail.com'); // Replace with recipient email
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "Name: $firstName $lastName\nEmail: $email\nMessage: $message";

        $mail->send();
        echo 'Your message has been sent successfully.';
    } else {
        http_response_code(405);
        echo 'Invalid request method.';
    }
} catch (Exception $e) {
    error_log('Mailer Error: ' . $e->getMessage());
    http_response_code(500);
    echo 'Failed to send your message. Please try again later.';
}
