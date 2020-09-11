<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <title>Order food & drinks</title>
</head>

<body>
  <div class="container">
    <div class="mt-4 row">
      <h1 class="mx-auto ">Order at "the PHP"</h1>
    </div>
    <nav class="m-4 row">
      <ul class="mx-auto nav">
        <li class="nav-item">
          <a class="nav-link active" href="?food=1">Order food 🍔</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?food=0">Order drinks 🍾</a>
        </li>
      </ul>
    </nav>

    <div class="alert <?= $alert ?>" role="alert"><?= $info ?></div>

    <form method="post">

      <!-- EMAIL -->
      <div class="row">
        <div class="mx-auto col-md-6">
          <label for="email">E-mail:</label>
          <input type="text" id="email" name="email" class="form-control" placeholder="<?= $form_email ?>" required>
        </div>
        <div></div>
      </div>

      <!-- ADDRESS -->
      <fieldset>
        <legend>Address</legend>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="street">Street Name:</label>
            <input type="text" name="street" id="street" class="form-control" placeholder="<?= $form_street ?>" value="<?= $form_street ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label for="streetnumber">Street Number:</label>
            <input type="text" id="streetnumber" name="number" class="form-control" placeholder="<?= $form_number ?>" value="<?= $form_number ?>" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" class="form-control" placeholder="<?= $form_city ?>" value="<?= $form_city ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label for="zipcode">Zipcode</label>
            <input type="text" id="zipcode" name="zip" class="form-control" placeholder="<?= $form_zip ?>" value="<?= $form_zip ?>" required>
          </div>
        </div>
      </fieldset>

      <!-- PRODUCTS -->
      <fieldset>
        <legend>Products</legend>
        <?php foreach ($products as $i => $product) : ?>
          <label>
            <input type="checkbox" value="<?= $product['price'] ?>" name="products[<?php echo $i ?>]" /> <?php echo $product['name'] ?> -
            &euro; <?php echo number_format($product['price'], 2) ?></label><br />
        <?php endforeach; ?>
      </fieldset>

      <!-- DELIVERY -->
      <fieldset class="my-2">
        <legend>Delivery</legend>
        <input type="radio" value="0" name="delivery" checked required />
        <label for="normal">🚚 Normal (2h) Free</label><br />
        <input type="radio" value="1" name="delivery" required />
        <label for="express">🏎 Express (45min) +€5</label>
      </fieldset>


      <!-- SUBMIT -->
      <div class="m-4 row">
        <button type="submit" class="mx-auto btn btn-primary">Order!</button>
      </div>
    </form>

    <!-- HISTORY -->
    <footer class="m-4 row">
      <div class='mx-auto alert alert-info' role='alert'>
        Thank you for spending a total of
        <strong>&euro; <?php echo $totalValue ?></strong>
        in our web shop 💝 <br />
      </div>
    </footer>
  </div>
</body>

</html>