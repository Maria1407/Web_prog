<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../www/TaxiOrder.php';

class TaxiOrderTest extends TestCase
{
    private $taxiOrder;

    protected function setUp(): void
    {
        $this->taxiOrder = new TaxiOrder();
    }

    public function testCreateOrderSuccess()
    {
        $result = $this->taxiOrder->createOrder("Анна", 3, "комфорт", true, "минивэн");
        $this->assertStringContainsString("Анна", $result);
        $this->assertStringContainsString("с багажом", $result);
    }

    public function testCreateOrderInvalidPassengers()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->taxiOrder->createOrder("Петр", 0, "эконом", false, "седан");
    }

    public function testCreateOrderWithMockPDO()
    {
        $pdoMock = $this->createMock(PDO::class);
        $taxiOrderWithDb = new TaxiOrder($pdoMock);
        $result = $taxiOrderWithDb->createOrder("Сергей", 1, "эконом", false, "седан");
        $this->assertStringContainsString("Сергей", $result);
    }

    public function testGetOrder()
    {
        $order = $this->taxiOrder->getOrder(123);
        $this->assertEquals(123, $order['id']);
        $this->assertTrue($order['hasBaggage']);
    }
}
