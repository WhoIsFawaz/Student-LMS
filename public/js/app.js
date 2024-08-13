function getTheme() {
    return (
        localStorage.getItem("bsTheme") ||
        document.documentElement.getAttribute("data-bs-theme")
    );
}

let updateTheme = function() {
    console.log("Theme updated!");
};
