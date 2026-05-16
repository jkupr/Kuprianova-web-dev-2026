<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №3</title>
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
        <p>Лабораторная работа №3</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Лабораторная работа №3</h1>
    <h2>Калькулятор на GET-параметрах</h2>
    
    <?php
    // ========== ОСНОВНОЙ PHP-КОД ДЛЯ ЛР3 ==========
    
    // Инициализация переменных
    // store - хранит введённую строку (результат)
    // count - счётчик нажатий
    
    // Если store не передан (первая загрузка) - создаём пустую строку
    if (!isset($_GET['store'])) {
        $_GET['store'] = '';
    }
    
    // Если count не передан (первая загрузка) - счётчик = 0
    if (!isset($_GET['count'])) {
        $_GET['count'] = 0;
    }
    
    // Обработка нажатия кнопки с цифрой или сбросом
    if (isset($_GET['key'])) {
        if ($_GET['key'] == 'reset') {
            // Кнопка СБРОС: очищаем строку
            $_GET['store'] = '';
            // Счётчик нажатий НЕ обнуляем (по условию - общее число нажатий с момента загрузки)
        } else {
            // Кнопка с цифрой: добавляем цифру к строке
            $_GET['store'] .= $_GET['key'];
        }
        // Увеличиваем счётчик нажатий (любое нажатие кнопки)
        $_GET['count']++;
    }
    
    // ========== ВЫВОД ОКНА РЕЗУЛЬТАТА ==========
    // Окно просмотра результата - div с классом result, текст по центру
    echo '<div class="result-display">';
    // Если строка пустая, выводим (пусто) для наглядности
    if ($_GET['store'] == '') {
        echo '&nbsp;';
    } else {
        echo htmlspecialchars($_GET['store']);
    }
    echo '</div>';
    ?>
    
    <!-- КНОПКИ ЦИФР (в виде ссылок) -->
    <div class="calculator-buttons">
        <div class="digits">
            <?php for ($i = 1; $i <= 9; $i++): ?>
                <a href="?key=<?php echo $i; ?>&store=<?php echo urlencode($_GET['store']); ?>&count=<?php echo $_GET['count']; ?>" class="btn digit"><?php echo $i; ?></a>
            <?php endfor; ?>
            <a href="?key=0&store=<?php echo urlencode($_GET['store']); ?>&count=<?php echo $_GET['count']; ?>" class="btn digit">0</a>
        </div>
        <div class="controls">
            <a href="?key=reset" class="btn reset">СБРОС</a>
        </div>
    </div>
    
    <!-- СТАТИСТИКА В ПОДВАЛЕ СТРАНИЦЫ (в main, но для наглядности) -->
    <div class="stats-info">
        <p>📊 Общее число нажатий кнопок с момента загрузки страницы: <strong><?php echo $_GET['count']; ?></strong></p>
    </div>
    
</main>

<footer class="footer">
    Общее число нажатий: <?php echo $_GET['count']; ?> | Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>