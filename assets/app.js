/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "bootstrap/dist/css/bootstrap.min.css";
import "./styles/app.css";

// import "bootstrap/dist/js/bootstrap.min.js";

// import { createApp } from "vue";
// import App from "./App.vue";

// const app = createApp(App);
// app.mount("#main-page");

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
});
