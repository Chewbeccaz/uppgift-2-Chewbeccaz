<?php
session_start(); 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Hårdkodade exempel
    $exampel_email = "test@test.com";
    $exampel_password = "12345";

    //Hämta från formuläret: 
    $mail = $_POST['email'];
    $password = $_POST['password'];
    
    //Kolla om match
    if($mail == $exampel_email && $password == $exampel_password) {
        $_SESSION['user_id'] = 1;
        $_SESSION['role'] = "kund";
        
        header("Location: index.php");
        exit;
    } else {
        $error_msg = "Fel användarnamn eller lösenord";
    }

}
require_once 'header.php';

echo "<main><p>LOG IN</p></main>";
if(isset($error_msg)) { ?>
<p style="color: red;"><?php echo $error_msg; ?></p>
<?php 
}
?> 

    <h2>Logga in</h2>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Logga in">
    </form>

<?php
require_once 'footer.php'; 
?>