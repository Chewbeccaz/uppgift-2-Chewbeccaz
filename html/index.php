<?php
session_start();
include 'functions.php';
include_once './components/header.php';

?>

<main>
        <p class="welcome-message">This is the main content of the page.</p>
        <?php
        if(is_signed_in() && user_has_role('kund')){
            echo "Välkommen, du är i kundläget.";
        } else if(is_signed_in() && user_has_role('prenumerant')){
            echo "Välkommen, du är i prenumerantläget.";
        } else {
            echo "Välkommen, vänligen logga in för att se mer här.";
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