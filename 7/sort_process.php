<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №7 - Результат</title>
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
        <p>Лабораторная работа №7</p>
    </div>
    <div class="nav-menu">
        <a href="index.php">Главная</a>
    </div>
</header>

<main class="container">
    <?php
    
    // Проверка наличия данных
    if (!isset($_POST['element_0']) || !isset($_POST['arrLength'])) {
        echo '<p>Массив не задан, сортировка невозможна</p>';
        echo '<a href="index.php">Вернуться к форме</a>';
        exit();
    }
    
    $length = intval($_POST['arrLength']);
    $input_array = array();
    $error = false;
    
    // Проверка всех элементов на числа
    for ($i = 0; $i < $length; $i++) {
        $val = trim($_POST['element_' . $i] ?? '');
        if ($val === '') {
            echo '<p>Элемент ' . $i . ' пуст</p>';
            $error = true;
            break;
        }
        if (!is_numeric(str_replace(',', '.', $val))) {
            echo '<p>Элемент ' . $i . ' ("' . htmlspecialchars($val) . '") - не число</p>';
            $error = true;
            break;
        }
        $input_array[] = floatval(str_replace(',', '.', $val));
    }
    
    if ($error) {
        echo '<a href="index.php">Вернуться к форме</a>';
        exit();
    }
    
    // Название алгоритма
    $algorithm_names = array(
        'choice' => 'Сортировка выбором',
        'bubble' => 'Пузырьковый алгоритм',
        'shell' => 'Алгоритм Шелла',
        'gnome' => 'Алгоритм садового гнома',
        'quick' => 'Быстрая сортировка',
        'php_sort' => 'Встроенная функция PHP'
    );
    
    $algorithm = $_POST['algorithm'] ?? 'choice';
    
    echo '<h2>' . $algorithm_names[$algorithm] . '</h2>';
    echo '<h3>Входные данные</h3>';
    echo '<p>[ ' . implode(', ', $input_array) . ' ]</p>';
    echo '<p>Массив проверен, сортировка возможна</p>';
    
    // Функции сортировки с выводом итераций
    
    $iteration_count = 0;
    
    function print_array($arr, $iteration, $message = '') {
        echo '<p><strong>Итерация ' . $iteration . '</strong><br>';
        echo 'Текущее состояние: [ ' . implode(', ', $arr) . ' ]<br>';
        if ($message) echo $message;
        echo '</p>';
    }
    
    // 1. Сортировка выбором
    function selectionSort($arr) {
        global $iteration_count;
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            $min_idx = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($arr[$j] < $arr[$min_idx]) {
                    $min_idx = $j;
                }
                $iteration_count++;
                print_array($arr, $iteration_count, 'Поиск минимального элемента...');
            }
            if ($min_idx != $i) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$min_idx];
                $arr[$min_idx] = $temp;
                $iteration_count++;
                print_array($arr, $iteration_count, 'Обмен элементов ' . $i . ' и ' . $min_idx);
            }
        }
        return $arr;
    }
    
    // 2. Пузырьковая сортировка
    function bubbleSort($arr) {
        global $iteration_count;
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
                $iteration_count++;
                print_array($arr, $iteration_count, 'Сравнение элементов ' . $j . ' и ' . ($j+1));
            }
        }
        return $arr;
    }
    
    // 3. Сортировка Шелла
    function shellSort($arr) {
        global $iteration_count;
        $n = count($arr);
        $gap = floor($n / 2);
        while ($gap > 0) {
            for ($i = $gap; $i < $n; $i++) {
                $temp = $arr[$i];
                $j = $i;
                while ($j >= $gap && $arr[$j - $gap] > $temp) {
                    $arr[$j] = $arr[$j - $gap];
                    $j -= $gap;
                }
                $arr[$j] = $temp;
                $iteration_count++;
                print_array($arr, $iteration_count, 'Шаг = ' . $gap);
            }
            $gap = floor($gap / 2);
        }
        return $arr;
    }
    
    // 4. Сортировка гнома
    function gnomeSort($arr) {
        global $iteration_count;
        $i = 1;
        $n = count($arr);
        while ($i < $n) {
            if ($i == 0 || $arr[$i - 1] <= $arr[$i]) {
                $i++;
            } else {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i - 1];
                $arr[$i - 1] = $temp;
                $i--;
            }
            $iteration_count++;
            print_array($arr, $iteration_count, '');
        }
        return $arr;
    }
    
    // 5. Быстрая сортировка
    function quickSort($arr) {
        global $iteration_count;
        if (count($arr) <= 1) return $arr;
        
        $pivot = $arr[floor(count($arr) / 2)];
        $left = array();
        $right = array();
        $equal = array();
        
        foreach ($arr as $value) {
            if ($value < $pivot) $left[] = $value;
            elseif ($value > $pivot) $right[] = $value;
            else $equal[] = $value;
        }
        
        $iteration_count++;
        print_array($arr, $iteration_count, 'Опорный элемент: ' . $pivot);
        
        $left = quickSort($left);
        $right = quickSort($right);
        
        return array_merge($left, $equal, $right);
    }
    
    // 6. Встроенная функция PHP
    function phpSort($arr) {
        sort($arr);
        return $arr;
    }
    
    // Выполнение сортировки
    $sorted_array = array();
    $start_time = microtime(true);
    
    switch ($algorithm) {
        case 'choice':
            $sorted_array = selectionSort($input_array);
            break;
        case 'bubble':
            $sorted_array = bubbleSort($input_array);
            break;
        case 'shell':
            $sorted_array = shellSort($input_array);
            break;
        case 'gnome':
            $sorted_array = gnomeSort($input_array);
            break;
        case 'quick':
            $sorted_array = quickSort($input_array);
            break;
        case 'php_sort':
            $sorted_array = $input_array;
            sort($sorted_array);
            echo '<p>Встроенная функция sort() - вывод итераций не предусмотрен</p>';
            break;
    }
    
    $end_time = microtime(true);
    $time_spent = $end_time - $start_time;
    
    // Результат
    echo '<h3>Результат сортировки</h3>';
    echo '<p>Отсортированный массив: [ ' . implode(', ', $sorted_array) . ' ]</p>';
    echo '<p>Сортировка завершена, проведено ' . $iteration_count . ' итераций. Сортировка заняла ' . number_format($time_spent, 6) . ' секунд</p>';
    
    ?>
    
    <a href="index.php">Повторить тест</a>
    
</main>

<footer class="footer">
    Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>