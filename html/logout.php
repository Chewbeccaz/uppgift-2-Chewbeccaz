<?php
session_start();

// Töm med unset
unset($_SESSION['user_id']);
unset($_SESSION['role']);

header("Location: logged-out.php");
exit;
?>