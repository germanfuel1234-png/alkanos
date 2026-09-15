<?php
header('Access-Control-Allow-Origin: *');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : '';
    $product = isset($_POST["product"]) ? strip_tags(trim($_POST["product"])) : '';
    $empresa = isset($_POST["empresa"]) ? strip_tags(trim($_POST["empresa"])) : '';
    $mensaje = isset($_POST["mensaje"]) ? strip_tags(trim($_POST["mensaje"])) : '';

    // Validate that data is not empty and email is valid
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ideally, redirect back to the form with an error
        echo "Invalid input.";
        exit;
    }

    // Preventing header injection attacks by checking for newline characters in email and name
    if (preg_match("/[\r\n]/", $name) || preg_match("/[\r\n]/", $email) || preg_match("/[\r\n]/", $product) || preg_match("/[\r\n]/", $empresa)) {
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
    if (!empty($phone)) {
        $message .= "Phone: $phone\n";
    }
    if (!empty($empresa)) {
        $message .= "Empresa: $empresa\n";
    }
    if (!empty($product)) {
        $message .= "Producto de interes: $product\n";
    }
    if (!empty($mensaje)) {
        $message .= "Mensaje: $mensaje\n";
    }

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
