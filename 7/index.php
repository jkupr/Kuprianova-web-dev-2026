<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №7</title>
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
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Лабораторная работа №7</h1>
    <h2>Сортировка массивов</h2>
    
    <form method="post" action="sort_process.php">
        <input type="hidden" name="arrLength" id="arrLength" value="1">
        
        <table id="elements_table" class="elements-table">
            <tr id="row_0">
                <td>0. </td>
                <td><input type="text" name="element_0"></td>
            </tr>
        </table>
        
        <button type="button" onclick="addElement()">Добавить еще один элемент</button>
        
        <select name="algorithm">
            <option value="choice">Сортировка выбором</option>
            <option value="bubble">Пузырьковый алгоритм</option>
            <option value="shell">Алгоритм Шелла</option>
            <option value="gnome">Алгоритм садового гнома</option>
            <option value="quick">Быстрая сортировка</option>
            <option value="php_sort">Встроенная функция PHP для сортировки списков по значению</option>
        </select>
        
        <button type="submit">Сортировать массив</button>
    </form>
</main>

<footer class="footer">
    Сформировано <?php echo date('d.m.Y H:i:s'); ?>
</footer>

<script>
    var elementCount = 1;
    
    function addElement() {
        var table = document.getElementById('elements_table');
        var row = table.insertRow();
        row.id = 'row_' + elementCount;
        
        var cell1 = row.insertCell(0);
        cell1.innerHTML = elementCount + '. ';
        
        var cell2 = row.insertCell(1);
        cell2.innerHTML = '<input type="text" name="element_' + elementCount + '">';
        
        elementCount++;
        document.getElementById('arrLength').value = elementCount;
    }
</script>

</body>
</html>