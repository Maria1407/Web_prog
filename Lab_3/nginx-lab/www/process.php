<?php
session_start();

$name = isset($_POST['Имя']) ? $_POST['Имя'] : '';
$passengers = isset($_POST['Количество пассажиров']) ? $_POST['Количество пассажиров'] : '';
$tariff = isset($_POST['Тариф']) ? $_POST['Тариф'] : '';
$luggage = isset($_POST['Багаж']) ? $_POST['Багаж'] : 'Нет';
$payment = isset($_POST['Тип оплаты']) ? $_POST['Тип оплаты'] : '';

$errors = [];
if (empty($name)) {
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
    'name' => $name,
    'passengers' => $passengers,
    'tariff' => $tariff,
    'luggage' => $luggage,
    'payment' => $payment
];

$line = date('Y-m-d H:i:s') . ";" . $name . ";" . $passengers . ";" . $tariff . ";" . $luggage . ";" . $payment . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

header("Location: index.php");
exit();
?>