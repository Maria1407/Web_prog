<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueManager {
    private $connection;
    private $channel;
    private $queueName = 'lab7_queue';

    public function __construct() {
        try {
            $this->connection = new AMQPStreamConnection(
                'rabbitmq',
                5672,
                'guest',
                'guest'
            );
            $this->channel = $this->connection->channel();

            $this->channel->queue_declare(
                $this->queueName,
                false,
                true,
                false,
                false
            );

            echo "[QueueManager] Подключение к RabbitMQ установлено\n";
        } catch (Exception $e) {
            echo "[QueueManager] Ошибка подключения: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    public function publish($data) {
        $messageBody = json_encode($data, JSON_UNESCAPED_UNICODE);
        $msg = new AMQPMessage($messageBody, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->channel->basic_publish($msg, '', $this->queueName);

        echo "[QueueManager] Сообщение отправлено: " . $messageBody . "\n";
        return true;
    }

    public function consume(callable $callback) {
        echo "[QueueManager] Начинаем прослушивание очереди '{$this->queueName}'...\n";

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(
            $this->queueName,
            '',
            false,
            false,
            false,
            false,
            function($msg) use ($callback) {
                try {
                    $data = json_decode($msg->body, true);
                    echo "[Consumer] Получено сообщение: " . $msg->body . "\n";

                    $callback($data);

                    $msg->ack();
                    echo "[Consumer] Сообщение подтверждено\n";
                } catch (Exception $e) {
                    echo "[Consumer] Ошибка обработки: " . $e->getMessage() . "\n";
                    $msg->nack(true);
                }
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }


    public function __destruct() {
        if ($this->channel) {
            $this->channel->close();
        }
        if ($this->connection) {
            $this->connection->close();
        }
        echo "[QueueManager] Соединение закрыто\n";
    }
}