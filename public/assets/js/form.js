const pwShowHide = document.querySelectorAll(".showHidePw");

pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        const pwField = eyeIcon.previousElementSibling;

        if (pwField.type === "password") {
            pwField.type = "text";
            eyeIcon.classList.replace("uil-eye-slash", "uil-eye");
        } else {
            pwField.type = "password";
            eyeIcon.classList.replace("uil-eye", "uil-eye-slash");
        }
    });
});
