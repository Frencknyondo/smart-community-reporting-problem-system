(function () {
    const storageKey = 'scprs-theme';
    const root = document.documentElement;
    const normalizeTheme = (value) => value === 'dark' ? 'dark' : 'light';

    const getStoredTheme = () => {
        try {
            return localStorage.getItem(storageKey);
        } catch (error) {
            return null;
        }
    };

    const setStoredTheme = (theme) => {
        try {
            localStorage.setItem(storageKey, theme);
        } catch (error) {}
    };

    const setThemeCookie = (theme) => {
        document.cookie = `scprs_theme=${theme}; path=/; max-age=31536000; SameSite=Lax`;
    };

    const syncButtons = (theme) => {
        document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
            button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
            button.setAttribute('title', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        });
    };

    const applyTheme = (theme) => {
        const nextTheme = normalizeTheme(theme);
        root.dataset.theme = nextTheme;
        setStoredTheme(nextTheme);
        setThemeCookie(nextTheme);
        syncButtons(nextTheme);
        return nextTheme;
    };

    const saveTheme = async (button, theme) => {
        const endpoint = button.dataset.themeEndpoint;
        if (!endpoint) return;

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) return;

        try {
            await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ theme }),
            });
        } catch (error) {}
    };

    const initialTheme = normalizeTheme(root.dataset.themeScope === 'profile' ? root.dataset.theme : (getStoredTheme() || root.dataset.theme));
    applyTheme(initialTheme);

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-theme-toggle]');
        if (!button) return;

        event.preventDefault();
        const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        applyTheme(nextTheme);
        saveTheme(button, nextTheme);
    });

    document.addEventListener('DOMContentLoaded', function () {
        syncButtons(normalizeTheme(root.dataset.theme));
    });
})();
