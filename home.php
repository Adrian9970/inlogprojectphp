<?php
session_start();
include('conn.php');

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php'); // Stuur de gebruiker naar de inlogpagina na uitloggen
}
function geefgegevens($pdo, $email) {
    $sql = "SELECT g.*, r.naam AS gebruikersrol FROM Gebruiker g
            INNER JOIN Rol r ON g.rolId = r.ID
            WHERE g.email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// Gebruik de functie om de gegevens van de ingelogde gebruiker op te halen
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];
    $userData = geefgegevens($pdo, $userEmail);

    if ($userData) {
        echo "Welkom, " . $userData['voornaam'] . ", " . $userData['achternaam'] . " ,". $userData['klas'].",".  $userData['email']. "<br>";
        echo "Gebruikersrol: " . $userData['gebruikersrol'];
    } else {
        echo "Gebruiker niet gevonden.";
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center; /* Centreer tekst in het midden van de pagina */
            <?php
            if (isset($_SESSION['user_email'])) {
                $userEmail = $_SESSION['user_email'];
                $userData = geefgegevens($pdo, $userEmail);
                
                if ($userData) {
                    if ($userData['gebruikersrol'] === 'Admin') {
                        echo 'background-color: lightgreen;';
                    } elseif ($userData['gebruikersrol'] === 'Gebruiker') {
                        echo 'background-color: lightblue;';
                    }
                }
            }
            ?>
        }
        .logout input {
        background-color:white;
        width: 10vw;
        height: 5vh;
        margin-bottom: 20px;
        margin-top: 50px;
        font-weight: 600;
        color: black;
        border: none;
        outline: none;
        border-radius: 40px;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        position: relative;
        left: 5%;
        transform:translate(-50%, -50%);
    }
    .logout input:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
    
    .logout input:active {
        transform: translate(-50%, -50%) scale(0.95); 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    }
    
    </style>
</head>
<body>
    <form method="post">
<div class="logout">
        <input type="submit" name="logout" value="logout">
    </div>
    </form>
</body>
</html>