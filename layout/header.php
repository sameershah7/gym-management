<?php
ob_start();
session_start();
// set  time zone to pakistan 
date_default_timezone_set('Asia/Karachi');


//include_once files 
include_once ("../database/db_connect.php");
include_once("../components/common/navbar.php");
include_once("../components/common/footer.php");
include_once("../components/common/confirmationModal.php");
include_once("../components/common/toast.php");
include_once("../components/auth/logout.php");


// this userid will be used in components
$userid = (int) $_SESSION["userId"] ?? "";
$username = $_SESSION["user"] ?? '';
$today = date("l");

// Get current and previous date
$today_date = date("Y-m-d", );
$yesterday_date = date("Y-m-d", strtotime("-1 day"));


if (!isset($_SESSION['user']) || !isset($_SESSION['userId'])) {
    header("Location: auth.php");
    echo "user is not logged in";
    exit;
}

if (isset($_SESSION['toast'])) {
    $toastData = $_SESSION['toast'];
    echo toast($toastData['status'], $toastData['message'], $toastData['bg']);
    unset($_SESSION['toast']);
}

function setToast($status, $message, $bg)
{
    $_SESSION['toast'] = [
        'status' => $status,
        'message' => $message,
        'bg' => $bg
    ];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gym & Diet Management App</title>
    <link rel="stylesheet" href="../style/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

    <!-- Navbar -->
    <?= navbar($_SESSION['user']) ?>