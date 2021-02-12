<?php
require_once "vendor/connect.php";

$sql = "SELECT project.id_project, project.name FROM project INNER JOIN user ON user.id_user = project.id_user WHERE user.id_user = :idUser";

$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);

while ($row = $query->fetch(PDO::FETCH_BOTH)) {
    echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
}
