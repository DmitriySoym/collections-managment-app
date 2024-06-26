document.addEventListener("DOMContentLoaded", () => {
    const lightThemBtn = document.querySelector("#light-theme-button");
    const darkThemBtn = document.querySelector("#dark-theme-button");

    function setColorTheme(theme) {
        console.log(theme);
        document.body.setAttribute("data-bs-theme", theme);
        localStorage.setItem("theme", theme);
    }

    lightThemBtn.addEventListener("click", (e) => {
        e.preventDefault();
        setColorTheme("light");
    });

    darkThemBtn.addEventListener("click", (e) => {
        e.preventDefault();
        setColorTheme("dark");
    });
});
