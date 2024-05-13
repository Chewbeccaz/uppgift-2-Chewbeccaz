<?php

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");
require_once './components/header.php';

if ($mysql->connect_error) {
    die("Anslutningen till databasen misslyckades: ". $mysql->connect_error);
}

// Kontrollera om formuläret har skickats
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Kontrollera att lösenorden stämmer överens
    if ($password!== $confirm_password) {
        echo "Lösenorden matchar inte.";
        exit;
    }

    // $password_hash = password_hash($password, PASSWORD_DEFAULT); //lägg till detta sen. 

    $sql = "INSERT INTO users (email, password, role) VALUES (?,?,?)";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $role);

    if ($stmt->execute()) {
        echo "Användare skapad";
    } else {
        echo "Ett fel uppstod: ". $stmt->error;
    }

    $stmt->close();
    $mysql->close();
} else {
    // Om formuläret inte har skickats, visa det igen
    require_once './components/header.php';
?>

<div>
<h3>SKAPA KONTO:</h3>
        <form method="post">
            E-post: <input type="email" name="email" required><br>
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
