<?php 
// session_start(); 
include_once './functions.php';
show_cookie_banner();

$menuPages = [];
if (!is_signed_in()) {
    // Om utloggad:
    $menuPages[] = ['href' => 'index.php', 'text' => 'Home'];
    $menuPages[] = ['href' => 'create-account.php', 'text' => 'Create account'];
    $menuPages[] = ['href' => 'newsletters.php', 'text' => 'All newsletters'];
    $menuPages[] = ['href' => 'login.php', 'text' => 'Log in'];
} elseif (user_has_role('prenumerant')) {
    // Om Prenumerant:
    $menuPages[] = ['href' => 'index.php', 'text' => 'Home'];
    $menuPages[] = ['href' => 'newsletters.php', 'text' => 'All newsletters'];
    $menuPages[] = ['href' => 'my-subscriptions.php', 'text' => 'My subscriptions'];
    $menuPages[] = ['href' => 'logout.php', 'text' => 'Log out'];
} else {
    // Om kund:
    $menuPages[] = ['href' => 'index.php', 'text' => 'Home'];
    $menuPages[] = ['href' => 'my-newsletter.php', 'text' => 'My newsletter'];
    $menuPages[] = ['href' => 'subscribers.php', 'text' => 'My subscribers'];
    $menuPages[] = ['href' => 'logout.php', 'text' => 'Log out'];
}
?>    
<!-- Header.php ska innehålla öppningstaggarna -->
<html>
<head>
    <title>Har du Hört AB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
    <body>
<header class="site-header">
    <div class="logo">Har Du Hört?</div>
    <nav class="navbar">
        <ul class="navbar-menu">
            <?php foreach ($menuPages as $page):?>
                <li><a href="<?php echo $page['href'];?>"><?php echo $page['text'];?></a></li>
            <?php endforeach;?>
        </ul>
    </nav>
    <!-- <h1>My Website 2</h1> -->
</header>