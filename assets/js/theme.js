function toggleTheme() {
    let current = localStorage.getItem("theme");

    if (current === "dark") {
        document.body.classList.remove("dark");
        localStorage.setItem("theme", "light");
    } else {
        document.body.classList.add("dark");
        localStorage.setItem("theme", "dark");
    }
}

// Apply theme on load
window.onload = function () {
    let saved = localStorage.getItem("theme");
    if (saved === "dark") {
        document.body.classList.add("dark");
    }
};