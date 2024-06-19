<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Start or resume the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form has been submitted in the same session
    if (!isset($_SESSION['form_submitted'])) {
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $country = isset($_POST['country']) ? $_POST['country'] : '';
        $state = isset($_POST['state']) ? $_POST['state'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $identity = isset($_POST['identity']) ? $_POST['identity'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $tech = isset($_POST['tech']) ? $_POST['tech'] : '';
        $interests = isset($_POST['interests']) ? implode(', ', $_POST['interests']) : '';
        $policyAgree = isset($_POST['policyAgree']) ? $_POST['policyAgree'] : '';
        $language = isset($_POST['language']) ? $_POST['language'] : 'en';

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
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('consultation@cacs-ltd.com', 'Mailer');
            $mail->addAddress('consultation@cacs-ltd.com', "Consultation");

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Consultation Enquiry';
            $mail->Body = "First Name: $firstname<br>Last Name: $lastname<br>Email: $email<br>Phone: $phone<br>Country: $country<br>State: $state<br>City: $city<br>Identity: $identity<br>Message: $message<br>Smart Technology: $tech<br>Interests: $interests<br>Policy Agreement: $policyAgree";
            $mail->AltBody = "First Name: $firstname\nLast Name: $lastname\nEmail: $email\nPhone: $phone\nCountry: $country\nState: $state\nCity: $city\nIdentity: $identity\nMessage: $message\nSmart Technology: $tech\nInterests: $interests\nPolicy Agreement: $policyAgree";

            $mail->send();

            // Set session variable to indicate form submission
            $_SESSION['form_submitted'] = true;

            // Prepare the response message based on the language
            $messages = [
                'en' => 'Thank you for contacting us. We will get back to you soon.',
                'fr' => 'Merci de nous avoir contactés. Nous vous répondrons bientôt.',
                'ar' => 'شكرا لتواصلكم معنا. سنعود إليك قريبا.'
            ];
            $successMessage = isset($messages[$language]) ? $messages[$language] : $messages['en'];

            // Return a success response as JSON
            echo json_encode(['success' => true, 'message' => $successMessage]);

        } catch (Exception $e) {
            // Return an error response as JSON
            echo json_encode(['success' => false, 'message' => 'Failed to submit the form. Please try again later.']);

            // Log error message
            error_log('Error sending email: ' . $e->getMessage());
        }
    } else {
        // Clear the form_submitted session variable for new submissions
        unset($_SESSION['form_submitted']);
    }
} else {
    // Redirect or handle the case where the form is not submitted
    // Log message instead of displaying it on the webpage
    error_log("Form not submitted: session variable 'form_submitted' is already set.");
    // Return an error response as JSON
    echo json_encode(['success' => false, 'message' => 'Form not submitted: session variable is already set.']);
}
