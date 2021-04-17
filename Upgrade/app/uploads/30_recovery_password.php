<?php

require_once "connect.php";

$email = trim($_GET['email']);

mail($email, "Test", "password!!!"); 