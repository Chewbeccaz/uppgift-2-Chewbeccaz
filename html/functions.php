<?php 

function is_signed_in() {
    return isset($_SESSION['user_id']);
}

function user_has_role($role) {
    if (isset($_SESSION['role'])) {
        return $_SESSION['role'] == $role;
    }
    return false;
}

//Göra en egen för kund eller ta bort hårdkodade. bara role.?
// function require_role($role = "prenumerant") { 
//     if (!is_signed_in() ||!user_has_role($role)) {
//         header("Location: no-access.php");
//         exit;
//     }
// }
// 

function require_role($role) { 
    if (!is_signed_in()) {
        header("Location: no-access.php");
        exit;
    }
    if (!user_has_role($role)) {
        header("Location: no-access.php");
        exit;
    }
}
?>