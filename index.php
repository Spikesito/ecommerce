<?php
include("functions.php");
include ('functions/db_functions.php');

require 'vendor/autoload.php';


// Connexion à la base
$dbh=db_connect();



// Récupère la liste des customers
$sql = 'select * from customer';
try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    // Instance
    $faker = Faker\Factory::create('fr_FR');
    // echo $faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg');
    fillDB();
    // fillCustomer();
    // echo $faker -> zipcode();
    // echo $faker->uuid();
    // if (count($rows)>0) {
    //     echo '<table>';
    //     echo '<tr><th>LastName</th><th>FirstName</th><th>PhoneNumber</th><th>Email</th></tr>';
    //     foreach ($rows as $row) {
    //         echo '<tr>';
    //         echo '<td>'.$row['LastName'].'</td>';
    //         echo '<td>'.$row['FirstName'].'</td>';
    //         echo '<td>'.$row['PhoneNumber'].'</td>';
    //         echo '<td>'.$row['Email'].'</td>';
    //         echo "</tr>";
    //     }
    //     echo "</table>";
    // } else {
    //     echo "<p>Rien à afficher</p>";
    // }
?>
</body>

</html>