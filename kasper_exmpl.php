<?php
    //startar sessionen
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login preliminary</title>
</head>
<body>
<button popovertarget="my-popover">
        Login
</button>
<div id="my-popover" popover>
    <form method="POST" action="prototyp-tema.html">
        <label> Personnummer
            <input type="text" name="login">
        </label>
        <input type="submit">
    </form>
</div>

<?php

    $pdo = new PDO("mysql:dbname=grupp4;host=localhost", "sqllab", "Hare#2022");
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //om något är satt i formuläret körs koden
    if(isset($_POST["login"])){
        
        //sql fråga för att fråga om det finns en patient i databasen med det personnumret
        $sql = 'SELECT * FROM Patient WHERE PNR = :ulogin';
        $stmt = $pdo->prepare($sql);
        //binder parametern till sql frågan
        $stmt->bindParam(':ulogin', $_POST["login"]);
        $stmt->execute();

        //hämtar raden
        $patient = $stmt->fetch();

        //om raden är satt och existerar körs koden
        if($patient){
            echo "<div>";
            echo "<form method='POST' action='kasper_exmpl.php'>";
            echo "<label> QR KOD VERIFIERA MED BANKID: ";
            echo "<input type='checkbox' name='verify'>";
            echo "</label>";
            echo "<input type='hidden' name='login_conf' value='1'>";
            echo "<input type='submit'>";
            echo "</form>";
            echo "</div>";

            $_SESSION["patient_namn_temp"] = $patient['NAMN'];
        }else{
            //felmeddelande om något felaktigt skrivs in
            echo "<div class='start'><p>Felaktigt personnummer</p></div>";
        }
    }
    if(isset($_POST["verify"])){
      //sessionen sätts till TRUE för att säga till de andra sidorna att de är inloggade
      $_SESSION["loggedin"] = TRUE;
      $_SESSION["patient_namn"] = $_SESSION["patient_namn_temp"];
      unset($_SESSION["patient_namn_temp"]);
      header('Location: kasper_login.php'); //skickar personen till startsidan
      exit();
    }elseif(isset($_POST["login_confirmed"]) && !isset($_POST["verify"])){
      //felmeddelande om något felaktigt skrivs in
      echo "<div class='start'><p>BANK ID FEL</p></div>";
  }
?>
</body>
</html>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$cookiepath = "/tmp/cookies.txt";
$tmeout = 3600; // (3600=1hr)
// här sätter ni er domän
$baseurl = 'http://193.93.250.83:8080/'; 

try {
  $ch = curl_init($baseurl . 'api/method/login');
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

curl_setopt($ch, CURLOPT_POST, true);
//  ----------  Här sätter ni era login-data ------------------ //
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"usr":"a23kasju@student.his.se", "pwd":"ITORG#24"}'); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$response = json_decode($response, true);

$error_no = curl_errno($ch);
$error = curl_error($ch);
curl_close($ch);

if (!empty($error_no)) {
  echo "<div style='background-color:red'>";
  echo '$error_no<br>';
  var_dump($error_no);
  echo "<hr>";
  echo '$error<br>';
  var_dump($error);
  echo "<hr>";
  echo "</div>";
}
echo "<div style='background-color:lightgray; border:1px solid black'>";
echo '$response<br><pre>';
echo print_r($response) . "</pre><br>";
echo "</div>";

// $ch = curl_init($baseurl . 'api/resource/User?fields='. urlencode('["name", "first_name", "last_login"]'));
$ch = curl_init($baseurl . 'api/resource/Patient'); 

// man kan även specificera vilka fält man vill se
// urlencode krävs när du har specialtecken eller mellanslag  
// $ch = curl_init($baseurl . 'api/resource/User?fields='. urlencode('["name", "first_name", "last_login"]'));
// det funkerar lika bra att ta bort mellanslaget i denna fråga
// $ch = curl_init($baseurl . 'api/resource/User?fields=["name","first_name","last_login"]');

//jag kör en get request, ibland vill man kanske köra en annan typ av request, och ibland så beöver man ha med postfields
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiepath);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiepath);
curl_setopt($ch, CURLOPT_TIMEOUT, $tmeout);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


$response = curl_exec($ch);
//echo $response;
$response = json_decode($response, true);

$error_no = curl_errno($ch);
$error = curl_error($ch);
curl_close($ch);

if (!empty($error_no)) {
  echo "<div style='background-color:red'>";
  echo '$error_no<br>';
  var_dump($error_no);
  echo "<hr>";
  echo '$error<br>';
  var_dump($error);
  echo "<hr>";
  echo "</div>";
}
echo "<div style='background-color:lightgray; border:1px solid black'>";
echo '$response<br><pre>';
echo print_r($response) . "</pre><br>";
echo "</div>";

//här väljer jag att loopa över alla poster i [data] och för varje resultat så skriver jag ut name
echo "<strong>LISTA:</strong><br>";
foreach($response['data'] AS $key => $value){
  echo $value["name"]."<br>";
}

?>