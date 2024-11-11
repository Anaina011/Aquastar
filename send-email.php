<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "<script type='text/javascript'>alert('All fields are required.'); window.location.href = 'contact.html';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script type='text/javascript'>alert('Invalid email format.'); window.location.href = 'contact.html';</script>";
        exit;
    }

    // Email configuration
    $to = "info@dehonouredglobalservices.co.uk"; // Replace with your admin email
    $subject = "New Consultation Request";
    $body = "
    <html>
    <head>
        <title>Consultation Request</title>
    </head>
    <body>
        <p>Dear Admin,</p>
        <p>A new consultation request has been submitted with the following details:</p>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone Number:</strong> $phone</p>
        <p><strong>Message:</strong> $message</p>
        <p>Thank you!</p>
    </body>
    </html>
    ";

    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "<script type='text/javascript'>alert('Consultation request sent successfully.'); window.location.href = 'contact.html';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to send request. Please try again later.'); window.location.href = 'contact.html';</script>";
    }
}
?>
