<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

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

//your products with their price.
$products = [
  ['name' => 'Club Ham', 'price' => 3.20],
  ['name' => 'Club Cheese', 'price' => 3],
  ['name' => 'Club Cheese & Ham', 'price' => 4],
  ['name' => 'Club Chicken', 'price' => 4],
  ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
  ['name' => 'Cola', 'price' => 2],
  ['name' => 'Fanta', 'price' => 2],
  ['name' => 'Sprite', 'price' => 2],
  ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;



// ================ //
// MATTIAS PHP CODE //
// ================ //
whatIsHappening();


// SET EMPTY VARIABLES VALUES
$alert = 'd-none';
$errors = '';
$form_email = '';
$form_street = '';
$form_number = '';
$form_city = '';
$form_zip = '';
$form_placeholder_email = '';
$form_placeholder_street = '';
$form_placeholder_number = '';
$form_placeholder_city = '';
$form_placeholder_zip = '';


// GET LAST SUBMITTED VALUES
if (isset($_POST['email'])) {
  $form_email = $_POST['email'];
}
if (isset($_POST['street'])) {
  $form_street = $_POST['street'];
}
if (isset($_POST['number'])) {
  $form_number = $_POST['number'];
}
if (isset($_POST['city'])) {
  $form_city = $_POST['city'];
}
if (isset($_POST['zip'])) {
  $form_zip = $_POST['zip'];
}

// GET LAST VALIDATED VALUES COOKIE
if (isset($_COOKIE['email'])) {
  $form_placeholder_email = $_COOKIE['email'];
}
if (isset($_COOKIE['street'])) {
  $form_placeholder_street = $_COOKIE['street'];
}
if (isset($_COOKIE['number'])) {
  $form_placeholder_number = $_COOKIE['number'];
}
if (isset($_COOKIE['city'])) {
  $form_placeholder_city = $_COOKIE['city'];
}
if (isset($_COOKIE['zip'])) {
  $form_placeholder_zip = $_COOKIE['zip'];
}

// VALIDATE FORM DATA, SET COOKIES
if ($_POST) {
  valForm();
}


// FUNCTIONS
function valForm()
{
  $val_email = valEmail();
  $val_street = valStreet();
  $val_number = valNumber();
  $val_city = valCity();
  $val_zip = valZip();

  // GENERATE ALERTS
  $errors = $val_email . $val_street . $val_number . $val_city . $val_zip;
  // HIDE ALERTS DIV WHEN NO ALERTS
  ($errors === '') ? $alert = 'd-none' : $alert = '';
}

function valEmail()
{
  // get input
  $email = $_POST['email'];

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

function valStreet()
{
  // get input
  $street = $_POST['street'];

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

function valNumber()
{
  // get input
  $number = $_POST['number'];

  // validate input
  if (empty($number)) {
    return "Please enter a <b>street number</b><br/>";
  } else {
    // regex: string has to start with a number and can have one letter uppr/lowr in the end
    if (preg_match("/^\d+[a-zA-Z]?$/", $number)) {
      // set cookie
      setcookie('number', $number, time() + (86400 * 30));
      return;
    } else {
      return "<b>$number</b> is not a valid street number<br/>";
    }
  }
}

function valCity()
{
  // get input
  $city = $_POST['city'];

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

function valZip()
{
  // get input
  $zip = $_POST['zip'];

  // validate input
  if (empty($zip)) {
    return "Please enter a <b>zip code</b><br/>";
  } else {
    // regex: this is the regex for belgium zip codes
    if (preg_match("/\d{4}/", $zip)) {
      // set cookie
      setcookie('zip', $zip, time() + (86400 * 30));
      return;
    } else {
      return "<b>$zip</b> is not a valid zip code<br/>";
    }
  }
}




//

require 'form-view.php';