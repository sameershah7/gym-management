<?php
session_start();
include("../database/db_connect.php");

$page = $_GET['page'] ?? 'login';

// If we're *not* on logout, and user *is* logged in, send them home
if ($page !== 'logout' && isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>auth</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar border-bottom" style="background: var(--surface)">
        <div class="container-fluid">
            <span class="navbar-brand fs-6 fw-bolder fst-italic">
                Gym Management System
            </span>
        </div>
    </nav>


    <div class=" container-fluid  d-flex align-items-center justify-content-center pt-2 "
        style="min-height: calc(100vh - 52px); ">

        <div class=" d-flex rounded-3 " style="height: 500px ; box-shadow: var(--shadow); background: var(--surface); ">
            <div class="d-none d-lg-block "
                style="width: 350px;  border-radius: 100% 0% 100% 0% / 0% 58% 42% 100% ; background-image: url(../images/Login.jpg); background-size: cover;  ">
                <div class="pt-5 p-3 h-100 px-3 text-white">
                    <h2 class="fs-3 fw-bolder fst-italic mb-2 py-3"
                        style="text-shadow: 1px 1px 2px red, 0 0 1em blue, 0 0 0.2em blue;">
                        <!--Here will be change title   -->
                        <?php if ($page === "login") {
                            echo "Welcome back!";
                        } elseif ($page === "signup") {
                            echo "Create new account";
                        } elseif ($page === "forgot") {
                            echo "Forget Password";
                        }
                        ?>
                    </h2>
                    <p class="fs-6">
                        <!-- Here will change description -->
                        <?php if ($page === "login") {
                            echo " Log in to access your personalized fitness Progress.
                        Track your daily workouts, monitor your progress, and stay on top of your fitness goals.
                        Create weekly workout and diet plans to stay consistent and motivated throughout your journey.";
                        } elseif ($page === "signup") {
                            echo "Create a free account to get started with your weekly workout planner. Customize your schedule, track your progress, and stay motivated—all in one place.";
                        } elseif ($page === "forgot") {
                            echo "Forgot your password? No problem! Use the password reset feature to quickly recover access to your account via email verification.";
                        }
                        ?>

                       
                    </p>

                </div>
            </div>

            <!-- Here will be loading pages for auth -->
            <div class="p-2 m-auto px-3" style="width: 350px;">

                <?php
                if ($page === 'login') {
                    include "../components/auth/login.php";
                } elseif ($page === 'signup') {
                    include "../components/auth/signup.php";
                } elseif ($page === 'forgot') {
                    include "../components/auth/forgetPassword.php";
                } elseif ($page === 'logout') {
                    include "../components/auth/logout.php";
                } else {
                    echo "<p class='text-danger'>Invalid page requested.</p>";
                }
                ?>

            </div>

        </div>
    </div>


    <script src="../bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/auth.js"> </script>
</body>

</html>