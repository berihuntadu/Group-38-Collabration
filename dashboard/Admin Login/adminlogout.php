<?php
session_start();
session_unset();
session_destroy();

// Redirect to public dashboard (one level up and into public folder)
header("Location: ../dashboard.php"); 
exit();
?>