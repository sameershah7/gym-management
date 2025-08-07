// confirmation modal for deleted diet plan
function showModalDeletedDiet (button) {
  const title = document.getElementById("title");
  const body = document.getElementById("body");
  const hiddenValue = document.getElementById("hidden-value");

  hiddenValue.name = "deletedDiet_id";
  const workoutId = button.getAttribute("data-id"); 

  // Now use it
  title.innerText = "Delete Diet Plan";
  body.innerText = `Are you sure you want to delete diet plan?`;
  hiddenValue.value = workoutId;

  // Show modal
  const modal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );
  modal.show();
}


document.querySelectorAll(".diet").forEach((dietContainer) => {
  const dietView = dietContainer.querySelector(".dietView");
  const dietForm = dietContainer.querySelector(".diet-form");
  const dietBtn = dietContainer.querySelector(".diet-btn");
  const dietInput = dietContainer.querySelector(".dietInput");
  const hiddenInput = dietContainer.querySelector(".hidden-input");

  const selected = [];

  // Reusable function to sync hidden inputs with selected values
  function updateHiddenInputs() {
    // Remove existing inputs
    dietContainer
      .querySelectorAll(`input[name='${hiddenInput.name}']`)
      .forEach((el) => el.remove());

    // Add new inputs for each selected value
    selected.forEach((val) => {
      const input = document.createElement("input");
      input.type = "hidden";
      input.id = hiddenInput.id;
      input.name = hiddenInput.name;
      input.value = val;
      dietContainer.appendChild(input);
    });
  }

  // Show/hide input form when view is clicked
  dietView.addEventListener("click", () => {
    document.querySelectorAll(".diet-form").forEach((form) => {
      if (form !== dietForm) form.classList.add("d-none");
    });
    dietForm.classList.toggle("d-none");
  });

  // Add diet item on button click
  dietBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const value = dietInput.value.trim();
    if (!value || selected.includes(value)) return;

    const tag = document.createElement("span");
    tag.className =
      "badge bg-secondary me-1 d-inline-flex align-items-center gap-1 px-2";
    tag.innerText = value;

    const removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.innerHTML = "&times;";
    removeBtn.className = "btn-close btn-close-white btn-sm ms-2";
    removeBtn.style.fontSize = "0.6rem";
    removeBtn.style.opacity = "0.9";

    removeBtn.onclick = () => {
      tag.remove();
      const index = selected.indexOf(value);
      if (index !== -1) selected.splice(index, 1);
      updateHiddenInputs();

      if (selected.length === 0) {
        dietView.innerHTML =
          "<p class='text-muted m-0'>Click to enter your diet</p>";
      }
    };

    const placeholder = dietContainer.querySelector("p.text-muted");
    if (placeholder) placeholder.remove();

    selected.push(value);
    tag.appendChild(removeBtn);
    dietView.appendChild(tag);
    dietInput.value = "";

    updateHiddenInputs();
  });

  // Pre-fill data form
  function fillWorkoutModalFromData() {
    const updateWorkoutBtn = document.getElementById("btn-update-diet");
    const days = [
      "monday",
      "tuesday",
      "wednesday",
      "thursday",
      "friday",
      "saturday",
      "sunday",
    ];

    days.forEach((day) => {
      const value = updateWorkoutBtn?.getAttribute(`data-${day}`) || "";
      const input = document.getElementById(`diet-hidden-input-${day}`);

      if (value && input && input.closest(".diet") === dietContainer) {
        const valuesArray = value.split(",").map((i) => i.trim());

        valuesArray.forEach((val) => {
          if (!val || selected.includes(val)) return;

          const tag = document.createElement("span");
          tag.className =
            "badge bg-secondary me-1 d-inline-flex align-items-center gap-1 px-2";
          tag.innerText = val;

          const removeBtn = document.createElement("button");
          removeBtn.type = "button";
          removeBtn.innerHTML = "&times;";
          removeBtn.className = "btn-close btn-close-white btn-sm ms-2";
          removeBtn.style.fontSize = "0.6rem";
          removeBtn.style.opacity = "0.9";

          removeBtn.onclick = () => {
            tag.remove();
            const index = selected.indexOf(val);
            if (index !== -1) selected.splice(index, 1);
            updateHiddenInputs();

            if (selected.length === 0) {
              dietView.innerHTML =
                "<p class='text-muted m-0'>Click to enter your diet</p>";
            }
          };

          const placeholder = dietView.querySelector("p.text-muted");
          if (placeholder) placeholder.remove();

          selected.push(val);
          tag.appendChild(removeBtn);
          dietView.appendChild(tag);
        });

        updateHiddenInputs();
      }
    });
  }

  fillWorkoutModalFromData();
});
