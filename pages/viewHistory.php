<!-- header -->
<?php
include("../layout/header.php");


$checkingHistoryDays = $_POST['selectedDays'] ?? '7';

// this is come from header
$dateObj = new DateTime($today_date);
$dateObj->modify('-' . $checkingHistoryDays . ' days');

// this new we will show data
$newDate = $dateObj->format('Y-m-d');

$stmt = $conn->prepare("SELECT workout, workout_status, diet, diet_status, weight, calories, time_stamp 
      FROM daily_task 
      WHERE user_id = ? AND time_stamp >= ? 
      ORDER BY time_stamp DESC
  ");

$stmt->bind_param("is", $userid, $newDate);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();



?>

<div class="overflow-y-auto" style="
    min-height: calc(100vh - 177px); 
    max-height: calc(100vh - 177px); 
    width: 96%;
    margin: auto;
">

  <div class="history-header d-flex justify-content-between py-3">
    <h2 class="fw-bolder fst-italic">Daily workout History</h2>
    <?php if (isset($result) && $result->num_rows > 0): ?>
      <div>
        <form method="post" id="history-checking-days-form">
          <select class="input input-focus" id="select-days" name="selectedDays">
            <option value="7" <?= $checkingHistoryDays == "7" ? "selected" : "" ?>>7 days</option>
            <option value="14" <?= $checkingHistoryDays == "14" ? "selected" : "" ?>>14 days</option>
            <option value="30" <?= $checkingHistoryDays == "30" ? "selected" : "" ?>>1 month</option>
            <option value="60" <?= $checkingHistoryDays == "60" ? "selected" : "" ?>>2 months</option>
            <option value="90" <?= $checkingHistoryDays == "90" ? "selected" : "" ?>>3 months</option>
          </select>
        </form>
      </div>
    <?php endif ?>

  </div>
  <?php if (isset($result) && $result->num_rows > 0): ?>

    <table class="table table-striped rounded-2 bg-danger">
      <thead style="background-color: var(--surface);">
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Workout</th>
          <th scope="col">Diet</th>
          <th scope="col">Weight</th>
          <th scope="col">Calories</th>
          <th scope="col">Workout Status</th>
          <th scope="col">Diet Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php

            // show limited char workout and diet 
            $workout = substr($row['workout'] ? $row['workout'] : "-----", 0, 31);
            $diet = substr($row['diet'] ? $row['diet'] : "-----", 0, 31);

            $displayWorkout = strlen($workout) > 30 ? $workout . "..." : $workout;
            $displayDiet = strlen($diet) > 30 ? $diet . "..." : $diet;

            ?>
            <tr>
              <!-- Date, workout, diet, weight, calories -->
              <td><?= htmlspecialchars($row['time_stamp']) ?></td>
              <td><?= htmlspecialchars($displayWorkout) ?></td>
              <td><?= htmlspecialchars($displayDiet) ?></td>
              <td><?= $row['weight'] !== '' ? htmlspecialchars($row['weight']) : "----" ?></td>
              <td><?= $row['calories'] !== '' ? htmlspecialchars($row['calories']) : "----" ?></td>

              <!-- workout status -->
              <td>
                <?php if ($row['workout_status'] === "true"): ?>
                  <span class="badge" style="background-color:var(--success)">Completed</span>
                <?php elseif ($row['workout_status'] === "false"): ?>
                  <span class="badge" style="background-color:var(--error)">Uncompleted</span>
                <?php else: ?>
                  <span class=""> ----- </span>
                <?php endif; ?>
              </td>

              <!-- diet status -->

              <td>
                <?php if ($row['diet_status'] === "true"): ?>
                  <span class="badge" style="background-color:var(--success)">Completed</span>
                <?php elseif ($row['diet_status'] === "false"): ?>
                  <span class="badge" style="background-color:var(--error)">Uncompleted</span>
                <?php else: ?>
                  <span class=""> ----- </span>
                <?php endif; ?>
              </td>

            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  <?php else: ?>
    <h2 class="fw-bolder fst-italic text-center py-3"> No history !</h2>
  <?php endif ?>
</div>

<?php

include("../layout/footer.php");
?>