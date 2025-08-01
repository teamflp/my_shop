document.addEventListener('DOMContentLoaded', function () {
    const switchEl = document.getElementById('maintenanceSwitch');
    const statusEl = document.getElementById('maintenanceStatus');

    switchEl.addEventListener('change', function () {
        statusEl.textContent = this.checked ? 'Activé' : 'Désactivé';
    });
});
