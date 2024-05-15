<?php
session_start();
require_once './components/header.php';

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if ($mysql->connect_error) {
    die("Connection failed: ". $mysql->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Hämta newsletter_id från inloggad användare
    $sqlGetNewsletter = "SELECT id FROM newsletters WHERE owner = ?";
    $stmtGetNewsletter = $mysql->prepare($sqlGetNewsletter);
    $stmtGetNewsletter->bind_param("i", $user_id); 
    $stmtGetNewsletter->execute();
    $resultGetNewsletter = $stmtGetNewsletter->get_result();

    if ($resultGetNewsletter->num_rows > 0) {
        $newsletter = $resultGetNewsletter->fetch_assoc();
        $newsletter_id = $newsletter['id'];

        // Hämta prenumeranter av nyhetsbrevets id
        $sqlGetSubscribers = "SELECT u.email, u.firstname, u.lastname
                              FROM users u 
                              JOIN user_subscriptions us ON u.id = us.user_id 
                              WHERE us.newsletter_id = ?";
        $stmtGetSubscribers = $mysql->prepare($sqlGetSubscribers);
        $stmtGetSubscribers->bind_param("i", $newsletter_id); 
        $stmtGetSubscribers->execute();
        $resultGetSubscribers = $stmtGetSubscribers->get_result();

        echo "<table border='1'><tr><th>Email:</th><th>Firstname:</th><th>Lastname:</th></tr>";
        while ($row = $resultGetSubscribers->fetch_assoc()) {
            echo "<tr><td>{$row['email']}</td><td>{$row['firstname']}</td><td>{$row['lastname']}</td></tr>";
        }
        echo "</table>";

        $stmtGetSubscribers->close();
    } else {
        echo "<main><p>Inga nyhetsbrev hittades för användaren.</p></main>";
    }

    $stmtGetNewsletter->close();
} else {
    echo "<main><p>Kunde inte hämta dina prenumeranter. </p></main>";
}

$mysql->close();

require_once './components/footer.php';
?>
