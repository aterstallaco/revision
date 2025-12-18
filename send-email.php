<?php
/**
 * reVISION Contact Form Handler
 * 
 * This script processes the contact form submission and sends an email.
 */

// Configuration
$to_email = "hello@revisionance.com";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.html?status=error");
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.html?status=error");
        exit;
    }
    
    // Build email subject
    $email_subject = "reVISION Contact: Message from " . $name;
    
    // Build email body
    $email_body = "You have received a new message from the reVISION website.\n\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n\n";
    $email_body .= "Message:\n" . $message . "\n";
    
    // Email headers
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (mail($to_email, $email_subject, $email_body, $headers)) {
        header("Location: contact.html?status=success");
        exit;
    } else {
        header("Location: contact.html?status=error");
        exit;
    }
    
} else {
    header("Location: contact.html");
    exit;
}
?>
