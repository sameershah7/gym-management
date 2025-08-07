
const selectDays = document.getElementById("select-days");
if (selectDays) {
  selectDays.addEventListener("change", () => {
    document.getElementById("history-checking-days-form").submit();
  });
}
