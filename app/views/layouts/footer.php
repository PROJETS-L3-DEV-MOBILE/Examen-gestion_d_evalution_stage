
</main>

<!-- Pied de page -->
<footer class="footer bg-light border-top mt-auto py-3">
    <div class="container-fluid text-center text-muted small">
        Gestion des Evaluations de Stage &mdash; Projet MVC PHP &mdash; <?= date('Y') ?>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/public/js/dropdown-menu.js"></script>
<script src="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/public/js/app.js"></script>
</body>
</html>
