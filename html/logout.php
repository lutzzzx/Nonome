<?php
session_start();
session_unset();
session_destroy();

header("Location: auth-boxed-signin.php");
exit();
?>
