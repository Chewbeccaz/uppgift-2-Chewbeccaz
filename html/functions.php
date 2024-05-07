<?php 

function is_signed_in() {
    return isset($_SESSION['user_id']); //Returnerar true om användaren är inloggad, annars false
}

function user_has_role($role) {
    if (isset($_SESSION['role'])) {
        return $_SESSION['role'] == $role;
    }
    return false;
}
?>