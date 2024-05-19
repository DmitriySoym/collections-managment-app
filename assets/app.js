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
    const formCreate = document.getElementById("btn-create-category");
    const createInput = document.getElementById("category_name");

    // if (formCreate && createInput) {
    //     console.log(formCreate);
    //     console.log(createInput.innerText);
    //     createInput.innerText = "";
    //     formCreate.addEventListener("click", () => {
    //         console.log(createInput);
    //         createInput.innerText = "";
    //     });
    // }

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

    // edit collection title
    const collectionEditBtn = document.querySelector(".collection__btn-edit");
    const inputCollectionTitleEdit = document.querySelector(".collection__title-edit");
    const collectionTitleValue = document.querySelector(".collection__title-value");
    const collectionDeleteBtn = document.querySelector(".collection__btn-delete");

    function toggleClassToEditCollectionTitle() {
        inputCollectionTitleEdit.classList.toggle("active");
        collectionTitleValue.classList.toggle("active");
    }

    function deleteCollection() {
        let id = location.href.split("/").slice(-1)[0];

        fetch(`/collection/remove/${id}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        }).then((response) => {
            if (response.ok) {
                console.log("Collection was deleted");
            } else {
                console.log("Collection wasn't deleted");
            }
        });
    }

    function updateCollectionTitle() {
        let id = location.href.split("/").slice(-1)[0];
        // let newTitle = inputCollectionTitleEdit.value;
        // fetch(`/collection/update/${id}`, {
        //     method: "POST",
        //     headers: {
        //         "Content-Type": "application/json",
        //     },
        //     // body: JSON.stringify({ newTitle }),
        // }).then((response) => {
        //     if (response.ok) {
        //         console.log("Collection was updated");
        //     } else {
        //         console.log("Collection wasn't updated");
        //     }
        // });
    }

    if (collectionEditBtn && inputCollectionTitleEdit && collectionTitleValue) {
        collectionEditBtn.addEventListener("click", () => {
            toggleClassToEditCollectionTitle();
            collectionEditBtn.setAttribute("disabled", "");
        });

        inputCollectionTitleEdit.addEventListener("blur", () => {
            toggleClassToEditCollectionTitle();
            collectionEditBtn.removeAttribute("disabled");

            updateCollectionTitle();
        });
    }

    if (collectionDeleteBtn) {
        collectionDeleteBtn.addEventListener("click", () => {
            deleteCollection();
            // location.href = "/collections";
        });
    }
});
