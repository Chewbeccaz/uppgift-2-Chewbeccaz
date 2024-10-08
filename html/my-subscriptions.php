<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
ob_start();
require_once './functions.php';
require_once './components/header.php';

//Endast prenumeranter ska kunna se sina prenumerationer.
require_role("prenumerant");

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

?>

<main>
    <h2>My subscriptions: </h2>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       
        echo '<form method="post" action="">';
        echo "<div>";
        echo "<h3>". $row["name"]. "</h3>";
        echo "<p>". $row["description"]. "</p>";
        echo '<input type="hidden" name="action" value="unsubscribe">';
        echo '<input type="hidden" name="newsletter_id" value="'. $row["id"].'"> <br>';
        echo '<button type="submit" class="btn-primary">Avsluta Prenumeration</button>';
        echo '</form>';
        echo "</div>";
    }
} else {
    echo "No subscriptions found.";
}
echo "</main>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'unsubscribe') {
    $newsletter_id = $_POST['newsletter_id'];
    
    $sqlUnsubscribe = "DELETE FROM user_subscriptions WHERE newsletter_id =? AND user_id =?";
    $stmtUnsubscribe = $mysql->prepare($sqlUnsubscribe);
    $stmtUnsubscribe->bind_param("ii", $newsletter_id, $user_id);
    if ($stmtUnsubscribe->execute()) {
        echo "Du har nu avslutat prenumerationen.";
    } else {
        echo "Något blev fel. ". $stmtUnsubscribe->error;
    }
    $stmtUnsubscribe->close();
}


$mysql->close();
$stmt->close();

include_once("/var/www/html/components/footer.php");
ob_end_flush();
?>