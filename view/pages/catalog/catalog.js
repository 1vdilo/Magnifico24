document.getElementById('toggle-filters').addEventListener('click', function () {
  const filterPanel = document.getElementById('filter-panel');

  if (filterPanel.classList.contains('hidden')) {
      filterPanel.classList.remove('hidden');
      setTimeout(() => {
          filterPanel.classList.add('visible');
      }, 10);
  } else {
      filterPanel.classList.remove('visible');
      setTimeout(() => {
          filterPanel.classList.add('hidden');
      }, 300);
  }
});

// Close filter panel when clicking outside of it
document.addEventListener('click', function (event) {
  const filterPanel = document.getElementById('filter-panel');
  const toggleFiltersButton = document.getElementById('toggle-filters');

  // Check if click was outside the filter panel and the toggle button
  const isClickInsideFilterPanel = filterPanel.contains(event.target);
  const isClickOnToggleButton = toggleFiltersButton.contains(event.target);

  if (!isClickInsideFilterPanel && !isClickOnToggleButton) {
      // If filter panel is visible, hide it
      if (!filterPanel.classList.contains('hidden')) {
          filterPanel.classList.remove('visible');
          setTimeout(() => {
              filterPanel.classList.add('hidden');
          }, 300);
      }
  }
});

// Range input and price input logic remains unchanged
const rangeInput = document.querySelectorAll(".range-input input"),
  priceInput = document.querySelectorAll(".price-input input"),
  range = document.querySelector(".slider .progress");

let priceGap = 1000;

priceInput.forEach((input) => {
  input.addEventListener("input", (e) => {
      let minPrice = parseInt(priceInput[0].value),
          maxPrice = parseInt(priceInput[1].value);

      if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
          if (e.target.className === "input-min") {
              rangeInput[0].value = minPrice;
              range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
          } else {
              rangeInput[1].value = maxPrice;
              range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
          }
      }
  });
});

rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
      let minVal = parseInt(rangeInput[0].value),
          maxVal = parseInt(rangeInput[1].value);

      if (maxVal - minVal < priceGap) {
          if (e.target.className === "range-min") {
              rangeInput[0].value = maxVal - priceGap;
          } else {
              rangeInput[1].value = minVal + priceGap;
          }
      } else {
          priceInput[0].value = minVal;
          priceInput[1].value = maxVal;
          range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
          range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
      }
  });
});
document.addEventListener("DOMContentLoaded", function () {
    const brandFilter = document.querySelectorAll(".brand-filter");
    const modelSelect = document.getElementById("car-models");
    const filterForm = document.getElementById("filter-form");

    // При изменении марки авто обновляем модели через AJAX
    brandFilter.forEach((input) => {
        input.addEventListener("change", function () {
            const brandID = this.value;
            updateModels(brandID);
        });
    });

    // Функция обновления списка моделей
    function updateModels(brandID) {
        fetch(`get_models.php?car_brandsID=${brandID}`)
            .then((response) => response.json())
            .then((data) => {
                modelSelect.innerHTML = '<option value="">Выберите модель</option>';
                data.forEach((model) => {
                    modelSelect.innerHTML += `<option value="${model.car_modelsID}">${model.title}</option>`;
                });
            })
            .catch((error) => console.error("Ошибка загрузки моделей:", error));
    }

    // При изменении модели авто автоматически отправляем форму с сохранением всех фильтров
    modelSelect.addEventListener("change", function () {
        filterForm.submit();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const backToTop = document.getElementById("back-to-top");
   
    window.addEventListener("scroll", function () {
      if (window.pageYOffset > 300) {
        backToTop.style.display = "block";
      } else {
        backToTop.style.display = "none";
      }
    });
   
    backToTop.addEventListener("click", function (event) {
      event.preventDefault();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });


document.getElementById('toggle-filter').addEventListener('click', function () {
    const panel = document.getElementById('filter-panel');
    panel.classList.toggle('visible');
});
