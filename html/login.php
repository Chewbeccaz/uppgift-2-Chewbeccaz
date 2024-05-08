<?php
session_start(); 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Hårdkodade exempel
      $customer_email = "k@test.com";
      $customer_password = "k123";
  
      $subscriber_email = "s@test.com";
      $subscriber_password = "s123";

    //Hämta från formuläret: 
    $mail = $_POST['email'];
    $password = $_POST['password'];
    
    //Kolla om match
    if($mail == $customer_email && $password == $customer_password) {
        $_SESSION['user_id'] = 1;
        $_SESSION['role'] = "kund";
        
        header("Location: index.php");
        exit;
    } else if ($mail == $subscriber_email && $password == $subscriber_password) {
        $_SESSION['user_id'] = 2;
        $_SESSION['role'] = "prenumerant";
        
        header("Location: index.php");
        exit;
    
    }else {
        $error_msg = "Fel användarnamn eller lösenord";
    }

}
require_once './components/header.php';

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
require_once './components/footer.php';
?>