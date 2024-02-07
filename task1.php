<?php

/**
 * Класс Init
 */
final class Init
{
    /** @var PDO */
    private $pdo;

    /**
     * Метод-конструктор.
     * Инициализирует объект для работы с базой данных и выполняет методы create() и fill().
     */
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=my_database', 'root', '');
        $this->create();
        $this->fill();
    }

    /** Создает таблицу test. */
    private function create(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS test (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                age INT NOT NULL,
                result ENUM('normal', 'success') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    /** Заполняет таблицу test случайными данными. */
    private function fill(): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO test (name, age, result) VALUES (:name, :age, :result)");
        for ($i = 0; $i < 10; $i++) {
            $name = "Пользователь " . ($i + 1);
            $age = mt_rand(18, 60);
            $result = mt_rand(0, 1) ? 'normal' : 'success';
            $stmt->execute([':name' => $name, ':age' => $age, ':result' => $result]);
        }
    }

    /**
     * Получает данные из таблицы test на основе критерия result.
     * Метод доступен извне класса.
     * @return array Данные, удовлетворяющие критерию.
     */
    public function get(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM test WHERE result IN ('normal', 'success')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$init = new Init();
print_r($init->get());