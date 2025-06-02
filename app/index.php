<?php
$DB_USER = getenv('POSTGRES_USER');
$DB_PASSW = getenv('POSTGRES_PASSWORD');
$DB_NAME = getenv('POSTGRES_DB');
$PORT = getenv('POSTGRES_PORT');
$HOST = getenv('POSTGRES_HOST');

$dsn = "pgsql:host={$HOST};port={$PORT};dbname={$DB_NAME};";
$user = $DB_USER;
$password = $DB_PASSW;

try {
    $pdo = new PDO($dsn, $user, $password);
    echo "✅ Успешное подключение к PostgreSQL<br>";

    // Пробуем создать таблицу
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100)
    )");

    // Вставим данные
    $pdo->exec("INSERT INTO users (name) VALUES ('Ruslan')");

    // Выведем данные
    $stmt = $pdo->query("SELECT * FROM users");
    while ($row = $stmt->fetch()) {
        echo "👤 Пользователь: " . $row['name'] . "<br>";
    }

} catch (PDOException $e) {
    echo "❌ Ошибка подключения: " . $e->getMessage();
}