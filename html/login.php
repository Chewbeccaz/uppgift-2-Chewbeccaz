<?php

require_once 'header.php';

echo "<main><p>LOG IN</p></main>";
?> 

    <h2>Logga in</h2>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Logga in">
    </form>

<?php
require_once 'footer.php'; 
?>