<?php

// Checking last entry for daily workout 
$stmt = $conn->prepare("SELECT workout, workout_status, diet, diet_status, weight, calories, time_stamp FROM daily_task WHERE user_id = ? ORDER BY time_stamp DESC");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$latestDailyTask = $result->fetch_assoc();
$stmt->close();

$latestWorkout = $latestDailyTask["workout"] ?? "";
$latestDiet = $latestDailyTask["diet"] ?? "";
$latestWeight = $latestDailyTask['weight'] ?? "";
$latestCalories = $latestDailyTask['calories'] ?? "";
$latestDate = $latestDailyTask['time_stamp'] ?? "";




// This is data for today daily task  
$todayData = $latestDate === $today_date;
if ($todayData) {
    $todayWorkout = $latestDailyTask["workout"] ?? "";
    $todayDiet = $latestDailyTask["diet"] ?? "";
    $todayWeight = $latestDailyTask['weight'] ?? "";
    $todayCalories = $latestDailyTask['calories'] ?? "";
    $todayWorkoutStatus = $latestDailyTask["workout_status"] ?? "";
    $todayDietStatus = $latestDailyTask["diet_status"] ?? "";
}

// Handle form today goal submission
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_daily_goal"])) {
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $workout = $_POST["today-workout"] ?? '';
    $diet = $_POST['today-diet'] ?? '';
    $workout_status = isset($_POST["workout-status"]) ? 'true' : 'false';
    $diet_status = isset($_POST["diet-status"]) ? 'true' : 'false';
    $weight = $_POST['today-weight'] ?? '';
    $calories = $_POST['today-calories'] ?? '';

    // check if the there no workout or diet then enter blank value
    $workout_status = $workout ? $workout_status : '';
    $diet_status = $diet ? $diet_status : '';


    // Only insert if today is not update
    if (!$todayData) {
        $stmt = $conn->prepare("INSERT INTO daily_task (user_id, workout, workout_status, diet, diet_status, weight, calories, time_stamp) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "isssssis",
            $userid,
            $workout,
            $workout_status,
            $diet,
            $diet_status,
            $weight,
            $calories,
            $today_date
        );

        if ($stmt->execute()) {
            setToast("Success", "Today's workout and diet completed successfully.", "success");
            header("location: index.php");
            exit;
        } else {
            setToast("Error", "Failed to save data.", "error");
            exit;
        }
    } else {
        setToast("Warning", "You've already submitted today's task.", "warning");
    }
}

function updateDailyTask()
{
    global $todayWorkout, $todayDiet, $todayWeight, $todayCalories, $todayWorkoutStatus, $todayDietStatus, $latestWeight, $latestCalories, $todayData, $today;


    // show the update today section 
    $workoutDisplay = $todayWorkout ? htmlspecialchars($todayWorkout) : "No workouts for today";
    $dietDisplay = $todayDiet ? htmlspecialchars($todayDiet) : "No diet for today";

    $workoutStatusHtml = '';
    if ($todayWorkout) {
        $workoutStatusHtml .= '<input type="hidden" name="today-workout"  value="' . htmlspecialchars($todayWorkout) . '">';
        if ($todayWorkoutStatus === 'true') {
            $workoutStatusHtml .= '<span class="badge" style="background: var(--success);">Completed</span>';
        } elseif ($todayWorkoutStatus === 'false') {
            $workoutStatusHtml .= '<span class="badge" style="background: var(--error);">Uncompleted</span>';
        } else {
            $workoutStatusHtml .= '<input type="checkbox" class="form-check-input" name="workout-status" value="true" title="Mark workout as done" />';
        }
    }

    $dietStatusHtml = '';
    if ($todayDiet) {
        $dietStatusHtml .= '<input type="hidden" name="today-diet" value="' . htmlspecialchars($todayDiet) . '">';
        if ($todayDietStatus === 'true') {
            $dietStatusHtml .= '<span class="badge" style="background: var(--success);">Completed</span>';
        } elseif ($todayDietStatus === 'false') {
            $dietStatusHtml .= '<span class="badge" style="background: var(--error);">Uncompleted</span>';
        } else {
            $dietStatusHtml .= '<input type="checkbox" name="diet-status" class="form-check-input" title="Mark diet as done" />';
        }
    }



    // this will disable the input filed if the user is submit for today 
    $weightDisabled = $todayWeight ? 'disabled' : '';
    $caloriesDisabled = $todayCalories ? 'disabled' : '';


    // the default value will be latest weight and calories and this can  be change
    $weightValue = $latestWeight ? $latestWeight : '';
    $caloriesValue = $latestCalories ? $latestCalories : '';

    $submitButton = '';

    if (!$todayData) {
        $submitButton = '
            <div class="text-center mt-4">
                <button type="submit" class="btn button" >
                <i class="fas fa-sync-alt me-2"></i>Update Today
                </button>
            </div>
        ';
    }

    return <<<HTML
<div class="container pb-5">
    <h2 class="fw-bold text-center fs-3 py-3" style="color: var(--light-text);">
        Daily task
    </h2>

    <div class="card mx-auto" style="max-width: 650px; background: var(--surface); border-radius: 9px; box-shadow: var(--shadow);">
        <div class="card-body">
            <h4 class="card-title text-center pb-1" style="color: var(--primary);">{$today}</h4>
            <form method="post" id="dailyUpdateForm">
                <div class="row g-3 py-3">
                    <!-- Workout -->
                    <div class="col-12 d-flex align-items-center justify-content-between border-bottom pb-3 mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dumbbell fa-lg me-3 text-primary"></i>
                            <div class="fw-bold fs-5" style="color: var(--text);">{$workoutDisplay}</div>
                        </div>
                        {$workoutStatusHtml}
                    </div>

                    <!-- Diet -->
                    <div class="col-12 d-flex align-items-center justify-content-between border-bottom pb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-apple-alt fa-lg me-3 text-success"></i>
                            <div class="fw-bold fs-5" style="color: var(--text);">{$dietDisplay}</div>
                        </div>
                        {$dietStatusHtml}
                    </div>

                    <!-- Weight -->
                    <div class="col-12 d-flex align-items-center border-bottom pb-2">
                        <i class="fas fa-weight-hanging fa-lg me-3 text-warning"></i>
                        <div class="flex-grow-1 d-flex align-items-center">
                            <label class="mb-0 me-2">Weight:</label>
                            <div class="input-group ms-auto" style="max-width: 200px;">
                                <input type="number" name="today-weight" class="form-control" min="0" max="200" {$weightDisabled} placeholder="70" value="{$weightValue}" />
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calories -->
                    <div class="col-12 d-flex align-items-center">
                        <i class="fas fa-fire-alt fa-lg me-3 text-danger"></i>
                        <div class="flex-grow-1 d-flex align-items-center">
                            <label class="mb-0 me-2">Calories:</label>
                            <div class="input-group ms-auto" style="max-width: 200px;">
                                <input type="number" name="today-calories" class="form-control" min="0" {$caloriesDisabled} placeholder="500" value="{$caloriesValue}" />
                                <span class="input-group-text">Cal</span>
                            </div>
                        </div>
                    </div>
                </div>

                {$submitButton}
            </form>
        </div>
    </div>
</div>
HTML;
}
?>