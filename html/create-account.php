<?php

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");
require_once './components/header.php';

if ($mysql->connect_error) {
    die("Anslutningen till databasen misslyckades: ". $mysql->connect_error);
}

// Kontrollera om formuläret har skickats
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Kontrollera att lösenorden stämmer överens
    if ($password!== $confirm_password) {
        echo "Lösenorden matchar inte.";
        exit;
    }

     // En kontroll för att se om e-postadressen redan finns i databasen
     //Om man byter roll? 
     $checkEmailSql = "SELECT * FROM users WHERE email =?";
     $checkEmailStmt = $mysql->prepare($checkEmailSql);
     $checkEmailStmt->bind_param("s", $email);
 
     $checkEmailStmt->execute();
     $checkEmailResult = $checkEmailStmt->get_result();
 
     if ($checkEmailResult->num_rows > 0) {
         echo "En användare med den angivna e-postadressen finns redan.";
         exit;
     }
  
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, firstname, lastname, password, role) VALUES (?,?,?,?,?)";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("sssss", $email, $firstname, $lastname, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Användare skapad";

        $lastId = $mysql->insert_id;
        
        // Om användaren är en "kund", lägg till en rad i newsletter-tabellen
        if ($role === 'kund') {
            $owner = $lastId; 
            $name = "Exempel Titel"; 
            $description = "Exempel Beskrivning"; 
            
            $sqlNewsletter = "INSERT INTO newsletters (name, description, owner) VALUES (?,?,?)";
            $stmtNewsletter = $mysql->prepare($sqlNewsletter);
            $stmtNewsletter->bind_param("ssi", $name, $description, $owner);
            
            if ($stmtNewsletter->execute()) {
                echo " Du har fått ett exempel-nyhetsbrev som du kan redigera under my newsletter.";
            } else {
                echo "Ett fel uppstod vid skapandet av nyhetsbrev: ". $stmtNewsletter->error;
            }
        }
    } else {
        echo "Ett fel uppstod: ". $stmt->error;
    }

    $stmt->close();
    if (isset($stmtNewsletter)) { 
        $stmtNewsletter->close();
    }
    $mysql->close();
} else {
    // Om formuläret inte har skickats, visa det igen
    require_once './components/header.php';
?>

<div class="account-form">
<h3>SKAPA KONTO:</h3>
        <form method="post">
            E-post: <input type="email" name="email" required><br>
            Förnamn: <input type="text" name="firstname" required><br>
            Efternamn: <input type="text" name="lastname" required><br>
            Lösenord: <input type="password" name="password" required><br>
            Bekräfta lösenord: <input type="password" name="confirm_password" required><br>
            Roll: <select name="role" required>
                    <option value="kund">Kund</option>
                    <option value="prenumerant">Prenumerant</option>
                  </select><br>
            <input type="submit" value="SKAPA KONTO">
        </form>
</div>

<?php
    require_once './components/footer.php'; 
}
?>
