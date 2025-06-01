<?php
require_once realpath("./vendor/autoload.php");
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$DB_USER = $_ENV['POSTGRES_USER'];
$DB_PASSW = $_ENV['POSTGRES_PASSWORD'];
$DB_NAME = $_ENV['POSTGRES_DB'];

$dsn = "pgsql:host=db;port=5432;dbname={$DB_NAME};";
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