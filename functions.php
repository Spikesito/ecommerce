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

function fillCustomer() 
{
    // Instance
    $faker = Faker\Factory::create('fr_FR');
    for ($i = 0; $i <= 10; $i++) {
        $sql = "insert into customer (LastName,FirstName,PhoneNumber,Email) values (:LastName,:FirstName,:PhoneNumber,:Email)";
            try {
                $sth = $dbh->prepare($sql);
                $sth->execute(array(":LastName"=>$faker->lastName,":FirstName"=>$faker->firstName,":PhoneNumber"=>$faker->phoneNumber, ":Email"=>$faker->email));
                $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
            }
    }
}