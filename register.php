<?php
include 'conn.php';

if(isset($_POST['loginbutton'])) {
    // header naar index.php
    header('Location: index.php');
    exit; 
}
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $klas = $_POST['klas'];


    // Hash wachtwoord met sha256
    $hashedWachtwoord = hash('sha256', $wachtwoord);

    // Insert data
    $sql = "INSERT INTO gebruiker (email, wachtwoord, voornaam, achternaam, klas, rolID) VALUES (:email, :wachtwoord, :voornaam, :achternaam, :klas, '2' )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':wachtwoord', $hashedWachtwoord);
    $stmt->bindParam(':voornaam', $voornaam);
    $stmt->bindParam(':achternaam', $achternaam);
    $stmt->bindParam(':klas', $klas);

    if ($stmt->execute()) {
        echo '<script>alert("account toegevoegd");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit;
    } else {
        echo "Registratie niet gelukt";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login🦍</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="container">
  
        <h1>REGISTER</h1>
    
    <form method="post" >
    <div class="email">
        <input type="email" name="email" placeholder="email" >

    </div>
    <div class="wachtwoord">    
        <input type="password" name="wachtwoord" placeholder="wachtwoord" >    
    </div>
    <div class="voornaam">    
        <input type="text" name="voornaam" placeholder="voornaam" >    
    </div>
    <div class="achternaam">    
        <input type="text" name="achternaam" placeholder="achternaam" >    
    </div>
    <div class="klas">    
        <input type="text" name="klas" placeholder="klas" >    
    </div>
    <div class="register">
        <input type="submit" name="register" value="register account">
    </div>
    <div class="loginbutton">
        <input type="submit" name="loginbutton" value="ga naar login">
    </div>
    
</form>
</div>
    
</body>
</html>