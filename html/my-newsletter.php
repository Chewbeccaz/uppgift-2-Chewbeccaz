<?php
session_start(); 

require_once './components/header.php';

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

//Kolla om id finns med i url:en? antar det
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT name, description FROM newsletters WHERE id = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
     
} else {
    echo "Nyhetsbrevet saknas.";
    require_once './components/footer.php';
    exit;
}

echo "<main><p>MITT NYHETSBREV. Kunna redigera.</p></main>";
echo "<form method='post' action=''>";
echo "<label for='name'>Titel:</label><br>";
echo "<input type='text' id='name' name='name' value='". htmlspecialchars($row['name']). "' required><br>";
echo "<label for='description'>Beskrivning:</label><br>";
echo "<textarea id='description' name='description'>". htmlspecialchars($row['description']). "</textarea><br>";
echo "<input type='hidden' name='id' value='". htmlspecialchars($id). "'>";
echo "<input type='submit' value='Spara ändringar'>";
echo "</form>";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $sqlUpdate = "UPDATE newsletters SET name =?, description =? WHERE id =?";
    $stmtUpdate = $mysql->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $name, $description, $id);

    if($stmtUpdate->execute()) {
        echo "<p>Nyhetsbrevet har uppdaterats.</p>";
    } else {
        echo "<p>Något gick fel.". $stmtUpdate->error."</p>" ;
    }

    $stmtUpdate->close();
    $mysql->close();  
}

require_once './components/footer.php';
?>