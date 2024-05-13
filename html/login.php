<?php
session_start(); 

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $mail = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("ss", $mail, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        //Starta session om användare hittas
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        header("Location: index.php");
        exit;
    } else {
        $error_msg = "Fel användarnamn eller lösenord";
    }

    $stmt->close();
}
require_once './components/header.php';

echo "<main><p>LOG IN</p></main>";
if(isset($error_msg)) { ?>
<p style="color: red;"><?php echo $error_msg; ?></p>
<?php 
}
?> 

<p>Har du glömt ditt lösenord? <a href="login/password.php">Klicka här för att återställa</a>.</p>

    <h2>Logga in</h2>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Logga in">
    </form>

<?php
require_once './components/footer.php';
?>