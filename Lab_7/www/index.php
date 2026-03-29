<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №7 - RabbitMQ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .content {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .info {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .info h3 {
            margin-bottom: 15px;
            color: #667eea;
        }

        .info code {
            background: #333;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }

        .status {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            display: none;
        }

        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }

        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🐇 Лабораторная работа №7</h1>
            <p>Асинхронная обработка данных через RabbitMQ</p>
        </div>

        <div class="content">
            <form id="messageForm" method="POST" action="send.php">
                <div class="form-group">
                    <label for="name">👤 Имя студента:</label>
                    <input type="text" id="name" name="name" required placeholder="Введите имя">
                </div>

                <div class="form-group">
                    <label for="email">📧 Email:</label>
                    <input type="email" id="email" name="email" placeholder="student@example.com">
                </div>

                <div class="form-group">
                    <label for="action">📋 Тип операции:</label>
                    <select id="action" name="action">
                        <option value="register">Регистрация</option>
                        <option value="update">Обновление данных</option>
                        <option value="delete">Удаление</option>
                    </select>
                </div>

                <button type="submit">🚀 Отправить в очередь</button>
            </form>

            <div class="info">
                <h3>📚 Информация</h3>
                <p><strong>RabbitMQ Management:</strong> <a href="http://localhost:15672" target="_blank">http://localhost:15672</a> (guest/guest)</p>
                <p><strong>Запуск worker:</strong> <code>docker exec -it lab7_php php worker.php</code></p>
                <p><strong>Просмотр логов:</strong> <code>docker exec -it lab7_php tail -f processed_rabbit.log</code></p>
                <p><strong>Очередь:</strong> lab7_queue</p>
            </div>
        </div>

        <div class="footer">
            <p>© 2024 - Асинхронная обработка данных с RabbitMQ</p>
        </div>
    </div>

    <div id="status" class="status"></div>

    <script>
        document.getElementById('messageForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const statusDiv = document.getElementById('status');

            try {
                const response = await fetch('send.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();

                if (response.ok && text.includes('✅')) {
                    statusDiv.className = 'status success';
                    statusDiv.innerHTML = '✅ ' + text;
                    document.getElementById('messageForm').reset();
                } else {
                    statusDiv.className = 'status error';
                    statusDiv.innerHTML = '❌ Ошибка: ' + text;
                }

                setTimeout(() => {
                    statusDiv.style.display = 'none';
                    setTimeout(() => {
                        statusDiv.className = 'status';
                        statusDiv.style.display = '';
                    }, 100);
                }, 5000);

            } catch (error) {
                statusDiv.className = 'status error';
                statusDiv.innerHTML = '❌ Ошибка отправки: ' + error.message;
            }
        });
    </script>
</body>
</html>