<?php
session_start(); 

$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['email']) && isset($_POST['password'])) {
    $mail = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT id, role, password FROM users WHERE email =?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("s", $mail); 
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $hashed_password_from_db = $row['password'];
    $user_id = $row['id'];
    $user_role = $row['role'];

    if(password_verify($password, $hashed_password_from_db)) {
        // om lösen är giltigt, starta session och logga in användaren
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        $redirectTo = isset($_GET['redirectTo'])? $_GET['redirectTo'] : 'index.php';
        header("Location: ". $redirectTo);
        exit;
    } else {
        $error_msg = "Fel användarnamn eller lösenord";
    }

    $stmt->close();
}
}
require_once './components/header.php';

echo "<main><p>LOG IN</p></main>";
if(isset($error_msg)) { ?>
<p style="color: red;"><?php echo $error_msg; ?></p>
<?php 
}
?> 

<p>Har du glömt ditt lösenord? <a href="password.php">Klicka här för att återställa</a>.</p>

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