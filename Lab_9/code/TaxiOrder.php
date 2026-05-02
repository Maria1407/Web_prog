<?php

class TaxiOrder
{
    private string $name;
    private int $passengers;
    private string $tariff;
    private bool $baggage;
    private string $carType;

    public function __construct(
        string $name,
        int $passengers,
        string $tariff,
        bool $baggage = false,
        string $carType = 'sedan'
    ) {
        $this->name = $name;
        $this->passengers = $passengers;
        $this->tariff = $tariff;
        $this->baggage = $baggage;
        $this->carType = $carType;
    }

    public function calculatePrice(): float
    {
        $basePrice = [
            'economy' => 100,
            'comfort' => 200,
            'business' => 500,
        ][$this->tariff] ?? 100;

        $passengerCoefficient = $this->passengers > 4 ? 1.5 : 1.0;
        $baggagePrice = $this->baggage ? 50 : 0;

        $carTypePrice = [
            'sedan' => 0,
            'suv' => 100,
            'minivan' => 150,
        ][$this->carType] ?? 0;

        return ($basePrice * $passengerCoefficient) + $baggagePrice + $carTypePrice;
    }

    public function validate(): bool
    {
        if (empty($this->name)) {
            return false;
        }
        if ($this->passengers < 1 || $this->passengers > 8) {
            return false;
        }
        if (!in_array($this->tariff, ['economy', 'comfort', 'business'])) {
            return false;
        }
        if (!in_array($this->carType, ['sedan', 'suv', 'minivan'])) {
            return false;
        }
        return true;
    }

    public function getOrderInfo(): array
    {
        return [
            'name' => $this->name,
            'passengers' => $this->passengers,
            'tariff' => $this->tariff,
            'baggage' => $this->baggage,
            'carType' => $this->carType,
            'price' => $this->calculatePrice(),
        ];
    }
}