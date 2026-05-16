<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №5</title>
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
        <p>Лабораторная работа №5</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Лабораторная работа №5</h1>
    <h2>Таблица умножения</h2>
    
    <?php
    // ========== ОСНОВНОЙ PHP-КОД ДЛЯ ЛР5 ==========
    
    // Функция преобразования числа в ссылку (если число от 2 до 9 или результат ≤9)
    function outNumAsLink($x, $current_content, $current_html_type) {
        // Если число от 2 до 9, делаем ссылку на таблицу умножения на это число
        // ИЛИ если число ≤ 9 (результат умножения), тоже делаем ссылку
        if ($x >= 2 && $x <= 9) {
            // Сохраняем текущий тип верстки, но сбрасываем content
            $html_param = '';
            if ($current_html_type == 'DIV') {
                $html_param = '&html_type=DIV';
            }
            return '<a href="?content=' . $x . $html_param . '" class="num-link">' . $x . '</a>';
        } else {
            // Числа 0, 1, 10 и больше не делаем ссылками
            return $x;
        }
    }
    
    // Функция вывода столбца таблицы умножения
    function outRow($n, $current_content, $current_html_type) {
        for ($i = 2; $i <= 9; $i++) {
            $result = $n * $i;
            echo '<div class="multiply-row">';
            echo outNumAsLink($n, $current_content, $current_html_type);
            echo ' × ';
            echo outNumAsLink($i, $current_content, $current_html_type);
            echo ' = ';
            echo outNumAsLink($result, $current_content, $current_html_type);
            echo '</div>';
        }
    }
    
    // ========== ОПРЕДЕЛЯЕМ ТЕКУЩИЕ ПАРАМЕТРЫ ==========
    // Параметр html_type: TABLE (табличная верстка) или DIV (блочная верстка)
    // По умолчанию (при первой загрузке) - TABLE
    $current_html_type = 'TABLE';
    if (isset($_GET['html_type']) && ($_GET['html_type'] == 'TABLE' || $_GET['html_type'] == 'DIV')) {
        $current_html_type = $_GET['html_type'];
    }
    
    // Параметр content: число от 2 до 9 (какую таблицу показывать)
    // По умолчанию (при первой загрузке) - не задан (показываем всю таблицу)
    $current_content = null;
    if (isset($_GET['content']) && is_numeric($_GET['content']) && $_GET['content'] >= 2 && $_GET['content'] <= 9) {
        $current_content = $_GET['content'];
    }
    ?>
    
    <!-- ========== 1. ГЛАВНОЕ МЕНЮ (в шапке страницы, горизонтальное) ========== -->
    <div class="main-menu">
        <?php
        // Пункт "Табличная верстка"
        $table_link = '?html_type=TABLE';
        if ($current_content !== null) {
            $table_link .= '&content=' . $current_content;
        }
        echo '<a href="' . $table_link . '"';
        if ($current_html_type == 'TABLE') {
            echo ' class="selected"';
        }
        echo '>Табличная верстка</a>';
        
        // Пункт "Блочная верстка"
        $div_link = '?html_type=DIV';
        if ($current_content !== null) {
            $div_link .= '&content=' . $current_content;
        }
        echo '<a href="' . $div_link . '"';
        if ($current_html_type == 'DIV') {
            echo ' class="selected"';
        }
        echo '>Блочная верстка</a>';
        ?>
    </div>
    
    <!-- ========== 2. ОСНОВНОЕ МЕНЮ (левая часть, вертикальное) ========== -->
    <div class="side-menu">
        <?php
        // Пункт "Всё" (вся таблица умножения)
        $all_link = '?';
        if ($current_html_type == 'TABLE') {
            $all_link .= 'html_type=TABLE';
        } elseif ($current_html_type == 'DIV') {
            $all_link .= 'html_type=DIV';
        }
        echo '<a href="' . $all_link . '"';
        if ($current_content === null) {
            echo ' class="selected"';
        }
        echo '>Всё</a>';
        
        // Пункты от 2 до 9
        for ($i = 2; $i <= 9; $i++) {
            $link = '?content=' . $i;
            if ($current_html_type == 'TABLE') {
                $link .= '&html_type=TABLE';
            } elseif ($current_html_type == 'DIV') {
                $link .= '&html_type=DIV';
            }
            echo '<a href="' . $link . '"';
            if ($current_content == $i) {
                echo ' class="selected"';
            }
            echo '>' . $i . '</a>';
        }
        ?>
    </div>
    
    <!-- ========== 3. ТАБЛИЦА УМНОЖЕНИЯ (основная часть) ========== -->
    <div class="multiplication-content">
        <?php
        if ($current_html_type == 'TABLE') {
            // ТАБЛИЧНАЯ ВЁРСТКА
            if ($current_content === null) {
                // Вся таблица умножения (8 колонок)
                echo '<table class="multiply-table">';
                echo '<thead>';
                echo '<tr><th colspan="8">Таблица умножения</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                for ($row = 2; $row <= 9; $row++) {
                    echo '<tr>';
                    for ($col = 2; $col <= 9; $col++) {
                        $result = $col * $row;
                        echo '<td>';
                        echo outNumAsLink($col, $current_content, $current_html_type);
                        echo ' × ';
                        echo outNumAsLink($row, $current_content, $current_html_type);
                        echo ' = ';
                        echo outNumAsLink($result, $current_content, $current_html_type);
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                // Таблица умножения на одно число (один столбец)
                echo '<table class="multiply-single">';
                echo '<thead>';
                echo '<tr><th>Таблица умножения на ' . $current_content . '</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                for ($i = 2; $i <= 9; $i++) {
                    $result = $current_content * $i;
                    echo '<tr>';
                    echo '<td>';
                    echo outNumAsLink($current_content, $current_content, $current_html_type);
                    echo ' × ';
                    echo outNumAsLink($i, $current_content, $current_html_type);
                    echo ' = ';
                    echo outNumAsLink($result, $current_content, $current_html_type);
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            }
        } else {
            // БЛОЧНАЯ ВЁРСТКА (DIV)
            if ($current_content === null) {
                // Вся таблица умножения (горизонтальные блоки)
                echo '<div class="multiply-blocks">';
                for ($col = 2; $col <= 9; $col++) {
                    echo '<div class="block-column">';
                    echo '<div class="block-title">Таблица на ' . $col . '</div>';
                    for ($row = 2; $row <= 9; $row++) {
                        $result = $col * $row;
                        echo '<div class="block-row">';
                        echo outNumAsLink($col, $current_content, $current_html_type);
                        echo ' × ';
                        echo outNumAsLink($row, $current_content, $current_html_type);
                        echo ' = ';
                        echo outNumAsLink($result, $current_content, $current_html_type);
                        echo '</div>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            } else {
                // Таблица умножения на одно число (один блок)
                echo '<div class="multiply-single-block">';
                echo '<div class="block-title">Таблица умножения на ' . $current_content . '</div>';
                for ($i = 2; $i <= 9; $i++) {
                    $result = $current_content * $i;
                    echo '<div class="block-row">';
                    echo outNumAsLink($current_content, $current_content, $current_html_type);
                    echo ' × ';
                    echo outNumAsLink($i, $current_content, $current_html_type);
                    echo ' = ';
                    echo outNumAsLink($result, $current_content, $current_html_type);
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        ?>
    </div>
    
    <!-- ========== 4. ИНФОРМАЦИЯ В ПОДВАЛЕ ========== -->
    
</main>

<footer class="footer">
    <?php
    // Формируем информацию о странице
    $info = '';
    
    // Тип верстки
    if ($current_html_type == 'TABLE') {
        $info .= 'Табличная верстка';
    } else {
        $info .= 'Блочная верстка';
    }
    
    $info .= ' | ';
    
    // Название таблицы умножения
    if ($current_content === null) {
        $info .= 'Полная таблица умножения';
    } else {
        $info .= 'Таблица умножения на ' . $current_content;
    }
    
    $info .= ' | Сформировано ' . date('d.m.Y H:i:s');
    
    echo $info;
    ?>
</footer>

</body>
</html>