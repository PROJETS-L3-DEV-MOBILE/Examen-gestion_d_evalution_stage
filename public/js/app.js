document.addEventListener('DOMContentLoaded', function () {

    // Validation cote client : dateDebut < dateFin
    const dateDebut = document.getElementById('dateDebut');
    const dateFin   = document.getElementById('dateFin');

    if (dateDebut && dateFin) {
        function validateDates() {
            if (dateDebut.value && dateFin.value) {
                if (dateDebut.value >= dateFin.value) {
                    dateFin.setCustomValidity('La date de fin doit etre posterieure a la date de debut.');
                } else {
                    dateFin.setCustomValidity('');
                }
            }
        }
        dateDebut.addEventListener('change', validateDates);
        dateFin.addEventListener('change', validateDates);
    }

    // Fermeture automatique des alertes flash apres 4 secondes
    const alerts = document.querySelectorAll('.alert.alert-success, .alert.alert-danger');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });

    // Validation coefficient : negatif interdit
    const coeffInput = document.getElementById('coefficient');
    if (coeffInput) {
        coeffInput.addEventListener('input', function () {
            if (parseFloat(this.value) < 0) {
                this.setCustomValidity('Le coefficient ne peut pas etre negatif.');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Animation d'entree des lignes du tableau
    document.querySelectorAll('tbody tr').forEach(function (row, i) {
        row.style.animationDelay = (i * 40) + 'ms';
        row.classList.add('row-fade-in');
    });
});
