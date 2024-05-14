<?php

require_once './components/header.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");
    if($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    $sql = "SELECT name, description FROM newsletters WHERE id = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
     $result = $stmt->get_result();
     if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<main><h2>". htmlspecialchars($row['name']). "</h2>";
            echo "<p>". htmlspecialchars($row['description']). "</p></main>";
        } else {
            echo "No newsletter found with the selected id.";
        }
    } else {
        echo "Something went wrong.". $stmt->error;
    }
    $stmt->close();
    $mysql->close();
} else {
    echo "No id provided.";
}

require_once './components/footer.php';
?>