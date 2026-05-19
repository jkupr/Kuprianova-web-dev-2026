<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №8 - Результат</title>
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
        <p>Лабораторная работа №8</p>
    </div>
    <div class="nav-menu">
        <a href="index.html">Главная</a>
    </div>
</header>

<main class="container">
    <?php
    
    // Функция для перекодировки строки из CP1251 в UTF-8 для вывода
    function to_utf8($str) {
        return iconv("cp1251", "utf-8", $str);
    }
    
    // Функция анализа текста
    function test_it($text) {
        
        // Перекодируем текст для корректной обработки кириллицы
        $text = iconv("utf-8", "cp1251", $text);
        
        // 1. Исходный текст (выделен цветом и курсивом)
        echo '<div class="src-text">';
        echo '<h3>Исходный текст:</h3>';
        echo '<p class="original-text">' . to_utf8($text) . '</p>';
        echo '</div>';
        
        echo '<h3>Информация о тексте:</h3>';
        echo '<table class="result-table">';
        
        // 2.1 Количество символов (включая пробелы)
        $char_count = strlen($text);
        echo '<tr><td>Количество символов (включая пробелы)</td><td>' . $char_count . '</td></tr>';
        
        // Определение массивов символов
        $lower_letters = array(
            'а'=>true,'б'=>true,'в'=>true,'г'=>true,'д'=>true,'е'=>true,'ё'=>true,
            'ж'=>true,'з'=>true,'и'=>true,'й'=>true,'к'=>true,'л'=>true,'м'=>true,
            'н'=>true,'о'=>true,'п'=>true,'р'=>true,'с'=>true,'т'=>true,'у'=>true,
            'ф'=>true,'х'=>true,'ц'=>true,'ч'=>true,'ш'=>true,'щ'=>true,'ъ'=>true,
            'ы'=>true,'ь'=>true,'э'=>true,'ю'=>true,'я'=>true,
            'a'=>true,'b'=>true,'c'=>true,'d'=>true,'e'=>true,'f'=>true,'g'=>true,
            'h'=>true,'i'=>true,'j'=>true,'k'=>true,'l'=>true,'m'=>true,'n'=>true,
            'o'=>true,'p'=>true,'q'=>true,'r'=>true,'s'=>true,'t'=>true,'u'=>true,
            'v'=>true,'w'=>true,'x'=>true,'y'=>true,'z'=>true
        );
        
        $upper_letters = array(
            'А'=>true,'Б'=>true,'В'=>true,'Г'=>true,'Д'=>true,'Е'=>true,'Ё'=>true,
            'Ж'=>true,'З'=>true,'И'=>true,'Й'=>true,'К'=>true,'Л'=>true,'М'=>true,
            'Н'=>true,'О'=>true,'П'=>true,'Р'=>true,'С'=>true,'Т'=>true,'У'=>true,
            'Ф'=>true,'Х'=>true,'Ц'=>true,'Ч'=>true,'Ш'=>true,'Щ'=>true,'Ъ'=>true,
            'Ы'=>true,'Ь'=>true,'Э'=>true,'Ю'=>true,'Я'=>true,
            'A'=>true,'B'=>true,'C'=>true,'D'=>true,'E'=>true,'F'=>true,'G'=>true,
            'H'=>true,'I'=>true,'J'=>true,'K'=>true,'L'=>true,'M'=>true,'N'=>true,
            'O'=>true,'P'=>true,'Q'=>true,'R'=>true,'S'=>true,'T'=>true,'U'=>true,
            'V'=>true,'W'=>true,'X'=>true,'Y'=>true,'Z'=>true
        );
        
        $punctuation = array(
            '.'=>true,','=>true,'!'=>true,'?'=>true,';'=>true,':'=>true,'-'=>true,
            '('=>true,')'=>true,'['=>true,']'=>true,'{'=>true,'}'=>true,'"'=>true,
            "'"=>true,'`'=>true,'…'=>true
        );
        
        $digits = array(
            '0'=>true,'1'=>true,'2'=>true,'3'=>true,'4'=>true,
            '5'=>true,'6'=>true,'7'=>true,'8'=>true,'9'=>true
        );
        
        // Подсчет
        $letter_count = 0;
        $lower_count = 0;
        $upper_count = 0;
        $punctuation_count = 0;
        $digit_count = 0;
        
        $word = '';
        $words = array();
        $symbols = array();
        
        $text_lower = strtolower($text);
        
        for ($i = 0; $i < strlen($text); $i++) {
            $ch = $text[$i];
            $ch_lower = $text_lower[$i];
            
            // Подсчет букв
            if (isset($lower_letters[$ch])) {
                $letter_count++;
                $lower_count++;
            } elseif (isset($upper_letters[$ch])) {
                $letter_count++;
                $upper_count++;
            }
            
            // Подсчет знаков препинания
            if (isset($punctuation[$ch])) {
                $punctuation_count++;
            }
            
            // Подсчет цифр
            if (isset($digits[$ch])) {
                $digit_count++;
            }
            
            // Подсчет символов (без учета регистра)
            if (isset($symbols[$ch_lower])) {
                $symbols[$ch_lower]++;
            } else {
                $symbols[$ch_lower] = 1;
            }
            
            // Разбиение на слова
            if ($ch == ' ' || $ch == "\n" || $ch == "\r" || $ch == "\t" || isset($punctuation[$ch])) {
                if ($word != '') {
                    if (isset($words[$word])) {
                        $words[$word]++;
                    } else {
                        $words[$word] = 1;
                    }
                    $word = '';
                }
            } else {
                $word .= $ch;
            }
        }
        
        // Последнее слово
        if ($word != '') {
            if (isset($words[$word])) {
                $words[$word]++;
            } else {
                $words[$word] = 1;
            }
        }
        
        // Вывод результатов
        echo '<tr><td>Количество букв</td><td>' . $letter_count . '</td></tr>';
        echo '<tr><td>Количество строчных букв</td><td>' . $lower_count . '</td></tr>';
        echo '<tr><td>Количество заглавных букв</td><td>' . $upper_count . '</td></tr>';
        echo '<tr><td>Количество знаков препинания</td><td>' . $punctuation_count . '</td></tr>';
        echo '<tr><td>Количество цифр</td><td>' . $digit_count . '</td></tr>';
        echo '<tr><td>Количество слов</td><td>' . count($words) . '</td></tr>';
        
        echo '</table>';
        
        // Количество вхождений каждого символа
        echo '<h3>Количество вхождений каждого символа:</h3>';
        echo '<table class="result-table">';
        echo '<tr><th>Символ</th><th>Количество</th></tr>';
        ksort($symbols);
        foreach ($symbols as $symb => $count) {
            if ($symb !== '') {
                echo '<tr><td>' . to_utf8($symb) . '</td><td>' . $count . '</td></tr>';
            }
        }
        echo '</table>';
        
        // Список всех слов и количество их вхождений (отсортированный по алфавиту)
        echo '<h3>Список слов и количество вхождений:</h3>';
        echo '<table class="result-table">';
        echo '<tr><th>Слово</th><th>Количество</th></tr>';
        ksort($words);
        foreach ($words as $w => $count) {
            echo '<tr><td>' . to_utf8($w) . '</td><td>' . $count . '</td></tr>';
        }
        echo '</table>';
    }
    
    // Основная логика
    if (isset($_POST['data']) && $_POST['data'] != '') {
        test_it($_POST['data']);
    } else {
        echo '<div class="src_error">Нет текста для анализа</div>';
    }
    
    ?>
    
    <div class="button-container">
        <a href="index.html" class="btn">Другой анализ</a>
    </div>
    
</main>

<footer class="footer">
    <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>