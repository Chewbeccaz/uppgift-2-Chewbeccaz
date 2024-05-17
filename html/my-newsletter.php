<?php
session_start(); 

require_once './components/header.php';

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if (!isset($_SESSION['user_id'])) {
    die("Du måste vara inloggad för att se och redigera nyhetsbrev.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, description FROM newsletters WHERE owner =?";
$stmt = $mysql->prepare($sql);
$stmt->bind_param("i", $user_id);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();

if ($row) {
    echo "<main><p>DITT NYHETSBREV.</p>";
    echo "<div class='my-newsletter-form'>";
    echo "<form method='post' action=''>";
    echo "<label for='name'>Titel:</label><br>";
    echo "<input type='text' id='name' name='name' value='". htmlspecialchars($row['name']?? '')."' required><br>";
    echo "<label for='description'>Beskrivning:</label><br>";
    echo "<textarea id='description' name='description'>". htmlspecialchars($row['description']?? '')."</textarea><br>";
    echo "<input type='hidden' name='id' value='". htmlspecialchars($row['id']?? '')."'> <br>";
    // echo "<input type='submit' value='Spara ändringar'>";
    echo '<button type="submit" class="btn-primary">Spara ändringar</button>';
    echo "</form>";
    echo "</div>";
    echo "</main>";
} else {
    echo "Inget nyhetsbrev hittades för dig.";
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $sqlUpdate = "UPDATE newsletters SET name =?, description =? WHERE owner =?";
    $stmtUpdate = $mysql->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $name, $description, $user_id);

    if($stmtUpdate->execute()) {
        $_SESSION['newsletter_updated'] = true;
    } else {
        echo "<p>Något gick fel.". $stmtUpdate->error."</p>" ;
    }

    $stmtUpdate->close();
    $mysql->close();  
}

if(isset($_SESSION['newsletter_updated']) && $_SESSION['newsletter_updated']) {
    echo "<p>Nyhetsbrevet har uppdaterats framgångsrikt!</p>";
    unset($_SESSION['newsletter_updated']); 
}
require_once './components/footer.php';
?>
