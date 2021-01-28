<?php
require_once "vendor/connect.php";

$result = $db->query("SELECT * FROM specialization");

while ($row = $result->fetch(PDO::FETCH_BOTH)) {
    echo "<option value=" . $row['id_spec'] . ">" . $row['name'] . "</option>";
}
