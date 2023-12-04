<?php 
session_start();

include 'conn.php';

function checkLogin($pdo, $email, $password) {
    $sql = "SELECT * FROM gebruiker WHERE email = :email";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && hash('sha256', $password) === $user['wachtwoord']) {
        return true;
    }
    
    return false;
}

// Gebruik de functie om in te loggen
if (isset($_POST['loginbutton'])) {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    if (empty($email) || empty($wachtwoord)) {
        $error_message = "Vul zowel gebruikersnaam als wachtwoord in.";
    } else {
        if (checkLogin($pdo, $email, $wachtwoord)) {
            // Inloggen was succesvol
            $_SESSION['logged_in'] = true;
            $_SESSION['user_email'] = $email;
            echo "Succesvol ingelogd!";
            header('Location: home.php');
           
        } else {
            $error_message = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    }
}
//registreer
if(isset($_POST['register'])) {
    // Redirect to register.php
    header('Location: register.php');
    exit; // Make sure to exit to prevent further execution of the script
}


// Voeg deze regel toe om de foutmelding na het weergeven te verwijderen
unset($_SESSION['error_message']);



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
  
        <h1>LOGIN</h1>
    
    <form method="post" >
    <div class="email">
        <input type="email" name="email" placeholder="email" >

    </div>
    <div class="wachtwoord">    
        <input type="password" name="wachtwoord" placeholder="wachtwoord" >    

    </div>
    <div class="loginbutton">
        <input type="submit" name="loginbutton" value="login">
    </div>
    <div class="register">
        
    <input type="submit" name="register" value="register" >
    </div>
    <div id="error-message" style="color: red;"><?php echo !empty($error_message) ? $error_message : ''; ?></div>
</form>
</div>
    
</body>
</html>