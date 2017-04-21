<?
// ----------------------------конфигурация-------------------------- // 
const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

$adminemail = "kaktyshiny@gmail.com";  // e-mail получателя
$date = date("d.m.y"); // число.месяц.год
$time = date("H:i"); // часы:минуты:секунды
$backurl = "http://3.anxar2k.cz8.ru";  // На какую страничку переходит после отправки письма

//---------------------------------------------------------------------- //


// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6Lc1HhoUAAAAAFABpYYepV8sj2DCEnY2hYHP46DH";
$privatekey = "6Lc1HhoUAAAAAMAgNiJwdfVX4EPfH4tnMAtkqScE";


// Принимаем данные с формы
$name = $_POST['name'];
$email = $_POST['email'];
$msg = $_POST['message'];
$phone = $_POST['phone'];
$calltime = $_POST['time'];
$type = $_POST['form_type'];
$captcha = $_POST['g-recaptcha-response'];
$ip = $_SERVER['REMOTE_ADDR'];

switch ($type) {
    case "call":
        $header = "$date $time Запрос звонка на сайте SafeLine";
        $msg = "
			Имя: $name
			Телефон: $phone
			Время для звонка: $calltime";
        break;
    case "demo":
        $header = "$date $time Новое обращение на сайте SafeLine";

        $msg = "
		Имя: $name
		E-mail: $email
		Телефон: $phone
		Сообщение: $msg";
        break;
}

$curl = curl_init(SITE_VERIFY_URL);

$options = array(
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => array(
        'secret' => $privatekey,
        'response' => $captcha,
        'remoteip' => $ip
    ),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: multipart/form-data'
    ),
    CURLINFO_HEADER_OUT => false,
    CURLOPT_HEADER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true
);

//die(print_r($options, 1));

curl_setopt_array($curl, $options);

$response = curl_exec($curl);
$response = json_decode($response, true);

if ($response['success'] != false) {
    mail($adminemail, $header, $msg);
    $resp = 1;
} else{
    $resp = 2;
}

header("Location:$backurl/?q=$resp");
exit;
?>