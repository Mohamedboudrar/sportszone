<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs and sanitize them
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Specify the email address to receive the message
    $to = "boudrarmed2003@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission";
    $body = "
        Name: $name\n
        Email: $email\n
        Phone: $phone\n
        Message: \n$message
    ";
    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Your message has been sent successfully!</p>";
    } else {
        echo "<p>There was an error sending your message. Please try again later.</p>";
    }
}
?>
