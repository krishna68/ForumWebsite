<?php
session_start();
// echo "Logginfg";
session_destroy();
header("Location: /forum/index.php");
?>