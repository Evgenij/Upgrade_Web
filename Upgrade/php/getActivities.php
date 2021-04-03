<?php
require_once "vendor/connect.php";

$result = $db->query("SELECT activity.id_act, activity.name FROM activity");

while ($row = $result->fetch(PDO::FETCH_BOTH)) {
    echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
}