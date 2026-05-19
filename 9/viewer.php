<?php
/**
 * Модуль viewer.php — библиотека функций для вывода содержимого записной книжки.
 *
 * Содержит пользовательскую функцию getFriendsList($type, $page),
 * которая возвращает HTML-строку с таблицей контактов и блоком пагинации.
 *
 * Параметры:
 *   $type  — тип сортировки: 'byid' | 'fam' | 'birth'
 *   $page  — номер текущей страницы пагинации (начиная с 0)
 *
 * Согласно заданию:
 * - выводится не более 10 записей на странице;
 * - если записей больше — выводится пагинация с номерами страниц;
 * - при наведении на ссылку пагинации — рамка 2px;
 * - сортировка: по порядку добавления / по фамилии / по дате рождения (возрастание).
 */
function getFriendsList(string $type, int $page): string
{
    // Подключаемся к серверу базы данных
    $mysqli = mysqli_connect('localhost', 'root', '', 'friends');

    // Проверяем корректность подключения
    if (mysqli_connect_errno()) {
        return 'Ошибка подключения к БД: ' . mysqli_connect_error();
    }

    // --- Шаг 1: определяем общее количество записей для пагинации ---
    $sql_res = mysqli_query($mysqli, 'SELECT COUNT(*) FROM friends');

    if (!mysqli_errno($mysqli) && $row = mysqli_fetch_row($sql_res)) {
        if (!$TOTAL = $row[0]) {
            // В таблице нет записей
            return '<p class="info-msg">В записной книжке пока нет контактов.</p>';
        }

        // Вычисляем общее количество страниц (по 10 записей на странице)
        $PAGES = ceil($TOTAL / 10);

        // Проверяем корректность номера страницы
        if ($page >= $PAGES) {
            $page = $PAGES - 1;
        }

        // --- Шаг 2: определяем сортировку ---
        // Формируем часть SQL-запроса ORDER BY в зависимости от $type
        switch ($type) {
            case 'fam':
                $orderBy = 'ORDER BY surname ASC';
                break;
            case 'birth':
                $orderBy = 'ORDER BY birthdate ASC';
                break;
            default: // 'byid' — по порядку добавления
                $orderBy = 'ORDER BY id ASC';
                break;
        }

        // --- Шаг 3: выбираем записи для текущей страницы ---
        // LIMIT offset, count — отступ = номер страницы * 10, количество = 10
        $offset = $page * 10;
        $sql = 'SELECT * FROM friends ' . $orderBy . ' LIMIT ' . $offset . ', 10';
        $sql_res = mysqli_query($mysqli, $sql);

        // Формируем HTML-таблицу с данными
        $ret = '<table class="food-table">';
        $ret .= '<tr>
                    <th>#</th>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Пол</th>
                    <th>Дата рождения</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>E-mail</th>
                    <th>Комментарий</th>
                 </tr>';

        $num = $offset + 1; // порядковый номер строки
        while ($row = mysqli_fetch_assoc($sql_res)) {
            $ret .= '<tr>
                        <td>' . $num++ . '</td>
                        <td>' . htmlspecialchars($row['surname']) . '</td>
                        <td>' . htmlspecialchars($row['name']) . '</td>
                        <td>' . htmlspecialchars($row['patronymic']) . '</td>
                        <td>' . htmlspecialchars($row['gender']) . '</td>
                        <td>' . htmlspecialchars($row['birthdate']) . '</td>
                        <td>' . htmlspecialchars($row['phone']) . '</td>
                        <td>' . htmlspecialchars($row['address']) . '</td>
                        <td>' . htmlspecialchars($row['email']) . '</td>
                        <td>' . htmlspecialchars($row['comment']) . '</td>
                     </tr>';
        }

        $ret .= '</table>';

        // --- Шаг 4: пагинация (если страниц больше одной) ---
        if ($PAGES > 1) {
            $ret .= '<div id="pages"><span>Страницы: </span>';

            for ($i = 0; $i < $PAGES; $i++) {
                if ($i != $page) {
                    // Ссылка на другую страницу (при наведении — рамка 2px, задаётся в CSS)
                    // Тип сортировки сохраняется в параметре &sort= при переходе
                    $ret .= '<a href="?p=viewer&sort=' . $type . '&pg=' . $i . '">' . ($i + 1) . '</a>';
                } else {
                    // Текущая страница — не ссылка, а тег <span> для выделения в CSS
                    $ret .= '<span class="current-page">' . ($i + 1) . '</span>';
                }
            }

            $ret .= '</div>';
        }

        return $ret;
    }

    // Если запрос не выполнился корректно
    return 'Неизвестная ошибка базы данных.';
}
