<?php
namespace App;
use App\Helpers\ClientFactory;

class ElasticExample
{
    private $client;

    public function __construct()
    {
        // Имя сервиса в docker-compose.yml
        $this->client = ClientFactory::make('http://elasticsearch:9200');
    }

    public function createIndex(string $index): void
    {
        try {
            $this->client->put($index);
        } catch (\Exception $e) {
        }
    }

    public function indexDocument(string $index, int $id, array $data): string
    {
        $response = $this->client->put("$index/_doc/$id", [
            'json' => $data
        ]);
        return $response->getBody()->getContents();
    }

    public function search(string $index, array $query): string
    {
        $response = $this->client->get("$index/_search", [
            'json' => ['query' => ['match' => $query]]
        ]);
        return $response->getBody()->getContents();
    }
}