<?php

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


class Products
{
  private $name;
  private $price;

  function __construct()
  {
  }
}

echo $food[0]['name'];
die();
