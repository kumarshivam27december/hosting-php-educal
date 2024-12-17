<?php
session_start();
session_destroy(); 
header("Location: Alogin.php");  
exit();
?>
