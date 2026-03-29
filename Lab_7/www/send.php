<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'QueueManager.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Метод не разрешен. Используйте POST.";
    exit;
}

try {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $action = $_POST['action'] ?? 'register';

    if (empty($name)) {
        throw new Exception("Имя обязательно для заполнения");
    }

    $message = [
        'id' => uniqid(),
        'name' => $name,
        'email' => $email ?: 'не указан',
        'action' => $action,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];

    $queue = new QueueManager();
    $queue->publish($message);

    echo "✅ Сообщение успешно отправлено в очередь RabbitMQ!<br>";
    echo "ID сообщения: " . htmlspecialchars($message['id']) . "<br>";
    echo "Имя: " . htmlspecialchars($name) . "<br>";
    echo "Операция: " . htmlspecialchars($action) . "<br>";
    echo "<a href='/'>Вернуться на главную</a>";

} catch (Exception $e) {
    http_response_code(500);
    echo "❌ Ошибка: " . htmlspecialchars($e->getMessage());

    error_log("Send.php error: " . $e->getMessage());
}