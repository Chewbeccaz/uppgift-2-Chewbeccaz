<?php 
// session_start(); 
include_once './functions.php';

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
    <title><?php echo $pageTitle;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
    <body>
<header>
    <div>Logo</div>
    <h1>My Website 2</h1>
    <nav>
        <ul>
            <?php foreach ($menuPages as $page):?>
                <li><a href="<?php echo $page['href'];?>"><?php echo $page['text'];?></a></li>
            <?php endforeach;?>
        </ul>
    </nav>
    <!-- <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="create-account.php">Create account</a></li>
            <li><a href="newsletters.php">print newsletters</a></li>
            <li><a href="newsletter.php">newsletter prenumerera/avregistrera</a></li>
            <li><a href="login.php">Log in</a></li>
            <li><a href="login/password.php">återställ lösenord</a></li>
            <li><a href="login/new-password.php">ange nytt lösenord</a></li>
            <li><a href="logged-out.php">utloggad</a></li>
            <li><a href="my-page.php">Min sida</a></li>
            <li><a href="my-subscriptions.php">Mina prenumerationer</a></li>
            <li><a href="subscribers.php">Mina prenumeranter</a></li>
            <li><a href="my-newsletter.php">Mitt nyhetsbrev, redigera</a></li>
        </ul>
    </nav> -->
</header>