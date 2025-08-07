// This will show modal
function addWorkout() {
  document.getElementById("noWorkout").classList.add("d-none");
  document.getElementById("workoutDays").classList.remove("d-none");
}

// confirmation modal for deleting workout
function showModalDeletedWorkout(button) {
  const title = document.getElementById("title");
  const body = document.getElementById("body");
  const hiddenValue = document.getElementById("hidden-value");

  hiddenValue.name = "deletedWorkout_id";
  const workoutId = button.getAttribute("data-id"); 

  // Now use it
  title.innerText = "Delete Workout Plan";
  body.innerText = `Are you sure you want to delete workout plan?`;
  hiddenValue.value = workoutId;

  // Show modal
  const modal = new bootstrap.Modal(
    document.getElementById("deleteConfirmModal")
  );
  modal.show();
}

// Toggle dropdown visibility
let currentlyOpenDropdown = null;
document
  .querySelectorAll("#workout-select-option")
  .forEach((dropdownWrapper) => {
    const clickInputDropdown = dropdownWrapper.querySelector(
      ".click-input-dropdown"
    );
    const dropdownItems = dropdownWrapper.querySelector(".dropdown-items");
    const InputDropdownIcon = dropdownWrapper.querySelector(
      ".input-dropdown-icon"
    );
    const predefineOption = dropdownWrapper.querySelector(".predefine-option");
    const selectedItemsContainer = dropdownWrapper.querySelector(
      ".select-item-container"
    );
    const clearAllBtn = dropdownWrapper.querySelector(".clear-all");

    const openDropdown = () => {
      if (currentlyOpenDropdown && currentlyOpenDropdown !== dropdownItems) {
        currentlyOpenDropdown.classList.remove("show");
      }
      dropdownItems.classList.add("show");
      InputDropdownIcon.style.rotate = "180deg";
      currentlyOpenDropdown = dropdownItems;
    };
    const closeDropdown = () => {
      dropdownItems.classList.remove("show");
      InputDropdownIcon.style.rotate = "0deg";
      if (currentlyOpenDropdown === dropdownItems) {
        currentlyOpenDropdown = null;
      }
    };

    clickInputDropdown.addEventListener("click", (e) => {
      e.stopPropagation(); // prevent bubbling to document
      // If this dropdown is already open, close it
      if (dropdownItems.classList.contains("show")) {
        dropdownItems.classList.remove("show");
        InputDropdownIcon.style.rotate = "0deg";
        currentlyOpenDropdown = null;
      } else {
        // Close any other open dropdown first
        if (currentlyOpenDropdown && currentlyOpenDropdown !== dropdownItems) {
          currentlyOpenDropdown.classList.remove("show");
          currentlyOpenDropdown.parentElement.querySelector(
            ".input-dropdown-icon"
          ).style.rotate = "0deg";
        }

        // Open this one
        dropdownItems.classList.add("show");
        InputDropdownIcon.style.rotate = "180deg";
        currentlyOpenDropdown = dropdownItems;
      }
    });

    // Click chevron icon to toggle dropdown
    InputDropdownIcon.addEventListener("click", (e) => {
      e.stopPropagation();
      currentlyOpenDropdown ? closeDropdown() : openDropdown();
      InputDropdownIcon.style.rotate = currentlyOpenDropdown
        ? "180deg"
        : "0deg";
    });

    // Click outside to close dropdown
    document.addEventListener("click", (e) => {
      if (!e.target.closest(".custom-dropdown")) {
        closeDropdown();
      }
    });

    // Generate dropdown items from <select>
    function renderDropdownOptions() {
      dropdownItems.innerHTML = "";
      Array.from(predefineOption.options).forEach((opt) => {
        const div = document.createElement("div");
        div.className = "dropdown-item d-flex align-items-center gap-2";
        if (opt.selected) div.classList.add("selected");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = opt.value;
        checkbox.name = opt.value;
        checkbox.checked = opt.selected;

        const label = document.createElement("span");
        label.textContent = opt.textContent;

        div.appendChild(checkbox);
        div.appendChild(label);

        dropdownItems.appendChild(div);

        // Handle checkbox toggle
        div.addEventListener("click", (e) => {
          e.stopPropagation();
          const isNowSelected = !opt.selected;
          opt.selected = isNowSelected;
          checkbox.checked = isNowSelected;
          updateSelectedTags();
          renderDropdownOptions();
        });
      });
    }

    // Update selected tags UI
    function updateSelectedTags() {
      selectedItemsContainer.innerHTML = "";

      const selected = Array.from(predefineOption.selectedOptions);
      if (selected.length === 0) {
        const placeholder = document.createElement("span");
        placeholder.className = "placeholder-text ";
        placeholder.textContent = "Select...";
        selectedItemsContainer.appendChild(placeholder);
        clearAllBtn.style.setProperty("display", "none", "important");

        return;
      }
      clearAllBtn.style.setProperty("display", "block", "important");

      selected.forEach((opt) => {
        const tag = document.createElement("div");
        tag.className =
          "px-2 py-1 border rounded selected-tag d-flex align-items-center";
        tag.setAttribute("data-value", opt.value);
        tag.innerHTML = `
                ${opt.textContent}
                <span class="remove-item">&times;</span>
              `;
        selectedItemsContainer.appendChild(tag);

        // Remove tag on click
        tag.querySelector(".remove-item").addEventListener("click", (e) => {
          e.stopPropagation();
          opt.selected = false;
          updateSelectedTags();
          renderDropdownOptions();
        });
      });
    }

    // Clear all selected
    clearAllBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      Array.from(predefineOption.options).forEach(
        (opt) => (opt.selected = false)
      );
      updateSelectedTags();
      renderDropdownOptions();
    });

    function fillWorkoutModalFromData() {
      const updateWorkoutBtn = document.getElementById("btn-update-workout");
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
        const select = document.getElementById(day);

        if (value && select) {
          const valuesArray = value.split(",").map((i) => i.trim());

          Array.from(select.options).forEach((option) => {
            option.selected = valuesArray.includes(option.value);
          });
        }
      });
    }

    fillWorkoutModalFromData();
    updateSelectedTags();
    renderDropdownOptions();
  });
