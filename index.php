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



$totalValue = 0;



// ================ //
// MATTIAS PHP CODE //
// ================ //
whatIsHappening();


// SET GLOBALS
$alert = 'd-none';
$info = '';
$form_email = '';
$form_street = '';
$form_number = '';
$form_city = '';
$form_zip = '';

// SET LAST VALIDATED COOKIE VALUES
$form_email = getCookie('email');
$form_street = getCookie('street');
$form_number = getCookie('number');
$form_city = getCookie('city');
$form_zip = getCookie('zip');

// SET FOOD OR DRINKS BASED ON SELECTION
$products = setFood($_GET['food']);

// VALIDATE FORM DATA, SET COOKIES
if ($_POST) {
  $info = valForm();
  // SHOW ALERTS /
  if ($info === '') {
    $alert = 'alert-success';
    $info = 'The food is on the way! 🚚';
  } else {
    $alert = 'alert-danger';
  }
}



// FUNCTIONS
function getPost($type)
{
  if (isset($_POST[$type])) {
    return $_POST[$type];
  } else {
    return '';
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

function valForm()
{
  $val_email = valEmail($_POST['email']);
  $val_street = valStreet($_POST['street']);
  $val_number = valNumber($_POST['number']);
  $val_city = valCity($_POST['city']);
  $val_zip = valZip($_POST['zip']);

  // GENERATE ALERTS
  return $val_email . $val_street . $val_number . $val_city . $val_zip;
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
    if (preg_match("/\d{4}/", $zip)) {
      // set cookie
      setcookie('zip', $zip, time() + (86400 * 30));
      return;
    } else {
      return "<b>$zip</b> is not a valid zip code<br/>";
    }
  }
}

function setFood($choice)
{

  $choice = (int)$choice;

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

  if ($choice === 1) {
    return $food;
  } else {
    return $drinks;
  }
}


//

require 'form-view.php';