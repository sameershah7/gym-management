<?php

//This for run ajax
include_once __DIR__ . '/../../database/db_connect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $userid = (int) $_SESSION["userId"] ?? "";
}

$stmt = $conn->prepare("SELECT username, password FROM user_data WHERE id = ? ");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();


$currentUserName = $userData["username"] ?? "";

// POST AJAX handler   
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['newUsername'] ?? '');

    // checking username if taken or not 
    if ($newUsername) {
        if ($currentUserName === $newUsername)
            exit;

        if (strlen($newUsername) < 4) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Username must be at least 4 characters long',
            ]);
            exit;
        }

        // Prepare and execute check query
        $stmt = $conn->prepare('SELECT username FROM user_data WHERE BINARY username = ? AND id != ?');
        $stmt->bind_param('si', $newUsername, $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for existing username
        if ($result->num_rows > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'This username is not available',
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'This username is available',
            ]);
        }
        exit;
    }
    ;

    // Update username
    if (isset($_POST["new-username"])) {
        $newUsername = trim($_POST["new-username"] ?? "");

        if (!empty($newUsername)) {
            $stmt = $conn->prepare("UPDATE user_data SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $newUsername, $userid);

            if ($stmt->execute()) {
                $_SESSION["user"] = $newUsername;
                setToast("Success", "Username updated successfully", "success");
                header("location:profile.php");
            } else {
                setToast("Error", "Failed to update username", "error");
            }
            $stmt->close();
        }
    }

}


// updating password
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new-password"], $_POST["current-password"], $_POST["confirm-password"]) && isset($_SESSION["user"])) {
    $oldPassword = trim($_POST["current-password"]);
    $newPassword = trim($_POST["new-password"]);
    $confirmPassword = trim($_POST["confirm-password"]);

    if (strlen($newPassword) < 8 && strlen($confirmPassword) < 8) {
        setToast("Error", "Passwords must be  8 character or above", "error");
        header("Location: profile.php");
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        setToast("Error", "Passwords do not match", "error");
        header("Location: profile.php");
        exit();
    }

    if (!$userData || !password_verify($oldPassword, $userData["password"])) {
        setToast("Error", "Password is incorrect", "error");
        header("Location: profile.php");
        exit();
    }

    // Hash and update new password
    $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user_data SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashPassword, $userid);

    if ($stmt->execute()) {
        setToast("Success", "Password updated successfully", "success");
    } else {
        setToast("Error", "Failed to update password", "error");
    }
    $stmt->close();
    header("Location: profile.php");
    exit();

}
?>