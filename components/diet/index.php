<?php
$todayDiet = '';
$dietDays = [];

if (isset($_SESSION["user"]) && isset($_SESSION["userId"])) {
    $deleted = 0;

    // Get latest diet_plan entry for this week
    $stmt = $conn->prepare("SELECT id, monday, tuesday, wednesday, thursday, friday, saturday, sunday FROM diet_plan WHERE user_id = ?  AND deleted = ? ");
    $stmt->bind_param("ii", $userid, $deleted);
    $stmt->execute();
    $result = $stmt->get_result();

    ob_start(); // Capture the output

    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $monday = $row['monday'];
        $tuesday = $row['tuesday'];
        $wednesday = $row['wednesday'];
        $thursday = $row['thursday'];
        $friday = $row['friday'];
        $saturday = $row['saturday'];
        $sunday = $row['sunday'];

        $dietDays = [
            "Monday" => $monday,
            "Tuesday" => $tuesday,
            "Wednesday" => $wednesday,
            "Thursday" => $thursday,
            "Friday" => $friday,
            "Saturday" => $saturday,
            "Sunday" => $sunday
        ];


        $_SESSION["diet_update"] = true;
        $_SESSION["diet_id"] = $id;
        ?>

        <div class="row justify-content-center text-center">
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <h2 class="fs-4 mb-0 fst-italic" style="color: var(--text);">Diet Plan</h2>
            </div>

            <div class="diet-days" id="dietDays">
                <?php
                $today = date("l"); // 'Monday', 'Tuesday', etc.
                foreach ($dietDays as $day => $diet):
                    if (!empty($diet)):
                        // Convert comma-separated diet string to an array and trim spaces
                        $dietArray = array_map('trim', explode(',', $diet));
                        ?>
                        <div class="p-2 border-bottom rounded-2 d-flex justify-content-between"
                            style="<?= $day == $today ? 'color:var(--light-text); background: var(--highlight)' : 'color:var(--text); ' ?>">
                            <div class="fs-5 fw-semibold"><?= htmlspecialchars($day) ?>:</div>
                            <div class="d-flex flex-wrap gap-2  ms-auto w-75 " style="text-align: start;">
                                <?php foreach ($dietArray as $item): ?>
                                    <div class="px-2 py-1 border rounded bg-light text-dark">
                                        <?= htmlspecialchars($item) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php
                        if ($day == $today)
                            $todayDiet = $diet;
                    endif;
                endforeach;
                ?>
            </div>

            <div class="d-flex gap-3 align-items-center justify-content-end py-2">
                <!-- Delete Button -->
                <button class="btn btn-danger" style="padding: 11px;" onclick="showModalDeletedDiet(this)"
                    data-id="<?= $_SESSION['diet_id'] ?? 0 ?>" title="Delete diet plan">
                    <i class="fa-solid fa-trash text-white"></i>
                </button>

                <!-- Update Button -->
                <button class="btn button btn-sm btn-update-diet" title="Update diet" id="btn-update-diet"
                    data-id="<?= htmlspecialchars($id) ?>" data-monday="<?= htmlspecialchars($monday) ?>"
                    data-tuesday="<?= htmlspecialchars($tuesday) ?>" data-wednesday="<?= htmlspecialchars($wednesday) ?>"
                    data-thursday="<?= htmlspecialchars($thursday) ?>" data-friday="<?= htmlspecialchars($friday) ?>"
                    data-saturday="<?= htmlspecialchars($saturday) ?>" data-sunday="<?= htmlspecialchars($sunday) ?>"
                    data-bs-toggle="modal" data-bs-target="#dietModal">
                    Update diet
                </button>
            </div>
        </div>
        </div>
        <?php
    } else {
        $_SESSION["diet_update"] = false;
        ?>
        <div>
            <h2 class="fs-5 fw-bold text-center pt-3">Diet Plan</h2>
            <div class="no-diet p-4 text-muted d-flex flex-column align-items-center" id="noDiet" data-bs-toggle="modal"
                data-bs-target="#dietModal" style="cursor: pointer;">
                <i class="fa-solid fa-circle-plus fa-2x mb-2" style="color:var(--btn-bg)"></i>
                <p class="mb-1">No diet selected</p>
                <button class="btn button btn-sm mt-2">Add Diet</button>
            </div>
        </div>
        <?php
    }

    $WeeklyDiet = ob_get_clean();
    $stmt->close();
}
?>