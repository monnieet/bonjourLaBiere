<?php 

// Destroy the session opened, then back to home page
session_start();
session_destroy();

header("Location: ../home.php");

 ?>