<?php
session_start();
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
    <?php else: ?>
        <p>Вы еще не сделали ни одного заказа.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['api_data'])): ?>
        <h2>Данные из API:</h2>
        <pre>
            <?php print_r($_SESSION['api_data']); ?>
        </pre>
    <?php endif; ?>

    <?php
    require_once 'UserInfo.php';
    $info = UserInfo::getInfo();
    ?>

    <h2>Информация о пользователе:</h2>
    <ul>
        <li><b>IP-адрес:</b> <?= htmlspecialchars($info['ip']) ?></li>
        <li><b>User Agent:</b> <?= htmlspecialchars($info['user_agent']) ?></li>
        <li><b>Время запроса:</b> <?= htmlspecialchars($info['time']) ?></li>
    </ul>

    <?php if (isset($_COOKIE['last_submission'])): ?>
        <p><b>Последняя отправка формы:</b> <?= $_COOKIE['last_submission'] ?></p>
    <?php endif; ?>

</body>
</html>