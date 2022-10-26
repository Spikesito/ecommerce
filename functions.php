<?php
require 'vendor/autoload.php';

/* Ecrit dans une log dans le dossier courant
 *
 * @param string $page le nom de la page PHP
 * @return void
 */
// function logToDisk($page)
// {
  // Horodatage
  //   $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
  //   $laDate = $date->format("Y-m-d H:i:s.u");
  //   $root = dirname(FILE); // Dossier courant
  //   //$message = $laDate . ";" . $_SERVER['REMOTE_ADDR'] . ";" . $page . ";" . PHP_EOL;
  //   $message = $laDate . ";" . get_ip() . ";" . $page . PHP_EOL;
  //   $filename = $root . DIRECTORY_SEPARATOR . 'logs/log.txt';
  //   file_put_contents($filename, $message, FILE_APPEND);
  // }


  /* Retourne une adresse IP
 *
 * @return void
 */
  // function get_ip()
  // {
  //   $ip = $_SERVER['HTTP_CLIENT_IP']
  //     ?? $_SERVER["HTTP_CF_CONNECTING_IP"] # when behind cloudflare
  //     ?? $_SERVER['HTTP_X_FORWARDED']
  //     ?? $_SERVER['HTTP_X_FORWARDED_FOR']
  //     ?? $_SERVER['HTTP_FORWARDED']
  //     ?? $_SERVER['HTTP_FORWARDED_FOR']
  //     ?? $_SERVER['REMOTE_ADDR']
  //     ?? '0.0.0.0';
  //   return $ip;
  // }




  //FILL DATABASE functions

  //Function Used to generate Random Float
  function rand_float($st_num = 0, $end_num = 1, $mul = 1000000)
  {
    if ($st_num > $end_num) return false;
    return mt_rand($st_num * $mul, $end_num * $mul) / $mul;
  }




  //Functions Used to generate each part of the DB

  //create Customers
  function createCustomer($dbh, $faker, $nbCustomerId)
  {
    for ($i = 0; $i < $nbCustomerId; $i++) {
      $sql = "insert into customer (LastName, FirstName, PhoneNumber, Email) values (:LastName, :FirstName, :PhoneNumber, :Email)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":LastName" => $faker->lastName, ":FirstName" => $faker->firstName, ":PhoneNumber" => $faker->phoneNumber, ":Email" => $faker->email));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok

  //Create All Product's categories
  function createCategories($dbh, $faker)
  {
    //Primary Key : CategoryId
    for ($i = 0; $i < 1000; $i++) {
      $sql = "insert into category (Name) values (:Name)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":Name" => $faker->word));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok

  //Insert One product
  function createProduct($dbh, $faker, $nbCategoryId, $nb)
  {
    //Primary Key : ProductId
    for ($i = 1; $i <= $nb; $i++) {
      $sql = "insert into product (Name, Price, CreationDate, Supplier, Stock, CategoryId) values (:Name, :Price, :CreationDate, :Supplier, :Stock, :CategoryId)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":Name" => $faker->word, ":Price" => rand_float(1, 100), ":CreationDate" => $faker->date(), ":Supplier" => $faker->word, ":Stock" => random_int(0, 300), ":CategoryId" => random_int(1, $nbCategoryId)));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok | once categories done


  //Create a photo Corresponding to a Product
  function createPhotoP($dbh, $faker, $nbProductId)
  {
    //Primary Key : PhotoId
    for ($i = 1; $i <= $nbProductId; $i++) {
      $sql = "insert into photop (ProductId, Link) values (:ProductId, :Link)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":ProductId" => $i, "Link" => $faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg')));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok | once products done

  //Create a photo Corresponding to a Customer
  function createPhotoU($dbh, $faker, $nbCustomerId)
  {
    //Primary Key : PhotoId
    for ($i = 1; $i <= $nbCustomerId; $i++) {
      $sql = "insert into photou (CustomerId, Link) values (:CustomerId, :Link)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => $i, "Link" => $faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg')));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok | once customers done

  //Create a payment method
  function createPaymentMethod($dbh, $faker, $nbCustomerId)
  {
    for ($i = 1; $i <= $nbCustomerId; $i++) {
      $sql = "insert into payment (CustomerId, PaymentMethod, PaymentAdress) values (:CustomerId, :PaymentMethod, :PaymentAdress)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => $i, ":PaymentMethod" => "Card", ":PaymentAdress" => $faker->streetAddress));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // to test | once customers done

  //Setup card
  function createCard($dbh, $faker, $nbCustomerId)
  {
    for ($i = 1; $i <= $nbCustomerId; $i++) {
      $sql = "insert into card (CustomerId, PaymentId, CardOwner, CardNumber, ExpirationDate, CVV) values (:CustomerId, :PaymentId, :CardOwner, :CardNumber, :ExpirationDate, :CVV)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => $i, ":PaymentId" => $i, ":CardOwner" => $faker->name, ":CardNumber" => $faker->creditCardNumber, ":ExpirationDate" => $faker->creditCardExpirationDate->format('Y-m'), ":CVV" => random_int(100, 1000)));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // to test | once customers and paymentMethod done 

  //Create Addresses
  function createAddresses($dbh, $faker, $nb)
  {
    for ($i = 0; $i < $nb; $i++) {
      $sql = "insert into address (AddressNumber, AddressName, ZipCode, Region, Country, FirstName, LastName) values (:AddressNumber, :AddressName, :ZipCode, :Region, :Country, :FirstName, :LastName)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":AddressNumber" => random_int(1, 300), ":AddressName" => $faker->streetName(), ":ZipCode" => $faker->postcode(), ":Region" => $faker->region(), ":Country" => $faker->country(), ":FirstName" => $faker->firstName(), ":LastName" => $faker->lastName()));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok | before filling customer_address 

  //Create customer_Addresses
  function createCustomerAddresses($dbh, $nbCustomerId)
  {
    for ($i = 1; $i <= $nbCustomerId; $i++) {
      $sql = "insert into customer_address (AddressId, CustomerId) values (:AddressId, :CustomerId)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":AddressId" => $i, ":CustomerId" => $i));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  //ok | once filling customers and addresses

  //Create a command
  function createCommand($dbh, $nb)
  {
    for ($i = 1; $i <= $nb; $i++) {
      $sql = "insert into command (CustomerId) values (:CustomerId)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => $i));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // to test

  //Create a command_product
  function createCommandProduct($dbh, $nbProductId, $nbCommand)
  {
    for ($i = 1; $i < $nbCommand; $i++) {
      $sql = "insert into command_product ( ProductId,CommandId, Quantity) values ( :ProductId, :CommandId, :Quantity )";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":ProductId" => random_int(1, $nbProductId),  ":CommandId" => random_int(1, $nbCommand), ":Quantity" => random_int(1, 10)));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // oké | once command and product done 

  function createInvoices($dbh, $faker, $nbCustomerId, $nbProductId, $nb)
  {
    for ($i = 1; $i <= $nb; $i++) {
      $sql = "insert into invoices (CustomerId, ProductId, InvoiceDate, CommandNumber,Quantity) values (:CustomerId, :ProductId, :InvoiceDate, :CommandNumber,:Quantity)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => random_int(1, $nbCustomerId), ":ProductId" => random_int(1, $nbProductId), ":InvoiceDate" => $faker->date(), ":CommandNumber" => $faker->uuid(), ":Quantity" => random_int(1, 200)));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // to test

  //Create a command
  function createRate($dbh, $faker, $nbCustomerId, $nbProductId, $nb)
  {
    for ($i = 0; $i < $nb; $i++) {
      $sql = "insert into rate (CustomerId, ProductId, Rate,Text) values (:CustomerId, :ProductId, :Rate,:Text)";
      try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":CustomerId" => random_int(1, $nbCustomerId), "ProductId" => random_int(1, $nbProductId), ":Rate" => rand(0, 100) / 10, ":Text" => $faker->realText(200, 2)));
      } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
      }
    }
  }
  // to test

  function fillDB()
  {
    $DBH = db_connect();
    $FAKER = Faker\Factory::create('fr_FR');
    $NB_CUSTOMER = random_int(1000, 3000); // customers must be higher than addresses
    $NB_ADDRESS = random_int(900, 1000);
    $NB_PRODUCT = 2000;
    $NB_CATEGORY = 1000;
    $NB_RATE = 3000;
    $NB_COMMAND = $NB_CUSTOMER;
    $NB_INVOICES = 3000;

    createCustomer($DBH, $FAKER, $NB_CUSTOMER);
    createAddresses($DBH, $FAKER, $NB_ADDRESS);
    createCustomerAddresses($DBH, $NB_CUSTOMER);
    createPaymentMethod($DBH, $FAKER, $NB_CUSTOMER);
    createCard($DBH, $FAKER, $NB_CUSTOMER);
    createPhotoU($DBH, $FAKER, $NB_CUSTOMER);

    createCategories($DBH, $FAKER, $NB_CATEGORY);
    createProduct($DBH, $FAKER, $NB_CATEGORY, $NB_PRODUCT);
    createPhotoP($DBH, $FAKER, $NB_PRODUCT);
    createRate($DBH, $FAKER, $NB_CUSTOMER, $NB_PRODUCT, $NB_RATE);
    createCommand($DBH, $NB_CUSTOMER, $NB_COMMAND);
    createCommandProduct($DBH, $NB_PRODUCT, $NB_COMMAND);
    createInvoices($DBH, $FAKER, $NB_CUSTOMER, $NB_PRODUCT, $NB_INVOICES);
  }
// }
