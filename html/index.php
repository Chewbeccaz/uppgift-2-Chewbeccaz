<?php
session_start();
include 'functions.php';
include_once './components/header.php';

?>

<main>
        <p class="welcome-message">Välkommen!</p>
        <?php
        if(is_signed_in() && user_has_role('kund')){
            echo "Du är inloggad som en kund. <br>";
            echo "Du hittar ditt nyhetsbrev och dina prenumeranter i menyn.";
        } else if(is_signed_in() && user_has_role('prenumerant')){
            echo "Du är inloggad som prenumerant. <br>";
            echo "Du hittar dina prenumerationer i menyn. <br>";
            echo "Här hittar du fler nyhetsbrev att prenumerera på. <br><br> <a href='newsletters.php' class='btn btn-primary'>Alla nyhetsbrev</a>";
        } else {
            echo "Logga in för att börja prenumerera på nyhetsbrev. <br><br>";
            echo "<a href='newsletters.php' class='btn btn-primary'>Alla nyhetsbrev</a>";
        }
       ?>
    </main>

    <?php include_once './components/footer.php';?>