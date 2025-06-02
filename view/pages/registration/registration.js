const forms = document.querySelector(".forms-section");
const pwShowHide = document.querySelectorAll(".eye-icon");
const links = document.querySelectorAll(".form-link a");

pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        let pwFields = eyeIcon.closest(".form-wrapper").querySelectorAll(".password");
        pwFields.forEach(password => {
            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.replace("bx-hide", "bx-show");
            } else {
                password.type = "password";
                eyeIcon.classList.replace("bx-show", "bx-hide");
            }
        });
    });
});

links.forEach(link => {
    link.addEventListener("click", (e) => {

        if (!link.classList.contains("forgot-pass")) {
            e.preventDefault();
        }

        const targetForm = link.classList.contains("signup-link") ? "signup" : "login";

        if (targetForm === "signup") {
            document.querySelector(".form-wrapper.login").classList.add("hidden");
            document.querySelector(".form-wrapper.signup").classList.remove("hidden");
        } else {
            document.querySelector(".form-wrapper.login").classList.remove("hidden");
            document.querySelector(".form-wrapper.signup").classList.add("hidden");
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("myModal");
    const btns = document.querySelectorAll(".openModalBtn");
    const span = document.querySelector(".close-button");

    btns.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            modal.style.display = "block";
        });
    });

    span.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});



$(document).ready(function () {
    $('#phone').inputmask({
        mask: '+7 (999) 999-99-99',
        placeholder: '+7 (___) ___-__-__',
        showMaskOnHover: false,
        showMaskOnFocus: true,
        onBeforePaste: function (pastedValue, opts) {
            var processedValue = pastedValue.replace(/^8/, '+7');
            return processedValue;
        }
    });
});