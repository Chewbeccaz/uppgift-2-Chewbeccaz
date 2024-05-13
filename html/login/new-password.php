<?php
session_start();
$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db"); 

require_once '../components/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $new_password = $_POST['new_password'];

    // Hämta user_id baserat på e-postadressen
    $sql = "SELECT id AS user_id FROM users WHERE email =?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_id = $result->fetch_assoc()['user_id']; 

    // Kontrollera om koden är giltig
    $sql = "SELECT * FROM reset_password WHERE user_id =? AND code =?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("is", $user_id, $code); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Koden är giltig, uppdatera lösenordet
        // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); //LÄgg till hash sen. 
        $update_sql = "UPDATE users SET password =? WHERE email =?";
        $update_stmt = $mysql->prepare($update_sql);
        $update_stmt->bind_param("ss", $new_password, $email);
        $update_stmt->execute();

        echo "Lösenordet har uppdaterats.";
    } else {
        echo "Återställningskoden är ogiltig.";
    }
    
    $stmt->close();
} else {
    // Skapa en form för att skicka e-postadressen och koden
    echo '<form method="post" action="">';
    echo 'E-post: <input type="email" name="email" required><br>';
    echo 'Kod: <input type="text" name="code" required><br>';
    echo 'Nytt lösenord: <input type="password" name="new_password" required><br>';
    echo '<input type="submit" value="Uppdatera lösenord">';
    echo '</form>';
}

require_once '../components/footer.php';
?>
