<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// COMPOSER AUTOLOADER
require 'vendor/autoload.php';


function sendEmail($total)
{
  // RESTAURANT OWNER
  $owner = 'owner@email.com';

  // CUSTOMER
  $customer = $_POST['email'];
  $street = $_POST['street'];
  $number = $_POST['number'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];

  // ORDER
  $deliveryType = ((int)$_POST['delivery'] === 0) ? 'Normal delivery' : 'Express delivery';
  $deliveryTime = ((int)$_POST['delivery'] === 0) ? '2 hours' : '45 minutes';
  $orderTotal = $total;

  // MESSAGES
  $customerMsgHTML =
    "Thank you for your order with the PHP restaurant!<br/>
    <br/>
    The order will be delivered to:<br/>
    <b>$street $number</b>, <b>$zip</b> in <b>$city</b>.<br/>
    <br />
    Delivery method and arrival time:<br/>
    <b>$deliveryType</b>, ETA: <b>$deliveryTime</b>.<br />
    <br />
    The order total is: <b>&euro; $orderTotal</b>.";
  //TODO: ADD ORDER ITEMS SUMMARY MAYBE?


  // SEND MAIL
  $mail = new PHPMailer(true);
  try {
    // DEBUG
    //$mail->SMTPDebug = 3;
    // SERVER
    $mail->isSMTP();
    $mail->Host       = 'mail.gmx.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'wisetesting@gmx.com';
    $mail->Password   = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       =  465;
    // SENDER
    $mail->setFrom('wisetesting@gmx.com', 'Wise Tester');
    // RECEIVER
    $mail->addAddress($customer, 'Happy Customer');
    //$mail->addAddress($owner, 'Happy Chef');
    // CONTENT
    $mail->isHTML(true);
    $mail->Subject = 'Thank you for your order at "The PHP"';
    $mail->Body    = $customerMsgHTML; // Can be HTML
    $mail->AltBody = $customerMsgHTML; // Should be plain text
    // SEND
    $mail->send();
    // INFORM USER
    return '📩 Email sent to <b>' . $customer . '</b>.';
  } catch (Exception $e) {
    return "❌ Email failed to <b>$customer</b>. Error: {$mail->ErrorInfo}";
  }
}
