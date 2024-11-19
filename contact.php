<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email setup
        $to = "info@mantraxglobalservices.com, ceo@mantraxglobalservices.com";
        $subject = "New Contact Form Submission";
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $body = "You have received a new message from the contact form:\n\n";
        $body .= "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Message:\n$message\n";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            echo "Your message has been sent successfully!";
        } else {
            echo "There was an error sending your message. Please try again later.";
        }
    } else {
        echo "Invalid input. Please fill in all fields correctly.";
    }
} else {
    echo "Unauthorized request.";
}
?>