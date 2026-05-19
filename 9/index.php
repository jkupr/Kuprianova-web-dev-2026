<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №9</title>
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
        <p>Лабораторная работа №9</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Записная книжка</h1>

    <?php
    // Подключаем модуль меню — он всегда нужен на странице
    // require вставляет код до начала выполнения программы
    require 'menu.php';

    // Вызываем функцию из menu.php — она возвращает HTML-код меню
    echo getMenu();

    // В зависимости от выбранного пункта меню подключаем нужный модуль
    // Проверка $_GET['p'] уже сделана внутри getMenu(),
    // поэтому здесь значение гарантированно корректное

    if ($_GET['p'] == 'viewer') {
        // Подключаем модуль с библиотекой функций просмотра
        // include добавляет код во время выполнения — имя файла можно формировать динамически
        include 'viewer.php';

        // Проверяем и корректируем номер страницы пагинации
        if (!isset($_GET['pg']) || $_GET['pg'] < 0) {
            $_GET['pg'] = 0;
        }

        // Проверяем тип сортировки — допустимы только три значения
        if (!isset($_GET['sort']) ||
            ($_GET['sort'] != 'byid' && $_GET['sort'] != 'fam' && $_GET['sort'] != 'birth')) {
            $_GET['sort'] = 'byid';
        }

        // Вызываем функцию из viewer.php и выводим результат
        echo getFriendsList($_GET['sort'], $_GET['pg']);

    } else {
        // Для остальных модулей: имя файла совпадает со значением параметра p
        // file_exists проверяет существование файла перед подключением
        if (file_exists($_GET['p'] . '.php')) {
            include $_GET['p'] . '.php';
        }
    }
    ?>
</main>

<footer class="footer">
    Сформировано <?php echo date('d.m.Y в H-i-s'); ?>
</footer>

</body>
</html>
