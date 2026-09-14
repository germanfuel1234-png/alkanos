<?php
header('Access-Control-Allow-Origin: *');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));

    // Validate that data is not empty and email is valid
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone)) {
        // Ideally, redirect back to the form with an error
        echo "Invalid input.";
        exit;
    }

    // Preventing header injection attacks by checking for newline characters in email and name
    if (preg_match("/[\r\n]/", $name) || preg_match("/[\r\n]/", $email)) {
        echo "Header injection detected.";
        exit;
    }

    // Recipient email address
    $to = 'alkanos@alkanos.com.ar';

    // Subject
    $subject = 'New form submission';

    // Message
    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Phone: $phone\n";

    // Headers
    $headers = "From: Alkanos Website <alkanos@alkanos.com.ar>\r\n";
    $headers .= "Reply-To: $email\n";
    $headers .= "X-Mailer: PHP/".phpversion();

    // Send the email
    if(mail($to, $subject, $message, $headers)) {
        echo "Mensaje enviado, gracias! / Thank you, your message has been sent.";
    } else {
        echo "Perdon, algo fallo. / Sorry, something went wrong.";
    }
} else {
    // Not a POST request, handle the error or redirect
    echo "Error: Form not submitted correctly.";
    exit;
}
?>
