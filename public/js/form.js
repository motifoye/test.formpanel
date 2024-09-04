/**
 * Изменять позицию счетчика при событиях:
 * - ввода в форму;
 * - изменения размера окна;
 * - загрузке страницы.
 */
const range = document.querySelector(".form-range.counter");

range.addEventListener("input", changePos);
window.addEventListener("resize", changePos);
window.addEventListener("load", changePos);

function calcPos() {
  const thumbSize = 16;
  const ratio = (range.value - range.min) / (range.max - range.min);
  const pos = thumbSize / 2 + range.offsetWidth * ratio - thumbSize * ratio;
  return pos;
}

function changePos() {
  const tooltip = document.querySelector("#out");
  tooltip.style.left = calcPos() + "px";
}

/**
 * Код для валидации полей формы
 * взят из документации Bootstrap
 */

var forms = document.querySelectorAll(".needs-validation");

Array.prototype.slice.call(forms).forEach(function (form) {
  form.addEventListener(
    "submit",
    function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add("was-validated");
    },
    false
  );
});

