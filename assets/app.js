/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "bootstrap/dist/css/bootstrap.min.css";
import "./styles/awesomefonts/css/all.min.css";
import "./styles/app.css";

window.onload = function () {
    document.body.classList.add("loaded_hiding");
    window.setTimeout(function () {
        document.body.classList.add("loaded");
        document.body.classList.remove("loaded_hiding");
    }, 500);
};

document.addEventListener("DOMContentLoaded", () => {
    let pageNumbers = document.querySelectorAll(".page-item");
    const activePage = location.href.split("/").slice(-1)[0];

    for (const item of pageNumbers) {
        if (item.innerText == activePage) {
            item.classList.add("activepage");
        }
        if (activePage == "collections") {
            pageNumbers[0].classList.add("activepage");
        }
    }

    // user management
    function selectAllUsers() {
        const checkboxes = document.querySelectorAll('input[name="selectedUser"]');

        checkboxes.forEach((checkbox) => (checkbox.checked = document.getElementById("select-all").checked));
    }

    const signedInUser = document.querySelector(".active-user");
    const selectAllUsersCheckbox = document.getElementById("select-all");

    if (selectAllUsersCheckbox) {
        selectAllUsersCheckbox.addEventListener("click", (e) => {
            selectAllUsers();
        });
    }

    const deleteUser = document.getElementById("delete-user");
    if (deleteUser) {
        deleteUser.addEventListener("click", (e) => {
            updateUserStatus("deleted");
        });
    }

    const makeUserAdmin = document.getElementById("make-user-admin");
    if (makeUserAdmin) {
        makeUserAdmin.addEventListener("click", (e) => {
            updateUserStatus("make-admin");
        });
    }

    const makeNotUserAdmin = document.getElementById("make-user-notadmin");
    if (makeNotUserAdmin) {
        makeNotUserAdmin.addEventListener("click", (e) => {
            updateUserStatus("make-user-notadmin");
        });
    }

    const blockeUser = document.getElementById("block-user");
    if (blockeUser) {
        blockeUser.addEventListener("click", (e) => {
            updateUserStatus("block");
        });
    }

    const unBlockeUser = document.getElementById("unblock-user");
    if (unBlockeUser) {
        unBlockeUser.addEventListener("click", (e) => {
            updateUserStatus("unblock");
        });
    }

    function updateUserStatus(userStatus) {
        const selectedIds = Array.from(document.querySelectorAll(".user-checkbox:checked")).map((item) => item.value);

        fetch("/user/managment/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ ids: selectedIds, status: userStatus }),
        }).then((response) => {
            if (response.ok) {
                window.location.reload();
                if (selectedIds.includes(signedInUser.dataset.isAutheuser)) {
                    window.location.href = "/logout";
                }
            } else {
                alert("Error update");
            }
        });
    }
});
