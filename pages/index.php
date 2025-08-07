<?php
//layout header
include("../layout/header.php");

// render components for index pages

include("../database/db_connect.php");
include("../components/workout/index.php");
include("../components/diet/index.php");

include("../components/workout/workout.php");
include("../components/diet/diet.php");
include("../components/auth/logout.php");
include("../components/dailyTask/dailyTask.php");
?>

<!-- hero section -->
<section class="hero-section d-flex align-items-center p-lg-4">
    <div class=" container-fluid  py-lg-3 p-4 p-lg-3  row ">
        <div class="fst-italic col-lg-5 ">
            <h2 class="fw-bolder fst-italic fs-1" style="color: var(--primary);font-size:3rem">Your Progress
            </h2>
            <p style="color: var(--text); width: 100%; max-width: 500px; font-size:1rem; ">
                Stay motivated by tracking every milestone.
                From daily workouts to long‑term goals, see how far you’ve come and discover what’s next on your
                fitness journey.
            </p>


            <a href="viewHistory.php" class="btn button my-lg-3">View Complete History</a>

            <div class="mt-4  d-sm-flex pb-3 ">
                <div class="rounded-1 p-2 my-2 text-center border"
                    style="width: 200px; background: var(--surface); color: var(--text); box-shadow: var(--shadow);">
                    Weight
                    <h2 class="fw-bold fs-5 "><?= $latestWeight ?? "0" ?> kg</h2>
                </div>
                <div class="rounded-1 p-2 my-2 mx-sm-3 text-center border "
                    style="width: 200px; background: var(--surface); color:var(--text); box-shadow: var(--shadow);">
                    Calories
                    <h2 class="fw-bold fs-5 "><?= $latestCalories ?? "0" ?> cal</h2>
                </div>
            </div>

        </div>
        <div class="d-none d-lg-block col-lg-5 ms-auto"
            style="background-image: url(../images/heroSection.jpg); background-size: cover; border-radius: 48% 25% 36% 6% / 50% 35% 38% 5%;">
        </div>
    </div>

</section>

<!-- Update Daily Workout & Diet -->
<section class="p-4" style="background-color: var(--section);" id="daily-task">
    <?= updateDailyTask(); ?>
</section>

<!-- weekly Schedule -->
<section class="p-4 container mb-5" id="weekly-schedule">
    <h2 class="fw-bolder text-center py-3 fs-3">Weekly Schedule</h2>
    <div class="row gap-5 justify-content-between py-5">

        <!-- Workout Summary Card -->
        <div class="col-12 col-lg-5 border rounded-2 shadow-sm p-3 pb-1"
            style="color: var(--text) ;background-color: var(--surface); box-shadow: var(--shadow); height: fit-content;">
            <?= $WeeklyWorkout ?>
        </div>

        <!--  diet plan Card -->
        <div class="col-12 col-lg-5 border rounded-2 shadow-sm p-3 pb-1"
            style="color: var(--text) ;background-color: var(--surface); box-shadow: var(--shadow); height: fit-content;">
            <?= $WeeklyDiet ?>
        </div>

    </div>
</section>


<?php
// layout footer
include("../layout/footer.php") ?>