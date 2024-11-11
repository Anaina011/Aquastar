<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars(trim($_POST['fname']));
    $lname = htmlspecialchars(trim($_POST['lname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($message)) {
        echo "<script type='text/javascript'>alert('All fields are required.'); window.location.href = 'index.html#contact_section';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script type='text/javascript'>alert('Invalid email format.'); window.location.href = 'index.html#contact_section';</script>";
        exit;
    }

    // Email configuration
    $to = "info@dehonouredglobalservices.co.uk";
    $subject = "New Contact Request";
    $body = "
    <html>
    <head>
        <title>Contact Request</title>
    </head>
    <body>
        <p>Dear Admin,</p>
        <p>A new contact request has been submitted with the following details:</p>
        <p><strong>First Name:</strong> $fname</p>
        <p><strong>Last Name:</strong> $lname</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
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
        echo "<script type='text/javascript'>alert('Email sent successfully.'); window.location.href = 'index.html#contact_section';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to send message. Please try again later.'); window.location.href = 'index.html#contact_section';</script>";
    }
}
?>
