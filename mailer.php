<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Start or resume the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clear the form_submitted session variable
    if (isset($_SESSION['form_submitted'])) {
        unset($_SESSION['form_submitted']);
    }

    $language = $_POST['language'] ?? 'en';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $country = $_POST['country'] ?? '';
    $state = $_POST['state'] ?? '';
    $city = $_POST['city'] ?? '';
    $identity = $_POST['identity'] ?? '';
    $message = $_POST['message'] ?? '';
    $tech = $_POST['tech'] ?? '';
    $interests = isset($_POST['interests']) ? implode(', ', $_POST['interests']) : '';
    $policyAgree = $_POST['policyAgree'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Set to 0 to disable debugging
        $mail->isSMTP();
        $mail->Host = 'mail.cacs-ltd.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'consultation@cacs-ltd.com';
        $mail->Password = 'cacs_consult$100';
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('consultation@cacs-ltd.com', 'Consultation');
        $mail->addAddress('consultation@cacs-ltd.com', 'Consultation');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Consultation Enquiry';
        $mail->Body = "
            <h2>Consultation Form Submission Details</h2>
            <p><strong>Language:</strong> $language</p>
            <p><strong>First Name:</strong> $firstname</p>
            <p><strong>Last Name:</strong> $lastname</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Country:</strong> $country</p>
            <p><strong>State:</strong> $state</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Identity:</strong> $identity</p>
            <p><strong>Message:</strong> $message</p>
            <p><strong>Smart Technology:</strong> $tech</p>
            <p><strong>Interests:</strong> $interests</p>
            <p><strong>Policy Agreement:</strong> $policyAgree</p>
        ";
        $mail->AltBody = "
            Consultation Form Submission Details
            Language: $language
            First Name: $firstname
            Last Name: $lastname
            Email: $email
            Phone: $phone
            Country: $country
            State: $state
            City: $city
            Identity: $identity
            Message: $message
            Smart Technology: $tech
            Interests: $interests
            Policy Agreement: $policyAgree
        ";

        $mail->send();

        // Set session variable to indicate form submission
        $_SESSION['form_submitted'] = true;

        // Prepare the response message based on the language
        $messages = [
            'en' => 'Thank you for contacting us. We will get back to you soon.',
            'fr' => 'Merci de nous avoir contactés. Nous vous répondrons bientôt.',
            'ar' => 'شكرا لتواصلكم معنا. سنعود إليك قريبا.'
        ];
        $successMessage = $messages[$language] ?? $messages['en'];

        // Return a success response as JSON
        echo json_encode(['success' => true, 'message' => $successMessage]);

    } catch (Exception $e) {
        // Return an error response as JSON
        echo json_encode(['success' => false, 'message' => 'Failed to submit the form. Please try again later.']);

        // Log error message
        error_log('Error sending email: ' . $e->getMessage());
    }
} else {
    // Log message instead of displaying it on the webpage
    error_log("Form not submitted: session variable 'form_submitted' is already set.");
    // Return an error response as JSON
    echo json_encode(['success' => false, 'message' => 'Form not submitted: session variable is already set.']);
}
?>
