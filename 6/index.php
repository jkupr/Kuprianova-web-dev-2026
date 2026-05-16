<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №6</title>
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
        <p>Лабораторная работа №6</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Лабораторная работа №6</h1>
    <h2>Тестирование знаний</h2>
    
    <?php
    // ========== ОБРАБОТЧИК ФОРМЫ ==========
    
    // Функция для получения случайного числа (целого или дробного)
    function getRandomValue() {
        $is_decimal = mt_rand(0, 1);
        if ($is_decimal) {
            return mt_rand(0, 10000) / 100;
        } else {
            return mt_rand(0, 100);
        }
    }
    
    // Функция для вычисления результата в зависимости от задачи
    function calculateResult($task, $a, $b, $c) {
        switch ($task) {
            case 'triangle_area':
                // Площадь треугольника по формуле Герона
                $p = ($a + $b + $c) / 2;
                return round(sqrt($p * ($p - $a) * ($p - $b) * ($p - $c)), 2);
            case 'triangle_perimeter':
                return round($a + $b + $c, 2);
            case 'parallelepiped_volume':
                return round($a * $b * $c, 2);
            case 'arithmetic_mean':
                return round(($a + $b + $c) / 3, 2);
            case 'geometric_mean':
                return round(pow($a * $b * $c, 1/3), 2);
            case 'hypotenuse':
                return round(sqrt($a * $a + $b * $b), 2);
            default:
                return 0;
        }
    }
    
    // Функция для получения названия задачи
    function getTaskName($task) {
        $tasks = [
            'triangle_area' => 'Площадь треугольника (по формуле Герона)',
            'triangle_perimeter' => 'Периметр треугольника',
            'parallelepiped_volume' => 'Объем параллелепипеда',
            'arithmetic_mean' => 'Среднее арифметическое',
            'geometric_mean' => 'Среднее геометрическое',
            'hypotenuse' => 'Гипотенуза прямоугольного треугольника'
        ];
        return $tasks[$task] ?? 'Неизвестная задача';
    }
    
    // Определяем версию отображения
    $display_type = 'browser';
    if (isset($_POST['display_type'])) {
        $display_type = $_POST['display_type'];
    } elseif (isset($_GET['display_type'])) {
        $display_type = $_GET['display_type'];
    }
    
    // Добавляем класс для версии для печати
    if ($display_type == 'print') {
        echo '<div class="print-version">';
    }
    
    // Проверяем, была ли отправлена форма
    if (isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C'])) {
        
        $fio = trim($_POST['fio'] ?? '');
        $group = trim($_POST['group'] ?? '');
        $about = trim($_POST['about'] ?? '');
        $task = $_POST['task'] ?? '';
        $a = floatval(str_replace(',', '.', $_POST['A']));
        $b = floatval(str_replace(',', '.', $_POST['B']));
        $c = floatval(str_replace(',', '.', $_POST['C']));
        $user_answer = trim($_POST['user_answer'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $send_mail = isset($_POST['send_mail']);
        
        $correct_result = calculateResult($task, $a, $b, $c);
        $user_answer_num = ($user_answer !== '') ? floatval(str_replace(',', '.', $user_answer)) : null;
        $is_solved = ($user_answer !== '' && abs($user_answer_num - $correct_result) < 0.01);
        
        // Формируем отчет
        echo '<div class="result-box">';
        echo '<h3>Результаты тестирования</h3>';
        echo '<p><strong>ФИО:</strong> ' . htmlspecialchars($fio) . '</p>';
        echo '<p><strong>Группа:</strong> ' . htmlspecialchars($group) . '</p>';
        if (!empty($about)) {
            echo '<p><strong>О себе:</strong> ' . nl2br(htmlspecialchars($about)) . '</p>';
        }
        echo '<p><strong>Тип задачи:</strong> ' . getTaskName($task) . '</p>';
        echo '<p><strong>Входные данные:</strong> A = ' . $a . ', B = ' . $b . ', C = ' . $c . '</p>';
        echo '<p><strong>Правильный ответ:</strong> ' . $correct_result . '</p>';
        
        if ($user_answer === '') {
            echo '<p><strong>Ваш ответ:</strong> Задача самостоятельно решена не была</p>';
            echo '<p class="error">Результат: Задача не решена</p>';
        } elseif ($is_solved) {
            echo '<p><strong>Ваш ответ:</strong> ' . $user_answer_num . '</p>';
            echo '<p class="success">✅ Тест пройден!</p>';
        } else {
            echo '<p><strong>Ваш ответ:</strong> ' . $user_answer_num . '</p>';
            echo '<p class="error">❌ Ошибка: тест не пройден</p>';
        }
        echo '</div>';
        
        // Отправка email если нужно
        if ($send_mail && !empty($email)) {
            $mail_body = "ФИО: $fio\nГруппа: $group\n";
            if (!empty($about)) $mail_body .= "О себе: $about\n";
            $mail_body .= "Тип задачи: " . getTaskName($task) . "\n";
            $mail_body .= "Входные данные: A=$a, B=$b, C=$c\n";
            $mail_body .= "Правильный ответ: $correct_result\n";
            $mail_body .= "Ваш ответ: " . ($user_answer === '' ? 'не решена' : $user_answer_num) . "\n";
            $mail_body .= "Результат: " . ($is_solved ? 'Тест пройден' : 'Тест не пройден') . "\n";
            
            $headers = "From: test@localhost\r\nContent-Type: text/plain; charset=utf-8\r\n";
            
            if (mail($email, 'Результаты тестирования', $mail_body, $headers)) {
                echo '<p class="success">📧 Результаты теста были автоматически отправлены на e-mail ' . htmlspecialchars($email) . '</p>';
            } else {
                echo '<p class="error">⚠️ Не удалось отправить письмо (возможно, не настроен почтовый сервер)</p>';
            }
        }
        
        // Кнопка "Повторить тест"
        if ($display_type == 'browser') {
            $repeat_link = '?fio=' . urlencode($fio) . '&group=' . urlencode($group) . '&display_type=' . $display_type;
            echo '<a href="' . $repeat_link . '" class="repeat-link">🔄 Повторить тест</a>';
        }
        
    } else {
        // Выводим форму
        $default_fio = isset($_GET['fio']) ? htmlspecialchars($_GET['fio']) : '';
        $default_group = isset($_GET['group']) ? htmlspecialchars($_GET['group']) : '';
        $default_a = getRandomValue();
        $default_b = getRandomValue();
        $default_c = getRandomValue();
        ?>
        
        <div class="form-container">
            <form method="post" action="" name="test_form">
                <div class="form-row">
                    <label>ФИО:</label>
                    <input type="text" name="fio" value="<?php echo $default_fio; ?>" required>
                </div>
                <div class="form-row">
                    <label>Номер группы:</label>
                    <input type="text" name="group" value="<?php echo $default_group; ?>" required>
                </div>
                <div class="form-row">
                    <label>Значение А:</label>
                    <input type="text" name="A" value="<?php echo $default_a; ?>" required>
                </div>
                <div class="form-row">
                    <label>Значение В:</label>
                    <input type="text" name="B" value="<?php echo $default_b; ?>" required>
                </div>
                <div class="form-row">
                    <label>Значение С:</label>
                    <input type="text" name="C" value="<?php echo $default_c; ?>" required>
                </div>
                <div class="form-row">
                    <label>Выберите задачу:</label>
                    <select name="task">
                        <option value="triangle_area">Площадь треугольника</option>
                        <option value="triangle_perimeter">Периметр треугольника</option>
                        <option value="parallelepiped_volume">Объем параллелепипеда</option>
                        <option value="arithmetic_mean">Среднее арифметическое</option>
                        <option value="geometric_mean">Среднее геометрическое</option>
                        <option value="hypotenuse">Гипотенуза (A,B - катеты)</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Ваш ответ:</label>
                    <input type="text" name="user_answer" placeholder="Введите число">
                </div>
                <div class="form-row">
                    <label>Немного о себе:</label>
                    <textarea name="about" placeholder="Расскажите о себе..."></textarea>
                </div>
                <div class="form-row">
                    <label>Версия отображения:</label>
                    <select name="display_type">
                        <option value="browser">Версия для просмотра в браузере</option>
                        <option value="print">Версия для печати</option>
                    </select>
                </div>
                <div class="form-row">
                    <label></label>
                    <input type="checkbox" name="send_mail" id="send_mail_checkbox">
                    <label for="send_mail_checkbox" class="checkbox-label">Отправить результат теста по e-mail</label>
                </div>
                <div class="form-row email-field" id="email_field">
                    <label>Ваш e-mail:</label>
                    <input type="email" name="email" placeholder="example@mail.ru">
                </div>
                <div class="form-row">
                    <label></label>
                    <button type="submit" class="submit-btn">Проверить</button>
                </div>
            </form>
        </div>
        
        <hr>
        <p><small>Подсказка: Для площади треугольника нужны все три стороны; для гипотенузы используются A и B.</small></p>
        
        <script>
            var checkbox = document.getElementById('send_mail_checkbox');
            var emailField = document.getElementById('email_field');
            checkbox.onclick = function() {
                if (this.checked) {
                    emailField.classList.add('show');
                } else {
                    emailField.classList.remove('show');
                }
            }
        </script>
        
        <?php
    }
    
    if ($display_type == 'print') {
        echo '</div>';
    }
    ?>
    
</main>

<footer class="footer">
    Лабораторная работа №6 | Тестирование знаний | Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>