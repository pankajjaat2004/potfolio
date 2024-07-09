<?php
$servername = "localhost";
$username = "id22388387_pankajjaat2004";
$password = "Pankaj12345@"; // Replace with your database password
$dbname = "id22388387_pankaj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get IP Address
function get_ip() {
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }else if(isset($_SERVER['HTTP_FORWARDED'])){
        $ip = $_SERVER['HTTP_FORWARDED'];
    }else if(isset($_SERVER['REMOTE_ADDR'])){
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if( empty($ip) || $ip == '0.0.0.0' || substr( $ip, 0, 2 ) == '::' ){
        $ip = file_get_contents('https://api.ipify.org/');
        $ip = ($ip===false?$ip:'');
    }
    return $ip;
}


try{
    $ipadd=get_ip();
    $url="https://api.ip2location.io/?key=982519B88214A4A00580422EEDF9F2A8&ip=$ipadd";
    $IPaddress=file_get_contents($url);
    
}catch(Exception $e){
    $IPaddress='none';
}




//Connection success
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO query (name, email, subject, message, IPaddress) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $subject, $message, $IPaddress);

    // Execute the statement
    if ($stmt->execute()) {
        sleep(3);
        header("Location: https://panka-jkumar-resume.000webhostapp.com");
        echo "<H1 >Thank you for contacting ,$name. I will get back to you soon!</H1>";
    } else {
        echo "<H1 text-align:center; font-style:bold; color:red;>Sorry, there was an error submitting your message. Please Refresh or try again later.</H1>";
    }

    $stmt->close();
}

$conn->close();

?>