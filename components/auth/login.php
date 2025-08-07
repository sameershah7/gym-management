<?php

$isError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password  FROM user_data WHERE BINARY  username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashPassword);
        $stmt->fetch();

        //  Verify the hashed password
        if (password_verify($password, $hashPassword)) {
            session_start();
            $_SESSION['user'] = $username;
            $_SESSION['userId'] = $user_id;
            header("Location: index.php");
            exit;
        } else {
            $isError = true; // Wrong password
        }
    } else {
        $isError = true; // Username not found
    }
    $stmt->close();
}

echo '
<form method="post">
        <h2 class="text-center p-3 fw-bolder fst-italic fs-4" style="color: var(--color);">Login In </h2>
        <div class="input-group mb-3">
            <input required type="text" autocomplete="off" class="input" id="username" name="username">
            <label class="user-label" for="username">Username</label>
        </div>

        <div class="mb-3 ">
            <div class="password-wrapper position-relative">
                <div class="input-group ">
                    <input required type="password" autocomplete="off" class="input" id="password" name="password">
                    <label class="user-label" for="password">Password</label>
                    
                </div>
                <span id="toggle-password"
                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                </span>
            </div>

        </div>'
    . ($isError ? '<small class="d-block text-center" style="color:var(--error);">Username or password incorrect</small>' : '')
    . '<div class="d-flex flex-column pt-3">
           
       <div class="d-flex flex-column pt-3">
            <button type="submit" class="btn w-100 button">Login</button>


            <p class="mt-3 text-center d-flex flex-column">
                <a href="?page=signup" class="text-decoration-none">Create new account </a>
                <a href="?page=forgot" class="text-decoration-none">Forget password</a>
            </p>
        </div>
    </form>
    ';
?>