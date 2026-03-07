<!DOCTYPE html>
<html>
<head>
    <title>Все заказы такси</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>История всех заказов</h1>

    <?php
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES);

        if (!empty($lines)) {
            echo "<ul>";
            foreach ($lines as $line) {
                $data = explode(";", $line);
                if (count($data) >= 5) {
                    echo "<li>";
                    echo "<b>Имя:</b> " . htmlspecialchars($data[0]) . "<br>";
                    echo "<b>Пассажиров:</b> " . htmlspecialchars($data[1]) . "<br>";
                    echo "<b>Тариф:</b> " . htmlspecialchars($data[2]) . "<br>";
                    echo "<b>Багаж:</b> " . htmlspecialchars($data[3]) . "<br>";
                    echo "<b>Оплата:</b> " . htmlspecialchars($data[4]);
                    echo "</li><br>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p>Файл пуст.</p>";
        }
    } else {
        echo "<p>Еще нет заказов.</p>";
    }
    ?>

    <br>
    <a href="index.php">На главную</a> |
    <a href="form.html">Сделать новый заказ</a>
</body>
</html>