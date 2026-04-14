<?php

class TaxiOrder
{
    private $pdo;

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function createOrder(string $name, int $passengers, string $tariff, bool $hasBaggage, string $carType): string
    {
        if ($passengers < 1 || $passengers > 8) {
            throw new InvalidArgumentException("Количество пассажиров должно быть от 1 до 8");
        }

        $allowedTariffs = ['эконом', 'комфорт', 'бизнес'];
        if (!in_array($tariff, $allowedTariffs)) {
            throw new InvalidArgumentException("Недопустимый тариф.");
        }

        $allowedCarTypes = ['седан', 'минивэн', 'внедорожник'];
        if (!in_array($carType, $allowedCarTypes)) {
            throw new InvalidArgumentException("Недопустимый тип авто.");
        }

        $baggageText = $hasBaggage ? "с багажом" : "без багажа";
        return "Заказ создан: {$name}, {$passengers} пасс., {$tariff}, {$baggageText}, {$carType}";
    }

    public function getOrder(int $orderId): array
    {
        return [
            'id' => $orderId,
            'name' => 'Иван Иванов',
            'passengers' => 2,
            'tariff' => 'комфорт',
            'hasBaggage' => true,
            'carType' => 'седан'
        ];
    }
}
