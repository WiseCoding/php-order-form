<?php

declare(strict_types=1);

// DEPENDENCIES
require 'mail.php';
// COMPOSER AUTOLOADER
require 'vendor/autoload.php';

// START SESSION
session_start();


// PRODUCTS
$food = [
  ['name' => 'Club Ham', 'price' => 3.20],
  ['name' => 'Club Cheese', 'price' => 3],
  ['name' => 'Club Cheese & Ham', 'price' => 4],
  ['name' => 'Club Chicken', 'price' => 4],
  ['name' => 'Club Salmon', 'price' => 5]
];
$drinks = [
  ['name' => 'Cola', 'price' => 2],
  ['name' => 'Fanta', 'price' => 2],
  ['name' => 'Sprite', 'price' => 2],
  ['name' => 'Ice-tea', 'price' => 3],
];

// SET START GLOBALS
$products = $food;
$form_email = '';
$form_street = '';
$form_number = '';
$form_city = '';
$form_zip = '';
$info = '';
$alert = 'd-none';

// SET LAST VALIDATED COOKIE VALUES
$form_email = getCookie('email');
$form_street = getCookie('street');
$form_number = getCookie('number');
$form_city = getCookie('city');
$form_zip = getCookie('zip');

// TOGGLE FOOD OR DRINKS BASED ON SELECTION
if ($_GET) {
  $products = setFood($_GET['food'], $food, $drinks);
}

// SET TOTAL SPENT COOKIE VALUE
$totalValue = getCookie('total');

// VALIDATE FORM DATA, SET COOKIES, SHOW INFO/ALERTS
if ($_POST) {
  // VALIDATE FORM INPUT / SET COOKIES
  $valid = valForm();

  // SHOW INFO DIV + INFO
  $alert = showDiv($valid);
  $info = completeOrder($valid);
}



// ========= //
// FUNCTIONS //
// ========= //
function whatIsHappening()
{
  echo '<h2>$_GET</h2>';
  var_dump($_GET);
  echo '<h2>$_POST</h2>';
  var_dump($_POST);
  echo '<h2>$_COOKIE</h2>';
  var_dump($_COOKIE);
  echo '<h2>$_SESSION</h2>';
  var_dump($_SESSION);
}

function setFood($choice, $food, $drinks)
{
  $choice = (int)$choice;

  if ($choice === 1) {
    return $food;
  } else {
    return $drinks;
  }
}

function getCookie($type)
{
  if (isset($_COOKIE[$type])) {
    return $_COOKIE[$type];
  } else {
    return '';
  }
}

function valEmail($email)
{
  // validate input
  if (empty($email)) {
    return "Please enter an <b>email address</b><br/>";
  } else {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // set cookie
      setcookie('email', $email, time() + (86400 * 30));
      return;
    } else {
      return "<b>$email</b> is not a valid email address<br/>";
    }
  }
}

function valStreet($street)
{
  // validate input
  if (empty($street)) {
    return "Please enter a <b>street name</b><br/>";
  } else {
    // regex: starts with a word, can have spaces & hyphens
    if (preg_match("/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/i", $street)) {
      // set cookie
      setcookie('street', $street, time() + (86400 * 30));
      return;
    } else {
      return "<b>$street</b> is not a valid street name<br/>";
    }
  }
}

function valNumber($number)
{
  // validate input
  if (empty($number)) {
    return "Please enter a <b>street number</b><br/>";
  } else {
    // regex: string has to start with a number and can have one letter upper/lower in the end
    if (preg_match("/^\d+[a-zA-Z]?$/", $number)) {
      // set cookie
      setcookie('number', $number, time() + (86400 * 30));
      return;
    } else {
      return "<b>$number</b> is not a valid street number<br/>";
    }
  }
}

function valCity($city)
{
  // validate input
  if (empty($city)) {
    return "Please enter a <b>street city</b><br/>";
  } else {
    // regex: starts with a word, can have spaces & hyphens
    if (preg_match("/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/i", $city)) {
      // set cookie
      setcookie('city', $city, time() + (86400 * 30));
      return;
    } else {
      return "<b>$city</b> is not a valid city name<br/>";
    }
  }
}

function valZip($zip)
{
  // validate input
  if (empty($zip)) {
    return "Please enter a <b>zip code</b><br/>";
  } else {
    // regex: this is the regex for belgium zip codes
    if (preg_match("/^\d{4}$/", $zip)) {
      // set cookie
      setcookie('zip', $zip, time() + (86400 * 30));
      return;
    } else {
      return "<b>$zip</b> is not a valid zip code<br/>";
    }
  }
}

function valForm()
{
  $val_email = valEmail(htmlspecialchars($_POST['email']));
  $val_street = valStreet(htmlspecialchars($_POST['street']));
  $val_number = valNumber(htmlspecialchars($_POST['number']));
  $val_city = valCity(htmlspecialchars($_POST['city']));
  $val_zip = valZip(htmlspecialchars($_POST['zip']));

  // GENERATE ALERTS
  return $val_email . $val_street . $val_number . $val_city . $val_zip;
}

function showDiv($info)
{
  if ($info === '') {
    return 'alert-success';
  } else {
    return 'alert-danger';
  }
}

function completeOrder($info)
{
  if ($info === '') {
    // CALCULATE TOTAL ITEMS PURCHASED
    $total = calcTotal($_POST['products']);
    // ADD TO TOTAL COOKIE
    addToTotal($total);
    // ADD EXPRESS COSTS
    $total = ((int)$_POST['delivery'] === 1) ? $total + 5 : $total;
    // SEND CONFIRMATION MAIL
    $email = sendEmail($total);
    // DELIVERY TIME
    $normal = "🚚 Arriving in <b>±2 Hours</b>.<br/> 💰 Ordered for €<b>$total</b>.<br/>$email";
    $express = "🏎 Arriving in <b>±45 Minutes</b>.<br/> 💰 Ordered for €<b>$total</b>.<br/>$email";

    ((int)$_POST['delivery'] === 1) ? $delivery = $express : $delivery = $normal;
    // SUCCESS MESSAGE
    return "📦 Delivering to <b>" . $_POST['street'] . " " . $_POST['number'] . "</b>!<br/>$delivery";
  } else {
    return $info;
  }
}

function calcTotal($items)
{
  $spent = 0;
  // CALCULATE TOTAL
  foreach ($items as $item) {
    $spent += $item;
  }
  return number_format($spent, 2);
}

function addToTotal($amount)
{
  // get cookie value
  $spent = getCookie('total');
  // add
  $total = (int)$spent + (int)$amount;
  $total = strval($total);
  // set cookie
  setcookie('total', $total, time() + (86400 * 365));
}



// TESTING
// whatIsHappening();

//

require 'form-view.php';
