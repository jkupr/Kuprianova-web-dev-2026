<?php
/**
 * Модуль add.php — добавление новой записи в базу данных.
 *
 * Согласно методичке:
 * - HTML-форма задана в статическом виде;
 * - PHP-код для добавления записи также расположен в этом модуле;
 * - после отправки страница перезагружается и выводится та же форма
 *   с надписью "Запись добавлена" (зелёный) или "Ошибка: запись не добавлена" (красный).
 *
 * Признак отправки формы — наличие POST-параметра 'button' со значением 'Добавить запись'
 * (уникальное сочетание, не совпадающее с другими формами сайта).
 */

// Переменная для сообщения об успехе/ошибке (выводится над формой)
$message = '';

// Если форма была отправлена — обрабатываем данные
if (isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {

    $mysqli = mysqli_connect('localhost', 'root', '', 'friends');


    if (mysqli_connect_errno()) {
        $message = '<div class="error-msg">Ошибка подключения к БД: ' . mysqli_connect_error() . '</div>';
    } else {
        // Формируем INSERT-запрос
        // id — автоинкремент, поэтому не указываем его явно
        // htmlspecialchars() заменяет спецсимволы (кавычки и пр.) на HTML-сущности,
        // чтобы они не ломали SQL-запрос
        $sql_res = mysqli_query($mysqli,
            'INSERT INTO friends (surname, name, patronymic, gender, birthdate, phone, address, email, comment)
             VALUES ("' .
            htmlspecialchars($_POST['surname'])    . '", "' .
            htmlspecialchars($_POST['name'])       . '", "' .
            htmlspecialchars($_POST['patronymic']) . '", "' .
            htmlspecialchars($_POST['gender'])     . '", "' .
            htmlspecialchars($_POST['birthdate'])  . '", "' .
            htmlspecialchars($_POST['phone'])      . '", "' .
            htmlspecialchars($_POST['address'])    . '", "' .
            htmlspecialchars($_POST['email'])      . '", "' .
            htmlspecialchars($_POST['comment'])    . '")'
        );

        if (mysqli_errno($mysqli)) {
            $message = '<div class="error-msg">Ошибка: запись не добавлена</div>';
        } else {
            $message = '<div class="ok-msg">Запись добавлена</div>';
        }
    }
}
?>

<h2>Добавление новой записи</h2>

<?php echo $message; ?>

<!-- Статическая HTML-форма. action указывает на тот же модуль через index.php -->
<form name="form_add" method="post" action="?p=add">

    <div class="form-group">
        <label for="surname">Фамилия:</label>
        <input type="text" name="surname" id="surname" placeholder="Фамилия" required>
    </div>

    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" placeholder="Имя" required>
    </div>

    <div class="form-group">
        <label for="patronymic">Отчество:</label>
        <input type="text" name="patronymic" id="patronymic" placeholder="Отчество">
    </div>

    <div class="form-group">
        <label for="gender">Пол:</label>
        <select name="gender" id="gender">
            <option value="М">Мужской</option>
            <option value="Ж">Женский</option>
        </select>
    </div>

    <div class="form-group">
        <label for="birthdate">Дата рождения:</label>
        <input type="date" name="birthdate" id="birthdate">
    </div>

    <div class="form-group">
        <label for="phone">Телефон:</label>
        <input type="tel" name="phone" id="phone" placeholder="+7 (999) 000-00-00">
    </div>

    <div class="form-group">
        <label for="address">Адрес:</label>
        <input type="text" name="address" id="address" placeholder="Город, улица, дом">
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" placeholder="example@mail.ru">
    </div>

    <div class="form-group">
        <label for="comment">Комментарий:</label>
        <textarea name="comment" id="comment" placeholder="Краткий комментарий"></textarea>
    </div>

    <!-- Кнопка с уникальным name и value — признак отправки именно этой формы -->
    <input type="submit" name="button" value="Добавить запись" class="btn-submit">

</form>
