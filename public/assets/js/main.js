const arrow = document.querySelectorAll(".arrow");

for (let i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        const subMenu = e.target.closest("li").querySelector(".sub-menu");
        if (subMenu) {
            subMenu.classList.toggle("showMenu");
        }
    });
}

let sidebar = document.querySelector(".home-section");
let sidebarBtn = document.querySelector(".bx-menu");

sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

const togglePasswordIcons = document.querySelectorAll('.toggle-password-icon');

togglePasswordIcons.forEach(icon => {
    icon.addEventListener('click', function () {
        const targetId = icon.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});