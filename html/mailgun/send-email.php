<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];

    $random_code = rand(100000, 999999);

    $api_key = '6801a1683e8bc05c6caa558441f86332-ed54d65c-90f79098';
    $domain = 'sandboxf6f87e056e944f6ba17636acf63b82a5.mailgun.org';
    $url = 'https://api.mailgun.net/v3/'.$domain.'/messages';


    $my_message = [
        'from' => 'Excited User <mailgun@' . $domain . '>',
        'to' => $email,
        'subject' => 'Your Random Code',
        'text' => "En random kod : {$random_code}"
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
        die('Curl failed: ' . curl_error($ch));
    } else {
        echo 'Du har fått ett skoj mail i din skräppost!!';
    }
}
?>

<h2>Send email:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    E-post: <input type="email" name="email" required><br>
    <input type="submit" value="Submit">
    </form>