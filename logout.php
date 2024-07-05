<?php
session_start();
session_destroy();

header("Location: index.php"); // Redirect to the main page after logout instead of must login again
exit();
?>
