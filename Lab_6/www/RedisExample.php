<?php
namespace App;

use Predis\Client;

class RedisExample
{
    private Client $client;

    public function __construct()
    {
        // Подключение к сервису redis внутри Docker сети
        $this->client = new Client('tcp://redis:6379');
    }

    public function setValue(string $key, string $value): void
    {
        $this->client->set($key, $value);
    }

    public function getValue(string $key): ?string
    {
        return $this->client->get($key);
    }

    // НОВЫЙ МЕТОД: Возвращает объект клиента для выполнения сложных команд
    public function getClient(): Client
    {
        return $this->client;
    }
}