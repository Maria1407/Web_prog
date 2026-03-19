<?php

require 'vendor/autoload.php';

use App\RedisExample;
use App\ElasticExample;
use App\ClickhouseExample;

// Redis
$redis = new RedisExample();
$redis->setValue('fraemwork', 'predis');
echo $redis->getValue('fraemwork');


// Elasticsearch
$elastic = new ElasticExample();
echo $elastic->indexDocument('books', 1, ['title' => '1984', 'author' => 'Orwell']);
echo $elastic->search('books', ['author' => 'Orwell']);

// ClickHouse
$click = new ClickhouseExample();
echo $click->query('SELECT count() FROM system.tables');
$click->query("CREATE TABLE IF NOT EXISTS  users (
   id UInt32,
   name String,
   age UInt8
) ENGINE = MergeTree()
ORDER BY id;");
echo $click->query("INSERT INTO users (id, name, age) VALUES (1, 'Ivan', 25), (2, 'Maria', 30);");
var_dump($click->query("SELECT * from users;"));