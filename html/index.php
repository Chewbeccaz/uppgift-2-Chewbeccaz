<?php
session_start();
include 'functions.php';
include_once './components/header.php';

echo "<main><p>This is the main content of the page.</p></main>";
if(is_signed_in() && user_has_role('kund')){
    echo "välkommen, du är i kundläget.";
} else if(is_signed_in() && user_has_role('prenumerant')){
    echo "välkommen, du är i prenumerantläget.";
} else {
    echo "välkommen, vänligen logga in för att se mer hörru.";
}
include_once './components/footer.php'; 

//Måste man avsluta någon session? 
?>