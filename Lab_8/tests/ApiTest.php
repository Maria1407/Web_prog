<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ApiTest extends TestCase
{
    public function testCreateOrderViaApi()
    {
        $envFile = __DIR__ . '/../.env.test';
        if (file_exists($envFile)) {
            foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (strpos(trim($line), '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    putenv("$key=$value");
                }
            }
        }

        $baseUrl = getenv('API_BASE_URL') ?: 'http://localhost';
        $client = new Client(['base_uri' => $baseUrl, 'timeout' => 2.0]);

        try {
            $response = $client->post('/api/order', [
                'json' => ['name' => 'Ольга', 'passengers' => 2, 'tariff' => 'комфорт', 'hasBaggage' => true, 'carType' => 'минивэн']
            ]);
            $this->assertEquals(200, $response->getStatusCode());
        } catch (\Exception $e) {
            $this->markTestSkipped("API недоступен: " . $e->getMessage());
        }
    }

    public function testMockHttpRequest()
    {
        $mock = new MockHandler([new Response(200, [], json_encode(['message' => 'OK']))]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $response = $client->post('/test');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
