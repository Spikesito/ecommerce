<?php
require 'vendor/autoload.php';

 /* Ecrit dans une log dans le dossier courant
 *
 * @param string $page le nom de la page PHP
 * @return void
 */
function logToDisk($page)
{
  // Horodatage
  $date = new DateTime('now',new DateTimeZone('Europe/Paris'));
  $laDate = $date->format("Y-m-d H:i:s.u");
  $root = dirname(FILE); // Dossier courant
  //$message = $laDate . ";" . $_SERVER['REMOTE_ADDR'] . ";" . $page . ";" . PHP_EOL;
  $message = $laDate .";".get_ip().";".$page.PHP_EOL;
  $filename = $root . DIRECTORY_SEPARATOR . 'logs/log.txt';
  file_put_contents($filename, $message, FILE_APPEND);
}


 /* Retourne une adresse IP
 *
 * @return void
 */
function get_ip()
{
  $ip = $_SERVER['HTTP_CLIENT_IP']
    ?? $_SERVER["HTTP_CF_CONNECTING_IP"] # when behind cloudflare
    ?? $_SERVER['HTTP_X_FORWARDED']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['HTTP_FORWARDED']
    ?? $_SERVER['HTTP_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';
  return $ip;
}




//FILL DATABASE functions

//Function Used to generate Random Float
function rand_float($st_num=0,$end_num=1,$mul=1000000)
{
if ($st_num>$end_num) return false;
return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
}




//Functions Used to generate each part of the DB

//Insert One product
function createProduct($dbh, $faker, $nbCategoryId)
{
    //Primary Key : ProductId
  $sql = "insert into product (Name, Price, CreationDate, Supplier, Stock, CategoryId) values (:Name, :Price, :CreationDate, :Supplier, :Stock, :CategoryId)";
  try {
      $sth = $dbh->prepare($sql);
      $sth->execute(array(":Name"=>$faker->word,":Price"=>$faker->rand_float(1, 100),":CreationDate"=>$faker->date(),":Supplier"=>$faker->word,":Stock"=>random_int(1,100),":CategoryId"=>random_int(1, $nbCategoryId)));
  } catch (PDOException $e) {
      die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
  }
}
//ok | once categories done

//Create All Product's categories
function createCategories($dbh, $faker)
{
    //Primary Key : CategoryId
  for ($i = 0; $i <= 30; $i++) {
    $sql = "insert into category (Name) values (:Name)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":Name"=>$faker->word));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
  }
}
//ok

//Create a photo Corresponding to a Product
function createPhotosP($dbh, $faker, $nbProductId)
{
  //Primary Key : PhotoId
  for ($i = 1; $i <= $nbProductId; $i++) {
    $sql = "insert into photop (ProductId, Link) values (:ProductId, :Link)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":ProductId"=>$i, "Link"=>$faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg')));
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
    $sql = "insert into photop (CustomerId, Link) values (:CustomerId, :Link)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":CustomerId"=>$i, "Link"=>$faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg')));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
  }
}
//ok | once customers done

//Create a payment method
function createPaymentMethod($dbh, $faker, $customerId)
{
  for ($i = 0; $i <= $customerId; $i++) {
    $sql = "insert into payment (Name) values (:Name)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":Name"=>$faker->word));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
  }
}
//not ok | once customers done

//Setup card
function createCard($dbh, $faker, $paymentId, $customerId)
{
  for ($i = 0; $i <= $customerId; $i++) {
    $sql = "insert into payment (Name) values (:Name)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":Name"=>$faker->word));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
  }
}
//not ok | once payment done and customers done

//Create a command
function createCommand($dbh, $faker, $customerId)
{
  for ($i = 0; $i <= 20; $i++) {
    $sql = "insert into category (Name) values (:Name)";
        try {
            $sth = $dbh->prepare($sql);
            $sth->execute(array(":Name"=>$faker->word));
        } catch (PDOException $e) {
            die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
        }
  }
}
//not ok

function fillCustomer() 
{
  $dbh=db_connect();
  $faker = Faker\Factory::create('fr_FR');
    
    // Instance
    // for ($i = 0; $i <= 10; $i++) {
    //     $sql = "insert into customer (LastName,FirstName,PhoneNumber,Email) values (:LastName,:FirstName,:PhoneNumber,:Email)";
    //         try {
    //             $sth = $dbh->prepare($sql);
    //             $sth->execute(array(":LastName"=>$faker->lastName,":FirstName"=>$faker->firstName,":PhoneNumber"=>$faker->phoneNumber, ":Email"=>$faker->email));
    //         } catch (PDOException $e) {
    //             die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    //         }
    // }
}