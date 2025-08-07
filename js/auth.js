const toggleButtons = document.querySelectorAll("#toggle-password");
const inputTag = document.querySelectorAll(".input");
const userLabels = document.querySelectorAll(".user-label");

const password = document.getElementById("password");
const warningTxt = document.getElementById("warning-txt");
const confirmPassword = document.getElementById("confirmPassword");
const signupBtn = document.getElementById("signup-btn");
let signupBtnSubmit = false;

// don;t allow space with  username
const usernameInput = document.getElementById("username");
usernameInput?.addEventListener("keydown", (e) => {
  if (e.key === " ") {
    e.preventDefault();
  }
});

// Show password
toggleButtons.forEach((toggleBtn) => {
  toggleBtn.addEventListener("click", () => {
    const passwordInput = toggleBtn
      .closest(".password-wrapper")
      .querySelector("input");

    const type =
      passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    toggleBtn.innerHTML =
      type === "password"
        ? '<i class="fa-solid fa-eye"></i>'
        : '<i class="fa-solid fa-eye-slash"></i>';
  });
});

inputTag.forEach((input, index) => {
  const label = userLabels[index];

  input.addEventListener("blur", () => {
    // Check basic validity
    if (!input.checkValidity()) {
      input.classList.add("input-invalid");
      if (label) label.classList.add("text-danger");
    } else {
      input.classList.remove("input-invalid");
      if (label) label.classList.remove("text-danger");
    }

    // Handle floating label styling
    if (input.value.trim() !== "") {
      label?.classList.add("float-label");
    } else {
      label?.classList.remove("float-label");
    }
  });
});

// Password length validation with warning message
password?.addEventListener("blur", () => {
  const label = password.closest(".input-group")?.querySelector(".user-label");

  // Check if warning already exists to avoid duplicates
  let warning = password.closest(".input-group")?.querySelector(".warning-msg");

  if (password.value.length < 8) {
    password.classList.add("input-invalid");
    label?.classList.add("text-danger");
    warningTxt?.classList.add("text-danger");
    signupBtnSubmit = false;
  } else {
    password.classList.remove("input-invalid");
    label?.classList.remove("text-danger");
    warningTxt?.classList.remove("text-danger");
  }
});

// Confirm password check only when it loses focus (blur)
confirmPassword?.addEventListener("blur", () => {
  const label = confirmPassword
    .closest(".input-group")
    ?.querySelector(".user-label");

  if (confirmPassword.value.trim() === "") {
    confirmPassword.classList.add("input-invalid");
    label?.classList.add("text-danger");
  } else if (password.value !== confirmPassword.value) {
    confirmPassword.classList.add("input-invalid");
    label?.classList.add("text-danger");
  } else {
    confirmPassword.classList.remove("input-invalid");
    label?.classList.remove("text-danger");
    signupBtnSubmit = true;
  }
});

// //  if the form invalid to preventing submit
// signupBtn.addEventListener("click", (e) => {
//   if (!signupBtnSubmit) {
//     e.preventDefault();
//   }
// });
