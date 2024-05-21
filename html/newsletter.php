<?php
session_start(); 

require_once './functions.php';
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
            echo "<main>"; 
            echo "<h2>". htmlspecialchars($row['name']). "</h2>";
            echo "<p>". htmlspecialchars($row['description']). "</p>";

            //Kolla om användaren är inloggad och prenumerant
            if(is_signed_in()){
                $sqlCheckSubscription = "SELECT COUNT(*) AS count FROM user_subscriptions WHERE newsletter_id =? AND user_id =?";
                $stmtCheckSubscription = $mysql->prepare($sqlCheckSubscription);
                $stmtCheckSubscription->bind_param("ii", $id, $_SESSION['user_id']);
                $stmtCheckSubscription->execute();
                $resultCheckSubscription = $stmtCheckSubscription->get_result();
                $rowCheckSubscription = $resultCheckSubscription->fetch_assoc();

                if($rowCheckSubscription['count'] > 0) {
                    echo '<form method="post" action="">';
                    echo '<input type="hidden" name="action" value="unsubscribe">';
                    echo '<button type="submit" class="btn-primary">Avluta Prenumeration</button>';
                    echo '</form>';
                } else {
                    echo '<form method="post" action="">';
                    echo '<input type="hidden" name="action" value="subscribe">';
                    echo '<button type="submit" class="btn-primary">Prenumerera</button>';
                    echo '</form>';
                } 
            } else {
                // If the user is not signed in, show the "Logga in för att prenumerera" button
                echo '<form method="post" action="login.php">';
                echo '<input type="hidden" name="action" value="subscribe">';
                echo '<button type="submit" class="btn-primary">Logga in för att prenumerera</button>';
                echo '</form>';
            }

            //LÄgg till knappar
            if(isset($_POST['action']) && $_POST['action'] == 'subscribe') {
            
                $sqlSubscribe = "INSERT INTO user_subscriptions (newsletter_id, user_id) VALUES (?,?)";
                $stmtSubscribe = $mysql->prepare($sqlSubscribe);
                $stmtSubscribe->bind_param("ii", $id, $_SESSION['user_id']); 
                if($stmtSubscribe->execute()) {
                    echo "Successfully subscribed to the newsletter.";
                } else {
                    echo "Failed to subscribe: ". $stmtSubscribe->error;
                }
                $stmtSubscribe->close();
            } elseif(isset($_POST['action']) && $_POST['action'] == 'unsubscribe') {
               
                $sqlUnsubscribe = "DELETE FROM user_subscriptions WHERE newsletter_id =? AND user_id =?";
                $stmtUnsubscribe = $mysql->prepare($sqlUnsubscribe);
                $stmtUnsubscribe->bind_param("ii", $id, $_SESSION['user_id']); 
                if($stmtUnsubscribe->execute()) {
                    echo "Successfully unsubscribed from the newsletter.";
                } else {
                    echo "Failed to unsubscribe: ". $stmtUnsubscribe->error;
                }
                $stmtUnsubscribe->close();
            } 

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

echo "</main>";
include_once("/var/www/html/components/footer.php");
?>