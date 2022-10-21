<?php
 /* Exemple d'écriture des pages visitées dans un fichier log 
 */
include("functions.php");
?><?php
 /* Ajout d'un film
 */
include 'functions/db_functions.php';
// Connexion à la base
$dbh=db_connect();

// Lecture du formulaire
$LastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
$FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
$PhoneNumber = isset($_POST['PhoneNumber']) ? $_POST['PhoneNumber'] : '';
$Email = isset($_POST['Email']) ? $_POST['Email'] : '';


$submit = isset($_POST['submit']);

// Ajout dans la base
if ($submit) {
    $sql="insert into customer (LastName,FirstName,PhoneNumber,Email) values (:LastName,:FirstName,:PhoneNumber,:Email)";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":LastName"=>$LastName,":FirstName"=>$FirstName,":PhoneNumber"=>$PhoneNumber, ":Email"=>$Email));
        $nb = $sth->rowcount();
    } catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }
    $message="$nb customer added";
} else {
    $message="Select a customer";
}
// Affichage
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>E Commerce</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <p><?php echo $message; ?>
  </p>
  <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <p>LastName<br /><input name="LastName" id="LastName" type="text" value="" /></p>
    <p>FirstName<br /><input name="FirstName" id="FirstName" type="text" value="" /></p>
    <p>PhoneNumber<br /><input name="PhoneNumber" id="PhoneNumber" type="text" value="" /></p>
    <p>Email<br /><input name="Email" id="Email" type="text" value="" /></p>
    <p><input type="submit" name="submit" value="Envoyer" />&nbsp;<input type="reset" value="Réinitialiser" /></p>
  </form> -->
</body>

</html>