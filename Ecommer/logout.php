<?php
session_start();

// Cancel all sessions
session_unset();
session_destroy();

// Abort all sessions
header("Location: index.php");
exit();
?>
