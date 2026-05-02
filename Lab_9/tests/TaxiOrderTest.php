<?php

use PHPUnit\Framework\TestCase;

class TaxiOrderTest extends TestCase
{
    public function testCalculateEconomyPrice()
{
    $order = new TaxiOrder('Иван', 2, 'economy');
    $this->assertEquals(999.0, $order->calculatePrice());
}

    public function testCalculateComfortPrice()
    {
        $order = new TaxiOrder('Петр', 1, 'comfort');
        $this->assertEquals(200.0, $order->calculatePrice());
    }

    public function testCalculateBusinessPrice()
    {
        $order = new TaxiOrder('Мария', 1, 'business');
        $this->assertEquals(500.0, $order->calculatePrice());
    }

    public function testCalculateWithBaggage()
    {
        $order = new TaxiOrder('Анна', 1, 'economy', true);
        $this->assertEquals(150.0, $order->calculatePrice());
    }

    public function testCalculateWithSUV()
    {
        $order = new TaxiOrder('Олег', 1, 'economy', false, 'suv');
        $this->assertEquals(200.0, $order->calculatePrice());
    }

    public function testCalculateWithManyPassengers()
    {
        $order = new TaxiOrder('Группа', 5, 'economy');
        $this->assertEquals(150.0, $order->calculatePrice()); // 100 * 1.5
    }

    public function testValidation()
    {
        $order = new TaxiOrder('Тест', 3, 'comfort', true, 'minivan');
        $this->assertTrue($order->validate());
    }

    public function testValidationEmptyName()
    {
        $order = new TaxiOrder('', 1, 'economy');
        $this->assertFalse($order->validate());
    }

    public function testGetOrderInfo()
    {
        $order = new TaxiOrder('Иван', 2, 'comfort', true, 'suv');
        $info = $order->getOrderInfo();

        $this->assertEquals('Иван', $info['name']);
        $this->assertEquals(2, $info['passengers']);
        $this->assertEquals('comfort', $info['tariff']);
        $this->assertTrue($info['baggage']);
        $this->assertEquals('suv', $info['carType']);
        $this->assertEquals(350.0, $info['price']); // 200 + 50 + 100
    }
}