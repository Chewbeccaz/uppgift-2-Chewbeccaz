<?php 
// session_start(); 

function is_signed_in() {
    return isset($_SESSION['user_id']);
}

function user_has_role($role) {
    if (isset($_SESSION['role'])) {
        return $_SESSION['role'] == $role;
    }
    return false;
}

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

 function show_cookie_banner()
 {
     if (!isset($_COOKIE['cookie_accepted'])) {
         echo '<style>
             #cookie-banner {
                 position: fixed;
                 bottom: 0;
                 width: 100%;
                 background-color: #88966a;
                 color: #fff;
                 text-align: center;
                 padding: 30px;
                 font-family: Poppins, sans-serif;
                 z-index: 1000;
             }
             #cookie-banner a {
                 color: #fff;
                 text-decoration: underline;
                 margin-left: 10px;
             }
             #cookie-banner a:hover {
                 color: #b1bd96;
             }
         </style>';
         echo '<div id="cookie-banner">';
         echo 'Vi använder cookies för att förbättra din upplevelse. ';
         echo '<a href="?accept_cookies=1">OK</a>';
         echo '</div>';
     }
 }

 if (isset($_GET['accept_cookies']) && $_GET['accept_cookies'] == '1') {
     setcookie('cookie_accepted', 'true', time() + (86400 * 30), "/"); //sätter en cookie i 30 dagar
     header('Location: '. $_SERVER['HTTP_REFERER']);
     exit;
 }





?>