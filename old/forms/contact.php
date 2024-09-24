<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure the path to autoload.php is correct

$mail = new PHPMailer(true);  // Enable exceptions for debugging

// Replace with your receiving email address
$receiving_email_address = 'sanyuaung.ygn.mm@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Collect form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that all fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
      throw new Exception('Please fill in all the fields!');
    }

    // Server settings
    $mail->isSMTP();                                      // Use SMTP
    $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'mailservice.88.mm@gmail.com';                    // SMTP username
    $mail->Password = 'rlahgirbizcafiwd';                    // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption
    $mail->Port = 587;                                    // TCP port to connect

    // Recipients
    $mail->setFrom($email, $name);                        // Sender
    $mail->addAddress($receiving_email_address);          // Recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = "<h3>Message from $name ($email)</h3><p>$message</p>";
    $mail->AltBody = $message;  // Plain text for non-HTML clients

    $mail->send();
    echo 'Your message has been sent successfully!';
  } catch (Exception $e) {
    echo "Message could not be sent. Error: {$mail->ErrorInfo}";
  }
} else {
  echo 'Invalid request!';
}