document.addEventListener('DOMContentLoaded', function () {
    const switchEl = document.getElementById('maintenanceSwitch');
    const statusEl = document.getElementById('maintenanceStatus');

    switchEl.addEventListener('change', function () {
        statusEl.textContent = this.checked ? 'Activé' : 'Désactivé';
    });

    //
    const toggle = document.getElementById('toggle-summary');
    const summary = document.getElementById('summary');

    toggle.addEventListener('change', () => {
        summary.classList.toggle('open', toggle.checked);
    });
});
