<?php
/**
 * Модуль edit.php — редактирование существующей записи в базе данных.
 *
 * Согласно заданию:
 * - перед формой выводится список ссылок с именами и фамилиями,
 *   отсортированными по фамилии, затем по имени;
 * - при переходе по ссылке поля формы заполняются значениями выбранной записи;
 * - текущая запись выделяется в списке (не ссылка, а блок <div>);
 * - если запись не выбрана — текущей считается первая по порядку;
 * - весь HTML и PHP-код находится в этом модуле.
 *
 * Реализован второй (оптимальный) вариант из листинга В-1.8:
 * два отдельных SQL-запроса — для получения текущей записи и для списка всех записей.
 * id передаётся через GET-параметр.
 */

// Шаг 1: подключаемся к базе данных
$mysqli = mysqli_connect('localhost', 'root', '', 'friends');


if (mysqli_connect_errno()) {
    // При ошибке подключения — выводим сообщение и останавливаем программу
    echo 'Ошибка подключения к БД: ' . mysqli_connect_error();
    exit();
}

// Шаг 2: если форма отправлена — обновляем запись в БД
// Признак: POST-параметр 'button' == 'Изменить запись'
if (isset($_POST['button']) && $_POST['button'] == 'Изменить запись') {

    // id редактируемой записи передаётся через GET-параметр (в action формы)
    $sql_res = mysqli_query($mysqli,
        'UPDATE friends SET
            surname    = "' . htmlspecialchars($_POST['surname'])    . '",
            name       = "' . htmlspecialchars($_POST['name'])       . '",
            patronymic = "' . htmlspecialchars($_POST['patronymic']) . '",
            gender     = "' . htmlspecialchars($_POST['gender'])     . '",
            birthdate  = "' . htmlspecialchars($_POST['birthdate'])  . '",
            phone      = "' . htmlspecialchars($_POST['phone'])      . '",
            address    = "' . htmlspecialchars($_POST['address'])    . '",
            email      = "' . htmlspecialchars($_POST['email'])      . '",
            comment    = "' . htmlspecialchars($_POST['comment'])    . '"
         WHERE id=' . (int)$_GET['id']
    );

    echo '<div class="ok-msg">Данные изменены</div>';
}

// Шаг 3: определяем текущую запись
$currentROW = [];

if (isset($_GET['id'])) {
    // id передан — ищем конкретную запись
    // LIMIT 0,1 — оптимизация: сервер остановится, найдя первую подходящую запись
    $sql_res = mysqli_query($mysqli,
        'SELECT * FROM friends WHERE id=' . (int)$_GET['id'] . ' LIMIT 0, 1'
    );
    $currentROW = mysqli_fetch_assoc($sql_res) ?: [];
}

if (!$currentROW) {
    // id не передан или запись не найдена — берём первую запись как текущую
    $sql_res = mysqli_query($mysqli, 'SELECT * FROM friends ORDER BY surname ASC, name ASC LIMIT 0, 1');
    $currentROW = mysqli_fetch_assoc($sql_res) ?: [];
}

// Шаг 4: выводим список ссылок (только нужные поля — id, surname, name)
$sql_res = mysqli_query($mysqli, 'SELECT id, surname, name FROM friends ORDER BY surname ASC, name ASC');
?>

<h2>Редактирование записи</h2>

<?php if (!mysqli_errno($mysqli)) : ?>

    <div id="edit_links">
        <?php while ($row = mysqli_fetch_assoc($sql_res)) : ?>
            <?php if ($currentROW && $currentROW['id'] == $row['id']) : ?>
                <!-- Текущая запись — не ссылка, выделяется блоком div -->
                <div class="current-link"><?= htmlspecialchars($row['surname'] . ' ' . $row['name']) ?></div>
            <?php else : ?>
                <!-- Остальные записи — ссылки, при переходе по ним запись станет текущей -->
                <a href="?p=edit&id=<?= $row['id'] ?>"><?= htmlspecialchars($row['surname'] . ' ' . $row['name']) ?></a>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>

    <?php if ($currentROW) : ?>
        <!-- Форма редактирования; id текущей записи передаётся через GET в action -->
        <form name="form_edit" method="post" action="?p=edit&id=<?= $currentROW['id'] ?>">

            <div class="form-group">
                <label for="surname">Фамилия:</label>
                <input type="text" name="surname" id="surname"
                       value="<?= htmlspecialchars($currentROW['surname']) ?>" required>
            </div>

            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" id="name"
                       value="<?= htmlspecialchars($currentROW['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="patronymic">Отчество:</label>
                <input type="text" name="patronymic" id="patronymic"
                       value="<?= htmlspecialchars($currentROW['patronymic']) ?>">
            </div>

            <div class="form-group">
                <label for="gender">Пол:</label>
                <select name="gender" id="gender">
                    <option value="М" <?= $currentROW['gender'] == 'М' ? 'selected' : '' ?>>Мужской</option>
                    <option value="Ж" <?= $currentROW['gender'] == 'Ж' ? 'selected' : '' ?>>Женский</option>
                </select>
            </div>

            <div class="form-group">
                <label for="birthdate">Дата рождения:</label>
                <input type="date" name="birthdate" id="birthdate"
                       value="<?= htmlspecialchars($currentROW['birthdate']) ?>">
            </div>

            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="tel" name="phone" id="phone"
                       value="<?= htmlspecialchars($currentROW['phone']) ?>">
            </div>

            <div class="form-group">
                <label for="address">Адрес:</label>
                <input type="text" name="address" id="address"
                       value="<?= htmlspecialchars($currentROW['address']) ?>">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email"
                       value="<?= htmlspecialchars($currentROW['email']) ?>">
            </div>

            <div class="form-group">
                <label for="comment">Комментарий:</label>
                <textarea name="comment" id="comment"><?= htmlspecialchars($currentROW['comment']) ?></textarea>
            </div>

            <input type="submit" name="button" value="Изменить запись" class="btn-submit">

        </form>
    <?php else : ?>
        <p class="info-msg">Записей пока нет.</p>
    <?php endif; ?>

<?php else : ?>
    <p class="error-msg">Ошибка базы данных.</p>
<?php endif; ?>
