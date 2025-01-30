<?php
if(isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email invalido');</script>";
        echo "<script>window.location.href='email.html';</script>";
        exit;
    }

    // Email receiver
    $to = "your-email@example.com"; // Replanzar con el email

    // Email contenido
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message";

    // Email header 
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // enviar el email
    if(mail($to, $subject, $email_content, $headers)) {
        echo "<script>alert('Message sent successfully!');</script>";
        echo "<script>window.location.href='email.html';</script>";

    } else {

        echo "<script>alert('Message could not be sent.');</script>";

        echo "<script>window.location.href='email.html';</script>";
    }
} else {
    header("Location: email.html");
    exit;
}
?>