<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №4</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="header">
    <div class="logo">
        <img src="https://cdn1-media.rabota.ru/processor/logo/original/2018/04/20/fakultetmashinostroenijafgbouvomoskovskijjpolitekhnicheskijjuniversitet.png"  
             alt="Логотип Московского Политеха" 
             class="uni-logo">
    </div>
    <div class="student-info">
        <p>Куприянова Юлия Андреевна</p>
        <p>Группа 241-353</p>
        <p>Лабораторная работа №4</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Лабораторная работа №4</h1>
    <h2>Пользовательские функции. Вывод таблиц.</h2>
    
    <?php
    // ========== ФУНКЦИИ ДЛЯ ЛАБОРАТОРНОЙ РАБОТЫ №4 ==========
    
    /**
     * Функция формирования HTML-кода отдельной строки таблицы
     * @param string $row_data Строка вида "ячейка1*ячейка2*ячейка3"
     * @param int $cols_count Требуемое количество колонок в таблице
     * @return string HTML-код строки таблицы
     */
    function getTR($row_data, $cols_count) {
        // Разбиваем строку на ячейки по разделителю "*"
        $cells = explode('*', $row_data);
        
        // Начинаем формировать строку таблицы
        $ret = '<tr>';
        
        // Выводим все ячейки, которые есть в строке
        for ($i = 0; $i < count($cells); $i++) {
            $ret .= '<td>' . htmlspecialchars($cells[$i]) . '</td>';
        }
        
        // Если ячеек меньше, чем требуемое количество колонок - добавляем пустые ячейки
        for ($i = count($cells); $i < $cols_count; $i++) {
            $ret .= '<td>&nbsp;</td>';
        }
        
        $ret .= '</tr>';
        return $ret;
    }
    
    /**
     * Функция вывода HTML-кода таблицы
     * @param string $structure Структура таблицы вида "C1*C2*C3#C4*C5*C6#..."
     * @param int $table_num Номер таблицы
     * @param int $cols_count Требуемое количество колонок
     */
    function outTable($structure, $table_num, $cols_count) {
        // Проверка на нулевое количество колонок
        if ($cols_count <= 0) {
            echo '<p style="color: red;">Неправильное число колонок</p>';
            return;
        }
        
        // Разбиваем структуру на строки по разделителю "#"
        $rows = explode('#', $structure);
        
        // Проверка: есть ли строки?
        if (count($rows) == 0 || (count($rows) == 1 && $rows[0] == '')) {
            echo '<p>В таблице нет строк</p>';
            return;
        }
        
        // Формируем HTML-код всех строк таблицы
        $rows_html = '';
        $has_cells = false;
        
        foreach ($rows as $row) {
            // Пропускаем пустые строки
            if ($row == '') {
                continue;
            }
            
            // Проверяем, есть ли в строке ячейки
            $cells = explode('*', $row);
            if (count($cells) > 0 && $cells[0] != '') {
                $has_cells = true;
                $rows_html .= getTR($row, $cols_count);
            }
        }
        
        // Проверка: есть ли строки с ячейками?
        if (!$has_cells) {
            echo '<p>В таблице нет строк с ячейками</p>';
            return;
        }
        
        // Выводим заголовок таблицы
        echo '<h2>Таблица №' . $table_num . '</h2>';
        
        // Выводим саму таблицу
        echo '<table class="result-table">';
        echo $rows_html;
        echo '</table>';
    }
    
    // ========== ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННЫХ ==========
    
    // Количество колонок в таблицах
    $cols_count = 3;
    
    // Массив со структурами таблиц (не менее 10 элементов)
    $structures = array(
        'Иванов*Иван*Иванович#Петров*Петр*Петрович#Сидоров*Сидор*Сидорович',
        'Красный*Синий*Зеленый#Желтый*Оранжевый*Фиолетовый#Белый*Черный*Серый',
        'Яблоко*Груша*Банан#Апельсин*Мандарин*Лимон#Киви*Ананас*Манго',
        'Москва*Санкт-Петербург*Новосибирск#Казань*Екатеринбург*Нижний Новгород#Красноярск*Пермь*Волгоград',
        'PHP*JavaScript*Python#Java*C++*C#Ruby*Go*Swift',
        'Понедельник*Вторник*Среда#Четверг*Пятница*Суббота#Воскресенье',
        'Зима*Весна*Лето#Осень',
        'Книга*Тетрадь*Ручка#Карандаш*Ластик*Линейка#Циркуль*Транспортир*Калькулятор',
        'Фильмы*Сериалы*Мультфильмы#Комедии*Драмы*Триллеры#Фантастика*Ужасы*Мелодрамы',
        'Стол*Стул*Шкаф#Диван*Кресло*Тумба#Кровать*Комод*Полка',
        'Собака*Кошка*Мышь#Птица*Рыба*Хомяк#Кролик*Черепаха*Попугай',
        'Утро*День*Вечер#Ночь',
    );
    
    // ========== ВЫВОД ТАБЛИЦ ==========
    
    echo '<div class="tables-container">';
    
    // Выводим все таблицы из массива
    for ($i = 0; $i < count($structures); $i++) {
        outTable($structures[$i], $i + 1, $cols_count);
        echo '<br>';
    }
    
    // Демонстрация обработки ошибок (для проверки)
    echo '<hr>';
    echo '<h3>Проверка обработки ошибок:</h3>';
    
    // Тест 1: нулевое количество колонок
    echo '<h4>Тест: неправильное число колонок (cols_count = 0)</h4>';
    outTable('A*B*C#D*E*F', 99, 0);
    
    // Тест 2: пустая структура (нет строк)
    echo '<h4>Тест: пустая структура (нет строк)</h4>';
    outTable('', 100, 3);
    
    // Тест 3: структура с пустыми строками
    echo '<h4>Тест: структура с пустыми строками</h4>';
    outTable('#A*B*C##D*E*F#', 101, 3);
    
    echo '</div>';
    ?>
    
    <!-- Дополнительная информация о работе функций -->
    <div class="info-block">
        <h3>Информация о выполнении:</h3>
        <p> Количество колонок: <strong><?php echo $cols_count; ?></strong></p>
        <p> Количество таблиц: <strong><?php echo count($structures); ?></strong></p>
        <p> Используемые функции: <code>getTR()</code> (формирование строки таблицы), <code>outTable()</code> (вывод таблицы)</p>
        <p> Формат данных: <code>ячейка1*ячейка2*ячейка3#ячейка4*ячейка5*ячейка6</code></p>
    </div>
    
</main>

<footer class="footer">
    Лабораторная работа №4 | Выведено таблиц: <?php echo count($structures); ?> | Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>