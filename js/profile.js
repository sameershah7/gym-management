// const root = document.getElementById('root')

// console.log(root);

const newUsernameInput = document.getElementById("username");
const userUploadBtn = document.getElementById("username_save_btn");
const usernameFeedback = document.getElementById("username-feedback");

// Toggle editable option for username
function toggleUsernameEdit() {
  const input = document.getElementById("username");
  const saveBtn = document.getElementById("username_save_btn");

  input.disabled = !input.disabled;
  saveBtn.classList.toggle("d-none");

  if (!input.disabled) {
    input.focus();

    // Move cursor to the end
    const length = input.value.length;
    input.setSelectionRange(length, length);
  }
}

if (newUsernameInput) {
  newUsernameInput.addEventListener("input", (e) => {
    const newUsername = e.target.value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../components/profile/updateProfile.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const res = JSON.parse(xhr.responseText);

        newUsernameInput.classList.remove("input-valid", "username-invalid");
        usernameFeedback.innerText = '';
        
        if (res.status === "error") {
          newUsernameInput.classList.add("username-invalid");
          userUploadBtn.disabled  = true;
          usernameFeedback.innerText = res.message;
          usernameFeedback.style.color = errorColor;
          
        } else if (res.status === "success") {
          newUsernameInput.classList.add("input-valid");
          userUploadBtn.disabled = false;
          usernameFeedback.innerText = res.message;
          usernameFeedback.style.color = successColor;
        }
      }
    };

    xhr.send("newUsername=" + encodeURIComponent(newUsername));
  });
}

// toggle password inputs
function togglePasswordEdit() {
  const form = document.getElementById("password_form");
  form.classList.toggle("d-none");
}
