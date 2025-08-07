<?php


function navbar($userName)
{

    return '
        <nav class="navbar navbar-expand-lg pt-3" style="width: 95%; margin: auto;">
            <div class="container-fluid border rounded-4 p-2 px-4" style="background: var(--surface);">
                <a class="navbar-brand fs-5 fst-italic fw-medium" href="index.php">' . $userName . '</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-medium fst-italic opacity-100">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#daily-task">Today goal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href=" index.php#weekly-schedule ">Weekly Schedule</a>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Profile
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-2">
                                <li><a class="dropdown-item px-1" href="profile.php">Profile</a></li>
                                <li>
                                    <button class="dropdown-item px-1 border-0 w-100" onclick="logoutConfirmation()">Logout</button>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    ';
}
?>