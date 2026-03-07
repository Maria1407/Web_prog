<?php
session_start();

require_once 'db.php';
require_once 'Order.php';

$username = isset($_POST['Имя']) ? $_POST['Имя'] : '';
$passengers = isset($_POST['Количество пассажиров']) ? $_POST['Количество пассажиров'] : '';
$tariff = isset($_POST['Тариф']) ? $_POST['Тариф'] : '';
$luggage = isset($_POST['Багаж']) ? $_POST['Багаж'] : 'Нет';
$payment = isset($_POST['Тип оплаты']) ? $_POST['Тип оплаты'] : '';

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

// Сохраняем в БД
$order = new Order($pdo);
$order->add($username, $passengers, $tariff, $luggage, $payment);

$_SESSION['form_data'] = [
    'name' => $username,
    'passengers' => $passengers,
    'tariff' => $tariff,
    'luggage' => $luggage,
    'payment' => $payment
];

setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

header("Location: index.php");
exit();
?>