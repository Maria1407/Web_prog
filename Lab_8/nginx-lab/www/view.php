<!DOCTYPE html>
<html>
<head>
    <title>Все заказы такси</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>История всех заказов</h1>

    <?php
    require_once 'db.php';
    require_once 'Order.php';

    $order = new Order($pdo);
    $orders = $order->getAll();

    if (!empty($orders)) {
        echo "<ul>";
        foreach ($orders as $row) {
            echo "<li>";
            echo "<b>Имя:</b> " . htmlspecialchars($row['name']) . "<br>";
            echo "<b>Пассажиров:</b> " . htmlspecialchars($row['passengers']) . "<br>";
            echo "<b>Тариф:</b> " . htmlspecialchars($row['tariff']) . "<br>";
            echo "<b>Багаж:</b> " . ($row['luggage'] ? "Да" : "Нет") . "<br>";
            echo "<b>Оплата:</b> " . htmlspecialchars($row['payment']) . "<br>";
            echo "<b>Время:</b> " . $row['created_at'];
            echo "</li><br>";
        }
        echo "</ul>";
    } else {
        echo "<p>В базе данных пока нет заказов.</p>";
    }
    ?>

    <br>
    <a href="index.php">На главную</a> |
    <a href="form.html">Сделать новый заказ</a>
</body>
</html>