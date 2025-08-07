<?php require_once './views/Dashboard/dashboard.header.php'; ?>
<h2 class="wecolme__title">Welcome <?= htmlspecialchars($user_name) ?>, your membership is <?= htmlspecialchars(strtolower($membership['name'])); ?> !</h2>
<a href="<?= URL_BASE; ?>?controller=dashboard/dashboard&action=logout" class="btn btn-primary logout__link mt-3">
    Logout
    <img src="<?= URL_BASE ?>assets/img/logout-icon.svg" alt="logout-icon">
</a>

<?php require_once './views/Dashboard/dashboard.footer.php'; ?>