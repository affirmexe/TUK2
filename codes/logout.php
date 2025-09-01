<?php
session_start();
session_unset();
session_destroy();
// Clear 'remember' cookie if exists
setcookie('remember', '', time() - 3600, "/");
header("Location: login.php");
