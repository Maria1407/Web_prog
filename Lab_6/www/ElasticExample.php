<?php
namespace App;

use App\Helpers\ClientFactory;

class ElasticExample
{
    private $client;

    public function __construct()
    {
        // ВАЖНО: localhost заменен на elasticsearch (имя контейнера)
        $this->client = ClientFactory::make('http://elasticsearch:9200');
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