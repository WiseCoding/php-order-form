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

// RESET FORM VALUES
$form_email = "";
$form_street = "";
$form_number = "";
$form_city = "";
$form_zip = "";

// GET COOKIE VALUES
if (isset($_COOKIE['email'])) {
  $form_email = $_COOKIE['email'];
}
if (isset($_COOKIE['street'])) {
  $form_street = $_COOKIE['street'];
}
if (isset($_COOKIE['number'])) {
  $form_number = $_COOKIE['number'];
}
if (isset($_COOKIE['city'])) {
  $form_city = $_COOKIE['city'];
}
if (isset($_COOKIE['zip'])) {
  $form_zip = $_COOKIE['zip'];
}


// VALIDATE FIELDS & SET COOKIES
$val_email = valEmail();
echo $val_email . '<br />';
$val_street = valStreet();
echo $val_street . '<br />';
$val_number = valNumber();
echo $val_number . '<br />';
$val_city = valCity();
echo $val_city . '<br />';
$val_zip = valZip();
echo $val_zip . '<br />';



/* if ($EMAIL === "valid") {
  //TODO: the email is valid do something
} else {
  $ERROR = $EMAIL;
} */



// FUNCTIONS
function valEmail()
{
  // get input
  $email = $_POST['email'];

  // validate input
  if (empty($email)) {
    return "Please enter an <b>email address</b>";
  } else {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // set cookie
      setcookie('email', $email, time() + (86400 * 30));
      return "valid";
    } else {
      return "<b>$email</b> is not a valid email address";
    }
  }
}

function valStreet()
{
  // get input
  $street = $_POST['street'];

  // validate input
  if (empty($street)) {
    return "Please enter a <b>street name</b>";
  } else {
    if (preg_match("/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/i", $street)) {
      // set cookie
      setcookie('street', $street, time() + (86400 * 30));
      return "valid";
    } else {
      return "<b>$street</b> is not a valid street name";
    }
  }
}

function valNumber()
{
  // get input
  $number = $_POST['number'];

  // validate input
  if (empty($number)) {
    return "Please enter a <b>street number</b>";
  } else {
    // regex: string has to start with a number and can have one letter uppr/lowr in the end
    if (preg_match("/^\d+[a-zA-Z]?$/", $number)) {
      // set cookie
      setcookie('number', $number, time() + (86400 * 30));
      return "valid";
    } else {
      return "<b>$number</b> is not a valid street number";
    }
  }
}

function valCity()
{
  // get input
  $city = $_POST['city'];

  // validate input
  if (empty($city)) {
    return "Please enter a <b>street city</b>";
  } else {
    // regex: starts with a word, can have spaces & hyphens
    if (preg_match("/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/i", $city)) {
      // set cookie
      setcookie('city', $city, time() + (86400 * 30));
      return "valid";
    } else {
      return "<b>$city</b> is not a valid city name";
    }
  }
}

function valZip()
{
  // get input
  $zip = $_POST['zip'];

  // validate input
  if (empty($zip)) {
    return "Please enter a <b>zip code</b>";
  } else {
    // regex: starts with a word, can have spaces & hyphens
    if (preg_match("/\d{4}/", $zip)) {
      // set cookie
      setcookie('zip', $zip, time() + (86400 * 30));
      return "valid";
    } else {
      return "<b>$zip</b> is not a valid zip code";
    }
  }
}




//

require 'form-view.php';