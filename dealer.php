<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['form_submitted'])) {
        unset($_SESSION['form_submitted']);
    }

    $language = $_POST['language'] ?? 'en';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $companyName = $_POST['companyName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $country = $_POST['country'] ?? '';
    $state = $_POST['state'] ?? '';
    $city = $_POST['city'] ?? '';
    $business = isset($_POST['business']) ? implode(', ', $_POST['business']) : '';
    $otherServices = $_POST['otherServices'] ?? '';
    $totalRevenue = $_POST['totalRevenue'] ?? '';
    $targetCustomers = $_POST['targetCustomers'] ?? '';
    $showroom = $_POST['showroom'] ?? '';
    $markets = $_POST['markets'] ?? '';
    $marketing = $_POST['marketing'] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.cacs-ltd.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dealer@cacs-ltd.com';
        $mail->Password = 'cacs_dealer$100';
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->Port = 465;

        $mail->setFrom('dealer@cacs-ltd.com', 'New Dealer Information');
        $mail->addAddress('dealer@cacs-ltd.com', 'New Dealer Information');

        $mail->isHTML(true);
        $mail->Subject = 'New Consultation Enquiry';
        $mail->Body = "
            <h2>Consultation Form Submission Details</h2>
            <p><strong>Language:</strong> $language</p>
            <p><strong>First Name:</strong> $firstname</p>
            <p><strong>Last Name:</strong> $lastname</p>
            <p><strong>Company Name:</strong> $companyName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Country:</strong> $country</p>
            <p><strong>State:</strong> $state</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Business:</strong> $business</p>
            <p><strong>Other Services:</strong> $otherServices</p>
            <p><strong>Total Revenue:</strong> $totalRevenue</p>
            <p><strong>Target Customers:</strong> $targetCustomers</p>
            <p><strong>Showroom:</strong> $showroom</p>
            <p><strong>Markets:</strong> $markets</p>
            <p><strong>Marketing:</strong> $marketing</p>
        ";
        $mail->AltBody = "
            Consultation Form Submission Details
            Language: $language
            First Name: $firstname
            Last Name: $lastname
            Company Name: $companyName
            Email: $email
            Phone: $phone
            Country: $country
            State: $state
            City: $city
            Business: $business
            Other Services: $otherServices
            Total Revenue: $totalRevenue
            Target Customers: $targetCustomers
            Showroom: $showroom
            Markets: $markets
            Marketing: $marketing
        ";

        $mail->send();

        $_SESSION['form_submitted'] = true;

        $messages = [
            'en' => 'Thank you for contacting us. We will get back to you soon.',
            'fr' => 'Merci de nous avoir contactés. Nous vous répondrons bientôt.',
            'ar' => 'شكرا لتواصلكم معنا. سنعود إليك قريبا.'
        ];
        $successMessage = $messages[$language] ?? $messages['en'];

        echo json_encode(['success' => true, 'message' => $successMessage]);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to submit the form. Please try again later.']);
        error_log('Error sending email: ' . $e->getMessage());
    }
} else {
    error_log("Form not submitted: session variable 'form_submitted' is already set.");
    echo json_encode(['success' => false, 'message' => 'Form not submitted: session variable is already set.']);
}
?>
