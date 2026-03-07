<?php
session_start();
require_once 'db.php';
require_once 'Order.php';

$order = new Order($pdo);
$all_orders = $order->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Главная - Заказ такси</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Система заказа такси</h1>

    <p>
        <a href="form.html">Сделать новый заказ</a> |
        <a href="view.php">Посмотреть все заказы</a>
    </p>

    <?php if (isset($_SESSION['errors'])): ?>
        <div style="color: red; border: 1px solid red; padding: 10px;">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['form_data'])): ?>
        <h2>Ваш последний заказ:</h2>
        <ul>
            <li><b>Имя:</b> <?= $_SESSION['form_data']['name'] ?></li>
            <li><b>Количество пассажиров:</b> <?= $_SESSION['form_data']['passengers'] ?></li>
            <li><b>Тариф:</b> <?= $_SESSION['form_data']['tariff'] ?></li>
            <li><b>Багаж:</b> <?= $_SESSION['form_data']['luggage'] ?></li>
            <li><b>Тип оплаты:</b> <?= $_SESSION['form_data']['payment'] ?></li>
        </ul>
    <?php endif; ?>

    <h2>Все заказы из базы данных:</h2>
    <?php if (!empty($all_orders)): ?>
        <ul>
        <?php foreach ($all_orders as $row): ?>
            <li>
                <b><?= htmlspecialchars($row['name']) ?></b> -
                <?= $row['passengers'] ?> пасс. -
                <?= $row['tariff'] ?> -
                Багаж: <?= $row['luggage'] ? 'Да' : 'Нет' ?> -
                Оплата: <?= $row['payment'] ?> -
                <small><?= $row['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>В базе данных пока нет заказов.</p>
    <?php endif; ?>

</body>
</html>