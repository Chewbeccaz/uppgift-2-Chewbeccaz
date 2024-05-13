<?php
session_start();
require_once './components/header.php';

//Steg 1. Hämta id via sessionvariabel.
if (!isset($_SESSION['user_id'])) {
    echo "Du måste vara inloggad för att kunna se dina prenumerationer.";
    require_once './components/footer.php';
    exit;
}

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if ($mysql->connect_error) {
    die("Connection failed: ". $mysql->connect_error);
}

$user_id = $_SESSION['user_id'];

//Steg 2: SQL-query för att hämta prenumerationerna. 

$sql = "SELECT n.id, n.name, n.description FROM newsletters n JOIN user_subscriptions s ON n.id = s.newsletter_id WHERE s.user_id = ?";
$stmt = $mysql->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<main><p>My subscriptions.. </p></main>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>". $row["name"]. "</h2>";
        echo "<p>". $row["description"]. "</p>";
        echo "</div>";
    }
} else {
    echo "No subscriptions found.";
}

$mysql->close();
$stmt->close();

require_once './components/footer.php';
?>