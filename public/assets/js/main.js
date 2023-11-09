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

function filterJenisOptions() {
    var selectedCategoryId = document.getElementById('category').value;
    var jenisDropdown = document.getElementById('jenis');
    var options = jenisDropdown.getElementsByTagName('option');

    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        var dataCategory = option.getAttribute('data-category');

        if (selectedCategoryId === '') {
            option.style.display = 'none';
        } else if (dataCategory === selectedCategoryId) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    }

    jenisDropdown.disabled = selectedCategoryId === '';

    jenisDropdown.selectedIndex = 0;
}

document.addEventListener("DOMContentLoaded", function() {
    var menuToggles = document.querySelectorAll(".menu-toggle");

    menuToggles.forEach(function(toggle) {
        toggle.addEventListener("click", function(event) {
            event.preventDefault();
            var dataId = toggle.getAttribute('data-id');
            var menu = document.getElementById("menu-" + dataId);

            if (menu) {
                menu.style.display = (menu.style.display === "block" ? "none" : "block");
            }
        });
    });
});

function copyToClipboard(inputId) {
    var inputField = document.getElementById(inputId);
    inputField.select();
    document.execCommand("copy");
    inputField.setSelectionRange(0, 0);

    var copySuccessMessage = document.getElementById("copy-success-message");
    copySuccessMessage.style.display = "block";

    setTimeout(function() {
        copySuccessMessage.style.display = "none";
    }, 2000);
}