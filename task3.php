<?php

/**
 * Скрипт для поиска и вывода файлов с расширением ixt в папке /datafiles.
 *
 * Этот скрипт ищет файлы в указанной папке, имена которых состоят из цифр и букв латинского алфавита,
 * и имеют расширение ixt. Затем он выводит на экран имена этих файлов, упорядоченные по имени.
 */

// Путь к папке с файлами
$directory = 'datafiles';

// Получаем список файлов в указанной директории
$files = scandir($directory);

// Регулярное выражение для проверки имени файла
$pattern = '/^[a-zA-Z0-9]+\.(ixt)$/';

// Массив для хранения найденных файлов
$foundFiles = [];

// Проходим по каждому файлу
foreach ($files as $file) {
    // Проверяем, является ли файл обычным файлом и соответствует ли его имя регулярному выражению
    if (is_file($directory . '/' . $file) && preg_match($pattern, $file)) {
        // Добавляем файл в массив найденных файлов
        $foundFiles[] = $file;
    }
}

// Сортируем массив найденных файлов по имени
sort($foundFiles);

// Выводим имена найденных файлов
foreach ($foundFiles as $foundFile) {
    echo $foundFile . "\n";
}