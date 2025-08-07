<?php

$modalUpdate = $_SESSION['update'] ?? false;
$planWorkoutId = (int) ($_SESSION['workout_id'] ?? 0);

$titleText = $modalUpdate ? 'Update Workout Plan' : 'Create Workout Plan';
$buttonText = $modalUpdate ? 'Update' : 'Save';

// Define days and workout options
$days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
$workouts = ["Chest", "Back", "Legs", "Shoulders", "Triceps", "Core", "Biceps"];

// update and insert data into db
if (isset($_POST['form_type']) && $_POST["form_type"] === "workout_form") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $weeklyWorkouts = [];
        foreach ($days as $day) {
            $weeklyWorkouts[$day] = implode(", ", $_POST[$day] ?? []);
        }
        //  Check if all days are empty we need at least one days
        $allEmpty = true;
        foreach ($weeklyWorkouts as $value) {
            if (!empty(trim($value))) {
                $allEmpty = false;
                break;
            }
        }
        if ($allEmpty) {
            setToast("Warning", "Please enter workout for at least one day.", "warning");
            header("Location: index.php");
            exit;
        }


        // Check if workout plan already exists
        $deleted = 0;
        $checkStmt = $conn->prepare("SELECT 1 FROM workout_plan WHERE id = ? AND deleted = ?");
        $checkStmt->bind_param("ii", $planWorkoutId, $deleted);
        $checkStmt->execute();
        $checkStmt->store_result();
        $exists = $checkStmt->num_rows > 0;
        $checkStmt->close();

        if ($exists) {
            // Getting exiting data from db
            $stmt = $conn->prepare("SELECT monday, tuesday, wednesday, thursday, friday, saturday, sunday FROM workout_plan WHERE id = ?");
            $stmt->bind_param("i", $planWorkoutId);
            $stmt->execute();
            $result = $stmt->get_result();
            $existsData = $result->fetch_assoc();
            $stmt->close();


            //compare current db value to new value
            $hasChanges = false;
            foreach ($weeklyWorkouts as $day => $newValue) {
                if (trim($existsData[$day]) !== trim($newValue)) {
                    $hasChanges = true;
                    break;
                }
            }
            if (!$hasChanges) {
                setToast("Warning", 'No change detected', 'warning');
                header("Location: index.php");
                exit;
            }

            // Update existing plan
            $stmt = $conn->prepare("UPDATE workout_plan SET monday = ?, tuesday = ?, wednesday = ?, thursday = ?, friday = ?, saturday = ?, sunday = ? WHERE user_id = ?");
            $stmt->bind_param(
                "sssssssi",
                $weeklyWorkouts["monday"],
                $weeklyWorkouts["tuesday"],
                $weeklyWorkouts["wednesday"],
                $weeklyWorkouts["thursday"],
                $weeklyWorkouts["friday"],
                $weeklyWorkouts["saturday"],
                $weeklyWorkouts["sunday"],
                $userid
            );
            if ($stmt->execute()) {
                setToast("Success", "Workout updated successfully. ", "success");
                header("location: index.php");
                exit;
            } else {
                setToast("Error", "Internal server error ", "error");
            }

            $stmt->close();
            exit();
        } else {
            // Insert new workout plan
            $stmt = $conn->prepare("INSERT INTO workout_plan (user_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "isssssss",
                $userid,
                $weeklyWorkouts["monday"],
                $weeklyWorkouts["tuesday"],
                $weeklyWorkouts["wednesday"],
                $weeklyWorkouts["thursday"],
                $weeklyWorkouts["friday"],
                $weeklyWorkouts["saturday"],
                $weeklyWorkouts["sunday"]
            );
        }

        if ($stmt->execute()) {
            setToast("Success", "Workout added successfully. ", "success");
            header("location: index.php");
            exit;
        } else {
            setToast("Error", "Internal server error ", "error");
        }

        $stmt->close();
        exit();
    }
}
// make it false deleted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletedWorkout_id'])) {
    $id = (int) $_POST['deletedWorkout_id'];

    $stmt = $conn->prepare("UPDATE workout_plan SET deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        setToast("Success", "Workout deleted successfully ", "success");
        header("location: index.php");
        exit;
    } else {
        setToast("Error", "Internal server error", "error");
    }
    $stmt->close();
}

// Dropdown Renderer
function renderWorkoutDropdown($dayId, $workouts)
{
    $html = '
        <div class="mb-3 d-flex border-bottom align-items-center pb-3" id="workout-select-option">
            <strong style="color: var(--text);">' . ucfirst($dayId) . '</strong>                                
            <select class="predefine-option" style="display: none;" name="' . $dayId . '[]" id="' . $dayId . '" multiple>';
    foreach ($workouts as $workout) {
        $html .= '<option>' . htmlspecialchars($workout) . '</option>';
    }
    $html .= '</select>

            <!-- Custom Styled Dropdown UI -->
            <div class="position-relative w-50 ms-auto custom-dropdown" data-day="' . $dayId . '"> 
            <input type="hidden" name="workout"/>
                <div class="click-input-dropdown border rounded-2 p-1 d-flex gap-2" id="input-dropdown-btn-' . $dayId . '">
                    <div class="select-item-container d-flex flex-wrap gap-2 selected-items" style="min-height: 34px; align-items: center;"></div>
                    <div class="ms-auto d-flex gap-2 align-items-center px-2">
                        <i class="clear-all fa-solid fa-xmark d-none" style="color:var(--btn-bg); cursor: pointer"></i>
                        <span class="input-dropdown-icon" id="close-dropdown-icon-' . $dayId . '">
                            <i class="fa-solid fa-chevron-down" style="color:var(--btn-bg); cursor: pointer"></i>
                        </span>
                    </div>
                </div>
                <div class="dropdown-items border p-2" id="dropdown-list-' . $dayId . '"></div>                               
            </div>
        </div>';

    return $html;
}

?>

<div class="modal fade modal-lg" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content overflow-y-auto" style="background: var(--surface);">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal"><?= htmlspecialchars($titleText) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post">
                <input type="hidden" name="form_type" value="workout_form">
                <div class="modal-body">
                    <?php foreach ($days as $day): ?>
                        <?= renderWorkoutDropdown($day, $workouts) ?>
                    <?php endforeach; ?>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn button"
                        id="submitWorkoutPlan"><?= htmlspecialchars($buttonText) ?></button>
                </div>
            </form>
        </div>
    </div>
</div>