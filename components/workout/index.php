<?php
$todayWorkout = '';
$days = []; // Initialize to avoid undefined variable later

if (isset($_SESSION["user"]) && isset($_SESSION["userId"])) {
    $deleted = 0;

    $stmt = $conn->prepare("SELECT id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, time_stamp FROM workout_plan WHERE user_id = ? AND deleted = ?");
    $stmt->bind_param("ii", $userid, $deleted);
    $stmt->execute();
    $result = $stmt->get_result();

    ob_start(); // Start capturing HTML output

    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $monday = $row['monday'];
        $tuesday = $row['tuesday'];
        $wednesday = $row['wednesday'];
        $thursday = $row['thursday'];
        $friday = $row['friday'];
        $saturday = $row['saturday'];
        $sunday = $row['sunday'];
        $time_stamp = $row['time_stamp'];

        $days = [
            "Monday" => $monday,
            "Tuesday" => $tuesday,
            "Wednesday" => $wednesday,
            "Thursday" => $thursday,
            "Friday" => $friday,
            "Saturday" => $saturday,
            "Sunday" => $sunday
        ];

        $_SESSION["update"] = true;
        $_SESSION["workout_id"] = $id;
        ?>
        <div class="row justify-content-center text-center">
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <h2 class="fs-4 mb-0 fst-italic" style="color: var(--text);">Workout plan</h2>
            </div>

            <div class="workout-days" id="workoutDays">
                <?php
                $today = date("l");                
                foreach ($days as $day => $workoutString):
                    if (!empty($workoutString)):
                        // Convert comma-separated string to array and trim spaces
                        $workoutArray = array_map('trim', explode(',', $workoutString));
                        ?>
                        <div class="p-2 border-bottom d-flex justify-content-between rounded-2"
                            style="<?= $day == $today ? 'color:var(--light-text); background: var(--highlight)' : 'color:var(--text)' ?>">

                            <span class="fs-5"><?= htmlspecialchars($day) ?>:</span>

                            <div class="d-flex flex-wrap gap-2 ms-auto w-75" style="text-align: start;">
                                <?php foreach ($workoutArray as $workoutItem): ?>
                                    <div class="px-2 py-1 border rounded bg-light text-dark">
                                        <?= htmlspecialchars($workoutItem) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php
                        if ($day == $today)
                            $todayWorkout = $workoutString;
                    endif;
                endforeach;
                ?>


                <div class="d-flex gap-3 align-items-center justify-content-end py-2">
                    <!-- Delete Button -->
                    <button class="btn btn-danger" style="padding: 11px;" onclick="showModalDeletedWorkout(this)"
                        data-id="<?= $_SESSION['workout_id'] ?? 0 ?>" title="Delete workout">
                        <i class="fa-solid fa-trash text-white"></i>
                    </button>

                    <!-- Update Button -->
                    <button class="btn button btn-sm update-button" title="Update workout" id="btn-update-workout"
                        data-id="<?= htmlspecialchars($id) ?>" data-monday="<?= htmlspecialchars($monday) ?>"
                        data-tuesday="<?= htmlspecialchars($tuesday) ?>" data-wednesday="<?= htmlspecialchars($wednesday) ?>"
                        data-thursday="<?= htmlspecialchars($thursday) ?>" data-friday="<?= htmlspecialchars($friday) ?>"
                        data-saturday="<?= htmlspecialchars($saturday) ?>" data-sunday="<?= htmlspecialchars($sunday) ?>"
                        data-bs-toggle="modal" data-bs-target="#modal">
                        Update Plan
                    </button>
                </div>
            </div>
        </div>
        <?php
    } else {
        $_SESSION["update"] = false;
        ?>
        <div>
            <h2 class="fs-5 fw-bold text-center pt-3">Workout</h2>
            <div class="no-workout p-4 text-muted d-flex flex-column align-items-center" id="noWorkout" data-bs-toggle="modal"
                data-bs-target="#modal" style="cursor: pointer;">
                <i class="fa-solid fa-circle-plus fa-2x mb-2" style="color:var(--btn-bg)"></i>
                <p class="mb-1">No workout selected</p>
                <button class="btn button btn-sm mt-2">Add Workout</button>
            </div>
        </div>
        <?php
    }

    $WeeklyWorkout = ob_get_clean();
    $stmt->close();
}
?>