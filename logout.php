<?php
 require('admin Panel/inc/essential.php');
 session_start();
 session_destroy();
 redirect('home.php')
?>