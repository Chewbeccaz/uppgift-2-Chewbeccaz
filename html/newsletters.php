<?php

require_once './components/header.php';

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if ($mysql->connect_error) {
    die("Connection failed: ". $mysql->connect_error);
}

$sql = "SELECT id, name, description FROM newsletters";
$result = $mysql->query($sql);

echo "<main><h2>ALL NEWSLETTERS.</h2>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='newsletter-item'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['description'] . "</p> <br>";
        echo "<a href='newsletter.php?id=". $row['id']. "' class='btn btn-primary'>Läs mer</a>";
        echo "</div>";
    }
} else {
    echo "No newsletters for you. Sorri.";
}
echo "</main>";

$mysql->close();

require_once './components/footer.php';
?>