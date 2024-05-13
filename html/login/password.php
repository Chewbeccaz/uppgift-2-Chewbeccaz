<?php
session_start();
$mysql = new mysqli("db", "root", "notSecureChangeMe", "newsletter_db"); 

require_once '../components/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT id AS user_id FROM users WHERE email =?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_id = $result->fetch_assoc()['user_id'];

    if ($result->num_rows > 0) {
        $random_code = rand(100000, 999999);
        $save_code = "INSERT INTO reset_password (user_id, code) VALUES (?,?)";
        $save_stmt = $mysql->prepare($save_code);
        $save_stmt->bind_param("is", $user_id, $random_code); 
        $save_stmt->execute();

        $api_key = '6801a1683e8bc05c6caa558441f86332-ed54d65c-90f79098';
        $domain = 'sandboxf6f87e056e944f6ba17636acf63b82a5.mailgun.org';
        $url = 'https://api.mailgun.net/v3/'.$domain.'/messages';

        $my_message = [
            'from' => 'Excited User <mailgun@'. $domain. '>',
            'to' => $email,
            'subject' => 'Återställningskod',
            'text' => "En återställningskod: {$random_code}."
        ];

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:{$api_key}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $my_message);

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response === false) {
            die('Curl failed: '. curl_error($ch));
        } else {
            echo 'Du har fått ettmail med återställningskod i din skräppost!!';
        }
    } else {
        echo "E-postadressen finns inte i databasen.";
    }
    
    $stmt->close();
} else {
    echo '<form method="post" action="">';
    echo 'E-post: <input type="email" name="email" required><br>';
    echo '<input type="submit" value="Skicka återställningskod">';
    echo '</form>';
}

require_once '../components/footer.php';
?>
