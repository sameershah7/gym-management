<?php

echo '
<form method="post">
        <h2 class="text-center p-3 fw-bolder fst-italic fs-4" style="color: var(--color);">Forget Password  </h2>
        <div class="input-group mb-3">
            <input required type="text" autocomplete="off" class="input" id="email" name="email">
            <label class="user-label">Email</label>
        </div>

        <div class="d-flex flex-column pt-3">
            <button type="submit" class="btn w-100 button">Forget password</button>


            <p class="mt-3 text-center d-flex flex-column">
                <a href="?pages=login" class="text-decoration-none">Already have account </a>
            </p>
        </div>
    </form>
    ';
?>