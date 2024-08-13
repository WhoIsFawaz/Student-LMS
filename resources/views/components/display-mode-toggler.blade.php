<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="darkModeSwitch" checked>
    <label class="form-check-label" for="darkModeSwitch">Dark Mode</label>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const htmlElement = document.documentElement;
    const switchElement = document.getElementById('darkModeSwitch');

    const currentTheme = localStorage.getItem('bsTheme') || 'dark';
    htmlElement.setAttribute('data-bs-theme', currentTheme);
    switchElement.checked = currentTheme === 'dark';

    switchElement.addEventListener('change', function () {
        if (this.checked) {
            htmlElement.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('bsTheme', 'dark');

        } else {
            htmlElement.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('bsTheme', 'light');
        }
        updateTheme();
    });
});
</script>