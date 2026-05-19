<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
    $_SESSION['iteration'] = 0;
}

$_SESSION['iteration']++;

function isnum($x) {
    if ($x === '' || $x === null) return false;
    
    if ($x[0] == '-') {
        $x = substr($x, 1);
        if ($x === '') return false;
    }
    
    if ($x === '.' || $x === '0') return false; 
    if ($x[0] == '.' || ($x[0] == '0' && strlen($x) > 1 && $x[1] != '.')) return false;
    if ($x[strlen($x) - 1] == '.') return false;
    
    $point_count = false;
    for ($i = 0; $i < strlen($x); $i++) {
        if ($x[$i] != '0' && $x[$i] != '1' && $x[$i] != '2' && $x[$i] != '3' &&
            $x[$i] != '4' && $x[$i] != '5' && $x[$i] != '6' && $x[$i] != '7' &&
            $x[$i] != '8' && $x[$i] != '9' && $x[$i] != '.') {
            return false;
        }
        if ($x[$i] == '.') {
            if ($point_count) return false;
            else $point_count = true;
        }
    }
    return true;
}

function calculate($val) {
    if ($val === '') return 'Выражение не задано!';
    if (isnum($val)) return $val;

    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            $sum += (float)$arg;
        }
        return (string)$sum;
    }

    $is_negative = false;
    $work_val = $val;
    if ($val[0] === '-') {
        $is_negative = true;
        $work_val = substr($val, 1);
    }

    $args = explode('-', $work_val);
    if (count($args) > 1 || ($is_negative && count($args) > 1)) {
        if ($is_negative) {
            $first_arg = calculate('-' . $args[0]);
        } else {
            $first_arg = calculate($args[0]);
        }
        
        if (!isnum($first_arg)) return $first_arg;
        $sub = (float)$first_arg;

        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            $sub -= (float)$arg;
        }
        return (string)$sub;
    }

    $args = explode('*', $val);
    if (count($args) > 1) {
        $sup = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return 'Неправильная форма числа!';
            $sup *= (float)$arg;
        }
        return (string)$sup;
    }

    $val_div = str_replace(':', '/', $val);
    $args = explode('/', $val_div);
    if (count($args) > 1) {
        $first_arg = calculate($args[0]);
        if (!isnum($first_arg)) return $first_arg;
        $div = (float)$first_arg;

        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            
            if ((float)$arg == 0) {
                return 'Ошибка: Деление на ноль!';
            }
            $div /= (float)$arg;
        }
        return (string)$div;
    }

    return 'Недопустимые символы в выражении: ' . $val;
}

function SqValidator($val) {
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $open++;
        } else if ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false;
        }
    }
    if ($open != 0) return false;
    return true;
}

function calculateSq($val) {
    if (!SqValidator($val)) return 'Неправильная расстановка скобок!';
    
    $start = strpos($val, '(');
    if ($start === false) {
        return calculate($val);
    }
    
    $end = $start + 1;
    $open = 1;
    while ($open && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        if ($val[$end] == ')') $open--;
        $end++;
    }
    
    $left_part = substr($val, 0, $start);
    $inner_expr = substr($val, $start + 1, $end - $start - 2);
    $right_part = substr($val, $end);
    
    $inner_res = calculateSq($inner_expr); 
    if (!isnum($inner_res) && (strpos($inner_res, 'Ошибка') !== false || strpos($inner_res, 'Неправильная') !== false || strpos($inner_res, 'Недопустимые') !== false)) {
        return $inner_res;
    }
    
    $new_val = $left_part . $inner_res . $right_part;
    
    if ($new_val === $val) {
        return 'Ошибка анализа выражения!';
    }
    
    return calculateSq($new_val);
}

$res = '';
$expression = '';
if (isset($_POST['val'])) {
    $expression = trim($_POST['val']);
    $res = calculateSq($expression);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Куприянова Юлия Андреевна, группа 241-353 | Лабораторная работа №10</title>
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
        <p>Лабораторная работа №10 (В-2)</p>
    </div>
    <div class="nav-menu">
        <a href="index.php" class="active">Главная</a>
    </div>
</header>

<main class="container">
    <h1>Арифметический калькулятор</h1>
    
    <?php if (isset($_POST['val'])): ?>
        <div class="result-box">
            <?php if (isnum($res)): ?>
                <p class="calc-success"><strong>Значение выражения:</strong> <?php echo htmlspecialchars($expression); ?> = <?php echo htmlspecialchars($res); ?></p>
            <?php else: ?>
                <p class="calc-error"><strong>Ошибка вычисления выражения:</strong> <?php echo htmlspecialchars($res); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST" class="calc-form">
        <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
        <div class="form-group">
            <label for="val">Введите вычисляемое выражение:</label>
            <input type="text" id="val" name="val" value="<?php echo htmlspecialchars($expression); ?>" placeholder="Например: -2*(3+5.5)/2" required>
        </div>
        <button type="submit" class="btn-submit">Вычислить</button>
    </form>
</main>

<footer class="footer">
    <div class="history-container">
        <h3>История вычислений</h3>
        <div class="history-list">
            <?php
            if (isset($_SESSION['history'])) {
                for ($i = 0; $i < count($_SESSION['history']); $i++) {
                    echo '<p class="history-item">' . $_SESSION['history'][$i] . '</p>';
                }
            }
            
            if (isset($_POST['val']) && isset($_POST['iteration']) && ((int)$_POST['iteration'] + 1 == $_SESSION['iteration'])) {
                $_SESSION['history'][] = htmlspecialchars($expression) . ' = ' . htmlspecialchars($res);
            }
            ?>
        </div>
    </div>
</footer>

</body>
</html>