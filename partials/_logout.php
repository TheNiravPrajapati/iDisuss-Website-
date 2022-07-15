<?php
session_start();
echo "Login out Pls wait";


session_destroy();
header("location: /forum/index.php");
?>