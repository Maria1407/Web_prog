<?php
require 'vendor/autoload.php';

use App\ElasticExample;

header('Content-Type: text/html; charset=utf-8');
echo "<h1>Лабораторная №6: Вариант 16 (Соцсеть)</h1>";
echo "<h2>Демонстрация работы Elasticsearch</h2>";
echo "<hr>";

try {
    $elastic = new ElasticExample();
    $indexName = 'social_posts';

    // 1. Создание индекса
    echo "<h3>📂 1. Создание индекса</h3>";
    try {
        $elastic->createIndex($indexName);
        echo "✅ Индекс <b>{$indexName}</b> создан.<br>";
    } catch (Exception $e) {
        echo "ℹ️ Индекс уже существует.<br>";
    }

    // 2. Добавление постов
    echo "<h3>📝 2. Публикация постов</h3>";
    $posts = [
        ['id' => 1, 'author' => 'ivan', 'title' => 'Привет мир', 'content' => 'Это мой первый пост в соцсети.', 'tags' => ['start']],
        ['id' => 2, 'author' => 'anna', 'title' => 'Прогулка', 'content' => 'Гуляла в парке, видела белку.', 'tags' => ['park', 'nature']],
        ['id' => 3, 'author' => 'dev', 'title' => 'Elasticsearch', 'content' => 'Поиск работает быстро благодаря Elasticsearch.', 'tags' => ['tech']],
    ];

    foreach ($posts as $post) {
        $elastic->indexDocument($indexName, $post['id'], $post);
        echo "✅ Пост добавлен: <b>{$post['title']}</b><br>";
    }

    // 3. Поиск
    echo "<h3>🔍 3. Поиск по постам</h3>";
    $query = 'Elasticsearch';
    echo "Поиск по слову: <b>$query</b><br>";

    $result = json_decode($elastic->search($indexName, ['content' => $query]), true);

    if (!empty($result['hits']['hits'])) {
        echo "<ul>";
        foreach ($result['hits']['hits'] as $hit) {
            $doc = $hit['_source'];
            echo "<li><b>{$doc['title']}</b> ({$doc['author']}): {$doc['content']}</li>";
        }
        echo "</ul>";
    } else {
        echo "Ничего не найдено.";
    }

} catch (Exception $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ ОШИБКА: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>