<?php
/**
 * Модуль delete.php — удаление записи из базы данных.
 *
 * Согласно заданию:
 * - выводится список ссылок с фамилией и инициалами контактов;
 * - при переходе по ссылке страница перезагружается,
 *   запись удаляется, выводится надпись вида: "Запись с фамилией Иванов удалена";
 * - весь HTML и PHP-код находится в этом модуле.
 */

// Подключаемся к базе данных
$mysqli = mysqli_connect('localhost', 'root', '', 'friends');


if (mysqli_connect_errno()) {
    echo 'Ошибка подключения к БД: ' . mysqli_connect_error();
    exit();
}

// Если в GET-параметрах передан id — удаляем запись
if (isset($_GET['del_id'])) {
    $del_id = (int)$_GET['del_id']; // (int) защищает от SQL-инъекций

    // Сначала получаем фамилию удаляемой записи, чтобы вывести её в сообщении
    $res = mysqli_query($mysqli, 'SELECT surname FROM friends WHERE id=' . $del_id . ' LIMIT 0, 1');
    $delRow = mysqli_fetch_assoc($res);

    if ($delRow) {
        // Удаляем запись с указанным id
        mysqli_query($mysqli, 'DELETE FROM friends WHERE id=' . $del_id);

        if (!mysqli_errno($mysqli)) {
            echo '<div class="ok-msg">Запись с фамилией ' .
                htmlspecialchars($delRow['surname']) . ' удалена</div>';
        } else {
            echo '<div class="error-msg">Ошибка: запись не удалена</div>';
        }
    } else {
        echo '<div class="error-msg">Запись не найдена</div>';
    }
}

// Выводим обновлённый список оставшихся записей в виде ссылок
// В списке: фамилия и инициалы (не ФИО целиком)
$sql_res = mysqli_query($mysqli, 'SELECT id, surname, name, patronymic FROM friends ORDER BY surname ASC, name ASC');
?>

<h2>Удаление записи</h2>

<?php if (!mysqli_errno($mysqli)) : ?>

    <div id="delete_links">
        <?php
        $found = false;
        while ($row = mysqli_fetch_assoc($sql_res)) :
            $found = true;

            // Формируем инициалы: первые буквы имени и отчества с точкой
            $initials = mb_substr($row['name'], 0, 1, 'UTF-8') . '.'
                . (mb_strlen($row['patronymic'], 'UTF-8') > 0
                    ? mb_substr($row['patronymic'], 0, 1, 'UTF-8') . '.'
                    : '');

            // Текст ссылки: Фамилия И.О.
            $linkText = htmlspecialchars($row['surname'] . ' ' . $initials);
            ?>
            <!-- При переходе передаём del_id — отдельный параметр, чтобы не путать с id редактирования -->
            <a href="?p=delete&del_id=<?= $row['id'] ?>" class="delete-link"
               onclick="return confirm('Удалить запись <?= $linkText ?>?')">
                <?= $linkText ?>
            </a>
        <?php endwhile; ?>

        <?php if (!$found) : ?>
            <p class="info-msg">Записей нет — удалять нечего.</p>
        <?php endif; ?>
    </div>

<?php else : ?>
    <p class="error-msg">Ошибка базы данных.</p>
<?php endif; ?>
