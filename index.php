<?php

$mysqli = new mysqli("localhost","root","","magna");
if (mysqli_connect_errno($mysqli)) {
    die ("Failed to connect to MySQL: " . mysqli_connect_error());
}

?>