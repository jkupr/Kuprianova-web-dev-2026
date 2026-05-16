<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №2</title>
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
        <p>Лабораторная работа №2</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
        <a href="recipes.php">Рецепты</a>
        <a href="gallery.php">Галерея</a>
    </div>
</header>

<main class="container">
    <h1>Добро пожаловать в мир вкусной еды</h1>
    
    <p>Кулинария - это искусство приготовления вкусной и полезной пищи. Каждое блюдо может стать маленьким шедевром, если подойти к процессу с душой. На этом сайте вы найдете вдохновение, рецепты и красивые фотографии блюд со всего мира. Правильное питание не означает отказ от вкусной еды - это баланс и разнообразие.</p>
    
    <p>Средиземноморская кухня славится оливковым маслом, свежими овощами и морепродуктами. Азиатская кухня удивляет балансом кислого, сладкого, острого и соленого. Европейская классика - это сытные и ароматные блюда из мяса и сыров. Каждая культура привносит что-то уникальное в мировую гастрономию.</p>
    
    <h2>Популярные кухни мира</h2>
    <p>Итальянская кухня подарила миру пиццу, пасту и ризотто. Японская кухня известна суши и роллами. Мексиканская кухня радует яркими вкусами тако и буррито. Грузинская кухня - это ароматные хинкали и хачапури. Изучение кухонь разных стран расширяет кулинарный кругозор.</p>
    
    <h2>Табулирование функции (Вариант №2)</h2>
    <p>Вычисление функции f(x):</p>
    
    <?php
    // ========== 1. ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННЫХ ==========
    $start_value = -10;      // начальное значение аргумента
    $count = 10000;          // количество вычисляемых значений
    $step = 0.5;             // шаг изменения аргумента
    $min_value = -100;       // минимальное значение функции (остановка)
    $max_value = 100;        // максимальное значение функции (остановка)
    $layout_type = 'A';      // тип вёрстки: 'A', 'B', 'C', 'D', 'E'
    
    // Текущий аргумент
    $x = $start_value;
    
    // Массив для хранения результатов
    $results = array();
    
    // ========== 2. ФУНКЦИЯ ДЛЯ ВЫЧИСЛЕНИЯ ПО ВАРИАНТУ №2 ==========
    // Вариант №2:
    // f(x) = (10 + x)/x,           при x ≤ 10
    // f(x) = (x/7) * (x - 2),      при x > 10 и x < 20
    // f(x) = x * 8 + 2,            при x ≥ 20а
    
    function calculateFunction($x) {
        if ($x <= 10) {
            // первая ветка: (10 + x)/x
            if ($x == 0) {
                return 'error'; // деление на ноль при x=0
            }
            return (10 + $x) / $x;
        } 
        elseif ($x > 10 && $x < 20) {
            // вторая ветка: (x/7) * (x - 2)
            return ($x / 7) * ($x - 2);
        } 
        else { // x >= 20
            // третья ветка: x * 8 + 2
            return $x * 8 + 2;
        }
    }
    
    // ========== 3. ВЫЧИСЛЕНИЕ ЗНАЧЕНИЙ ==========
    for ($i = 0; $i < $count; $i++, $x += $step) {
        $f_value = calculateFunction($x);
        
        // Сохраняем результат
        $results[] = array('x' => $x, 'f' => $f_value);
        
        // Проверка на остановку по min/max (только для числовых значений)
        if (is_numeric($f_value)) {
            if ($f_value >= $max_value || $f_value <= $min_value) {
                break; // досрочный выход из цикла
            }
        }
    }
    
    // ========== 4. ВЫВОД РЕЗУЛЬТАТОВ В ЗАВИСИМОСТИ ОТ ТИПА ВЁРСТКИ ==========
    
    echo '<h3>Результаты вычислений (тип верстки ' . $layout_type . ')</h3>';
    
    switch ($layout_type) {
        case 'A': // Простая верстка текстом
            echo '<div>';
            foreach ($results as $item) {
                if (is_numeric($item['f'])) {
                    echo 'f(' . round($item['x'], 3) . ') = ' . round($item['f'], 3) . '<br>';
                } else {
                    echo 'f(' . round($item['x'], 3) . ') = ' . $item['f'] . '<br>';
                }
            }
            echo '</div>';
            break;
            
        case 'B': // Маркированный список
            echo '<ul class="result-list">';
            foreach ($results as $item) {
                echo '<li>';
                if (is_numeric($item['f'])) {
                    echo 'f(' . round($item['x'], 3) . ') = ' . round($item['f'], 3);
                } else {
                    echo 'f(' . round($item['x'], 3) . ') = ' . $item['f'];
                }
                echo '</li>';
            }
            echo '</ul>';
            break;
            
        case 'C': // Нумерованный список
            echo '<ol class="result-list">';
            foreach ($results as $item) {
                echo '<li>';
                if (is_numeric($item['f'])) {
                    echo 'f(' . round($item['x'], 3) . ') = ' . round($item['f'], 3);
                } else {
                    echo 'f(' . round($item['x'], 3) . ') = ' . $item['f'];
                }
                echo '</li>';
            }
            echo '</ol>';
            break;
            
        case 'D': // Табличная верстка
            echo '<table class="result-table">';
            echo '<tr><th>№</th><th>Аргумент x</th><th>Значение f(x)</th></tr>';
            $row_num = 1;
            foreach ($results as $item) {
                echo '<tr>';
                echo '<td>' . $row_num++ . '</td>';
                echo '<td>' . round($item['x'], 3) . '</td>';
                if (is_numeric($item['f'])) {
                    echo '<td>' . round($item['f'], 3) . '</td>';
                } else {
                    echo '<td>' . $item['f'] . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            break;
            
        case 'E': // Блочная верстка (горизонтально)
            echo '<div class="block-layout">';
            foreach ($results as $item) {
                echo '<div class="block-item">';
                if (is_numeric($item['f'])) {
                    echo 'f(' . round($item['x'], 3) . ')<br>= ' . round($item['f'], 3);
                } else {
                    echo 'f(' . round($item['x'], 3) . ')<br>= ' . $item['f'];
                }
                echo '</div>';
            }
            echo '</div>';
            break;
            
        default:
            echo '<p>Неизвестный тип вёрстки</p>';
            break;
    }
    
    // ========== 5. ВЫЧИСЛЕНИЕ И ВЫВОД СТАТИСТИКИ ==========
    // Собираем только числовые значения для статистики
    $numeric_values = array();
    foreach ($results as $item) {
        if (is_numeric($item['f'])) {
            $numeric_values[] = $item['f'];
        }
    }
    
    if (count($numeric_values) > 0) {
        $min_f = min($numeric_values);
        $max_f = max($numeric_values);
        $sum_f = array_sum($numeric_values);
        $avg_f = $sum_f / count($numeric_values);
        
        echo '<div class="stats">';
        echo '<h3>Статистика значений функции</h3>';
        echo '<p>📊 Минимальное значение: ' . round($min_f, 3) . '</p>';
        echo '<p>📈 Максимальное значение: ' . round($max_f, 3) . '</p>';
        echo '<p>➕ Сумма значений: ' . round($sum_f, 3) . '</p>';
        echo '<p>📐 Среднее арифметическое: ' . round($avg_f, 3) . '</p>';
        echo '</div>';
    } else {
        echo '<div class="stats">';
        echo '<p>⚠️ Нет числовых значений для расчёта статистики.</p>';
        echo '</div>';
    }
    
    // Вывод информации о количестве вычисленных значений
    echo '<p><small>Вычислено значений: ' . count($results) . ' (остановка при достижении min=' . $min_value . ' или max=' . $max_value . ')</small></p>';
    ?>
    
    <h2>Сравнение популярных блюд</h2>
    <table class="food-table">
        <tr>
            <th>Название блюда</th>
            <th>Кухня</th>
            <th>Сложность (1-5)</th>
        </tr>
        <tr>
            <td>Паста Карбонара</td>
            <td>Итальянская</td>
            <td>3</td>
        </tr>
        <tr>
            <td>Салат Цезарь</td>
            <td>Американская</td>
            <td>2</td>
        </tr>
     </table>
    
    <h2>Фотографии блюд</h2>
    <div class="gallery">
        <div class="gallery-item">
            <img src="fotos/foto1.jpg" alt="Вкусное блюдо">
            <p>Вкусное блюдо</p>
        </div>
        <div class="gallery-item">
            <img src="fotos/foto2.jpg" alt="Аппетитное блюдо">
            <p>Аппетитное блюдо</p>
        </div>
    </div>
    
    <p>Приготовление вкусной еды начинается с качественных продуктов. Свежие овощи, хорошее мясо и правильные специи - основа любого блюда. Не бойтесь экспериментировать и добавлять свои любимые ингредиенты. Кулинария - это творчество, которое доступно каждому.</p>
    <p>В нашем сайте вы найдете множество полезных советов и рецептов. Мы регулярно обновляем контент, добавляя новые интересные блюда. Следите за обновлениями и открывайте для себя мир вкусной и здоровой еды вместе с нами.</p>
</main>

<footer class="footer">
    Тип вёрстки: <?php echo $layout_type; ?> | Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>