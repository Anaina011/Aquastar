<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $propertyAddress = htmlspecialchars(trim($_POST['propertyaddress']));
    $sizeOfPool = htmlspecialchars(trim($_POST['sizeofpool']));
    $phoneNumber = htmlspecialchars(trim($_POST['phonenumber']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Email recipient and subject
    $to = "anainass.id@gmail.com"; // Replace with your email address
    $subject = "New Consultation Request";

    // Email content
    $emailContent = "
    Name: $name\n
    Email: $email\n
    Property Address: $propertyAddress\n
    Size of Pool: $sizeOfPool\n
    Phone Number: $phoneNumber\n
    Message: $message\n
    ";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $emailContent, $headers)) {
                echo "<script type='text/javascript'>alert('Email sent successfully.');</script>";
    } else {
        echo "Failed to send the message.";
    }
} else {
    echo "Invalid request.";
}
?>
