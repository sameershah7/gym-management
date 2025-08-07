<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout-true'])) {

    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>