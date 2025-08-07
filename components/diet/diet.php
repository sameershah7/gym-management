<?php
$titleText = "Diet plan";
$buttonText = "Add Diet";

$modalUpdate = $_SESSION['diet_update'] ?? false;
$dietId = (int) ($_SESSION['diet_id'] ?? 0);


$titleText = $modalUpdate ? 'Update diet Plan' : 'New diet Plan';
$buttonText = $modalUpdate ? 'Update' : 'Save';

// days
$days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
// update and insert data into db
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "diet_form") {


    $weeklyDiets = [];
    $deleted = 0;

    foreach ($days as $day) {
        $weeklyDiets[$day] = isset($_POST[$day]) ? htmlspecialchars(implode(",", $_POST[$day])) : "";
    }

    //  Check if all days are empty
    $allEmpty = true;
    foreach ($weeklyDiets as $value) {
        if (!empty(trim($value))) {
            $allEmpty = false;
            break;
        }
    }
    if ($allEmpty) {
        setToast("Warning", "Please enter diet for at least one day.", "warning");
        header("Location: index.php");
        exit;
    }



    $checkStmt = $conn->prepare("SELECT id FROM diet_plan WHERE user_id = ? AND deleted = ? ");
    $checkStmt->bind_param("ii", $userid, $deleted);
    $checkStmt->execute();
    $checkStmt->store_result();
    $exists = $checkStmt->num_rows > 0;
    $checkStmt->close();

    if ($exists) {
        //  Get existing data from DB
        $stmt = $conn->prepare("SELECT monday, tuesday, wednesday, thursday, friday, saturday, sunday FROM diet_plan WHERE id = ?");
        $stmt->bind_param("i", $dietId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingData = $result->fetch_assoc();
        $stmt->close();

        //  Compare current DB values with new input
        $hasChanges = false;
        foreach ($weeklyDiets as $day => $newValue) {
            if (trim($existingData[$day]) !== trim($newValue)) {
                $hasChanges = true;
                break;
            }
        }

        if (!$hasChanges) {
            setToast("Warning", 'No change detected', 'warning');
            header("Location: index.php");
            exit;
        }

        //  Update the diet plan
        $stmt = $conn->prepare("UPDATE diet_plan SET
        monday = ?, 
        tuesday = ?, 
        wednesday = ?, 
        thursday = ?, 
        friday = ?, 
        saturday = ?, 
        sunday = ?
        WHERE id = ?
    ");

        $stmt->bind_param(
            "sssssssi",
            $weeklyDiets["monday"],
            $weeklyDiets["tuesday"],
            $weeklyDiets["wednesday"],
            $weeklyDiets["thursday"],
            $weeklyDiets["friday"],
            $weeklyDiets["saturday"],
            $weeklyDiets["sunday"],
            $dietId
        );

        if ($stmt->execute()) {
            setToast("Success", "Diet updated successfully", "success");
            header("Location: index.php");
            exit;
        } else {
            setToast("Error", "Internal server error", "error");
        }

        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO diet_plan 
                (user_id,  monday, tuesday, wednesday, thursday, friday, saturday, sunday) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isssssss",
            $userid,
            $weeklyDiets["monday"],
            $weeklyDiets["tuesday"],
            $weeklyDiets["wednesday"],
            $weeklyDiets["thursday"],
            $weeklyDiets["friday"],
            $weeklyDiets["saturday"],
            $weeklyDiets["sunday"]
        );

        if ($stmt->execute()) {
            setToast("Success", "Diet add successfully ", "success");
            header("Location: index.php");
            exit;
        } else {
            setToast("Error", "Internal server error ", "error");
        }

        $stmt->close();
    }


}

// make it false deleted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletedDiet_id'])) {
    $id = (int) $_POST['deletedDiet_id'];

    $stmt = $conn->prepare("UPDATE diet_plan SET deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        setToast("Success", "Diet deleted successfully ", "success");
        header("location: index.php");
        exit;
    } else {
        setToast("Error", "Internal server error ", "error");
    }
    $stmt->close();
}


function renderDiet($day)
{
    $capitalizedDay = ucfirst($day);
    return '
    <div class="diet w-100 d-flex align-items-center justify-content-between my-3 p-2 border-bottom">
        <strong>' . $capitalizedDay . '</strong>
        <div class="w-50">
            <!-- store values-->
            <input class="hidden-input" type="hidden" name="' . $day . '[]" id="diet-hidden-input-' . $day . '"/>
            <div id="dietView-' . $day . '" class="dietView p-2 border rounded-2 d-flex flex-wrap gap-1 mb-2" style="min-height: 36px;">
                <p class="text-muted m-0">Click to enter your diet</p>
            </div>
            <div class="diet-form d-flex gap-2 border rounded-2 p-1 d-none" id="diet-input-trigger-' . $day . '">
                <input 
                    type="text" 
                    class="dietInput border-0 w-100 px-2" 
                    id="dietInput-' . $day . '" 
                    placeholder="Enter your diet" />
                <button class="btn button diet-btn" type="button" id="diet-btn-' . $day . '">Enter</button>
            </div>
        </div>
    </div>';
}
?>

<!-- Modal -->
<div class="modal fade modal-lg" id="dietModal" tabindex="-1" aria-labelledby="dietModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content overflow-y-auto" style="background: var(--surface);">
            <div class="modal-header">
                <h1 class="modal-title fs-5"><?= htmlspecialchars($titleText) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post">
                <input type="hidden" name="form_type" value="diet_form">
                <div class="modal-body">
                    <?php
                    foreach ($days as $day) {
                        echo renderDiet($day);
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn button" id="submitDietPlan">
                        <?= htmlspecialchars($buttonText) ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
?>