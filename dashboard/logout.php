<?php
session_start();
session_destroy();

header('location:../index.php'); //logout hoye gele home page a chole jabe
?>