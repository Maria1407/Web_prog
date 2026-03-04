<?php
session_start();

$username = isset($_POST['Имя']) ? $_POST['Имя'] : '';
$passengers = isset($_POST['Количество_пассажиров']) ? $_POST['Количество_пассажиров'] : '';
$tariff = isset($_POST['Тариф']) ? $_POST['Тариф'] : '';
$luggage = isset($_POST['Багаж']) ? $_POST['Багаж'] : 'Нет';
$payment = isset($_POST['Тип_оплаты']) ? $_POST['Тип_оплаты'] : '';

$errors = [];
if (empty($username)) {
    $errors[] = "Имя не может быть пустым";
}
if (empty($passengers) || $passengers < 1 || $passengers > 8) {
    $errors[] = "Количество пассажиров должно быть от 1 до 8";
}
if (empty($tariff)) {
    $errors[] = "Выберите тариф";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

$_SESSION['form_data'] = [
    'name' => $username,
    'passengers' => $passengers,
    'tariff' => $tariff,
    'luggage' => $luggage,
    'payment' => $payment
];

$line = $username . ";" . $passengers . ";" . $tariff . ";" . $luggage . ";" . $payment . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

require_once 'ApiClient.php';
$api = new ApiClient();

$url = 'https://catfact.ninja/fact';
$apiData = $api->request($url);

$_SESSION['api_data'] = $apiData;

header("Location: index.php");
exit();
?>