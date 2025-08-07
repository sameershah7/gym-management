<!-- header -->
<?php
include("../layout/header.php");
include("../components/profile/updateProfile.php");

$usernameBtnDisable = "disabled";

?>

<div style="min-height: calc(100vh - 177px);">

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Profile Settings</h3>

                        <!-- Username Section -->
                        <form method="post">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <label class="form-label mb-0">Username</label>
                                <span class="text-primary edit-btn" onclick="toggleUsernameEdit()">Edit</span>
                            </div>
                            <input type="text" class="form-control p-2 input-focus" name="new-username" id="username"
                                value="<?= htmlspecialchars($currentUserName) ?>" disabled>
                            <small id="username-feedback" class="py-1"></small>
                            <button type="submit" class="btn button w-100 mt-3 d-none" id="username_save_btn"
                                disabled>Update username</button>
                        </form>

                        <hr class="my-4">

                        <!-- Password Section -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <label class="form-label mb-0">Password</label>
                            <span class="text-primary edit-btn" onclick="togglePasswordEdit()">Change</span>
                        </div>

                        <form method="post" id="password_form" class="d-none">
                            <!-- current password -->
                            <div class="position-relative password-wrapper">
                                <input type="password" class="form-control mb-3 p-2 input-focus" name="current-password"
                                    id="current-password" placeholder="Current Password" required>

                                <span id="toggle-password"
                                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                                </span>
                            </div>

                            <!-- new password -->
                            <div class="position-relative password-wrapper">
                                <input type="password" class="form-control mb-3 p-2 input-focus" name="new-password" id="password"
                                    placeholder="New Password" required>

                                <span id="toggle-password"
                                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                                </span>
                            </div>

                            <!-- confirm password -->
                            <div class="position-relative password-wrapper">
                                <input type="password" class="form-control mb-3 p-2 input-focus" name="confirm-password"
                                    id="confirmPassword" placeholder="Confirm New Password" required>

                                <span id="toggle-password"
                                    style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa-solid fa-eye" style="color: var(--border);"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn  w-100" style="background: var(--warning);">Update
                                Password</button>

                        </form>

                        <hr class="my-4">

                        <!-- Logout and Delete Buttons
          <div class="d-flex justify-content-between">
            <form action="#" method="POST">
              <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
            <form action="#" method="POST" >
              <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
          </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- footer -->
<?Php include("../layout/footer.php") ?>