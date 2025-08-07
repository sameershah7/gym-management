<?php
include("../database/db_connect.php");

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $message = "Password does not match";
        $messageClass = "--error";
        return;
    }
    // 1. Check if username or email already exists
    $checkStmt = $conn->prepare("SELECT username, email FROM user_data WHERE username = ? OR email = ?");
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $message = "Username or email already exists.";
        $messageClass = "--error";
    } else {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user_data (username, email, password) VALUES (?, ?,?)");
        $stmt->bind_param("sss", $username, $email, $hashPassword);

        if ($stmt->execute()) {
            session_start();
            $user_id = $conn->insert_id;

            $_SESSION['user'] = $username;
            $_SESSION['userId'] = $user_id;
            header("Location: index.php");
            exit;
        } else {
            $message = "Error creating account: " . $stmt->error;
            $messageClass = "--error";
        }
    }


    $conn->close();

}

echo '<form method="post">
        <h2 class="text-center p-3 fw-bolder fst-italic fs-4" style="color: var(--color);">Sing up </h2>
        <div class="input-group mb-3">
            <input required type="text" autocomplete="off" class="input" id="username" name="username">
            <label class="user-label" for="username">Username</label>
        </div>
        <div class="input-group mb-3">
            <input required type="email" autocomplete="off" class="input" id="email" name="email">
            <label class="user-label" for="email">Email address</label>
        </div>

        
        <div class="mb-3 d">
            <div class="password-wrapper position-relative">
                <div class="input-group">
                    <input required type="password" autocomplete="off" class="input" id="password" name="password">
                    <label class="user-label" for="password">Password</label>
                </div>
                <span id="toggle-password"
                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                </span>
            </div>
            <small id="warning-txt">Password must be at least 8 digits.</small>
        </div>

         <div class="mb-3 d">
            <div class="password-wrapper position-relative">
                <div class="input-group">
                    <input required type="password" autocomplete="off" class="input" id="confirmPassword" name="confirmPassword">
                    <label class="user-label" for="confirmPassword">Confirm password</label>
                </div>
                <span id="toggle-password"
                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                </span>
            </div>
        </div>
       '
    . ($message ? '<small class="d-block text-center" style="color:var(' . $messageClass . ');">' . $message . '</small>' : '')
    . '
        <div class="d-flex flex-column pt-3">
            <button type="submit" class="btn w-100 button" id="signup-btn">Sing up</button>


            <p class="mt-3 text-center d-flex flex-column">
                <a href="?page=login" class="text-decoration-none">Already have account </a>
            </p>
        </div>
    </form>';
?>