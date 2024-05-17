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
            echo "Här hittar du fler nyhetsbrev att prenumerera på. <a href='newsletters.php'>Alla nyhetsbrev</a>";
        } else {
            echo "Logga in för att börja prenumerera på nyhetsbrev. <br>";
            echo "<a href='newsletters.php'>Alla nyhetsbrev</a>";
        }
       ?>
    </main>

    <?php include_once './components/footer.php';?>

<!-- echo "<main><p class='welcome-message'>This is the main content of the page.</p></main>";
if(is_signed_in() && user_has_role('kund')){
    echo "välkommen, du är i kundläget.";
} else if(is_signed_in() && user_has_role('prenumerant')){
    echo "välkommen, du är i prenumerantläget.";
} else {
    echo "välkommen, vänligen logga in för att se mer hörru.";
}
include_once './components/footer.php'; 

?> -->