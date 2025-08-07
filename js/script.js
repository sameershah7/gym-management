// get properties
const root = document.documentElement;
const property = getComputedStyle(root);
//define color variable
const successColor = property.getPropertyValue("--success");
const errorColor = property.getPropertyValue("--error");

// This will show modal
function addWorkout() {
  document.getElementById("noWorkout").classList.add("d-none");
  document.getElementById("workoutDays").classList.remove("d-none");
}

//Toast
const toastEl = document.getElementById("customToast");
const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
toast.show();
toastEl.addEventListener("hidden.bs.toast", function () {
  toastEl.remove();
});

// logoutConformation
function logoutConfirmation() {
  const title = document.getElementById("title");
  const body = document.getElementById("body");
  const hiddenValue = document.getElementById("hidden-value");
  const btnContent = document.getElementById("conformation-btn");

  hiddenValue.name = "logout-true";
  // Now use it
  title.innerText = "Logout";
  body.innerText = `Logged out from this device?`;
  btnContent.innerText = "Logout";

  // Show modal
  const modal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );
  modal.show();
}
