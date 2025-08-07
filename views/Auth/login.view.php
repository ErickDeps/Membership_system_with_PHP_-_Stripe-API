<?php require_once './views/auth/auth.header.php'; ?>
<main class="form-signin w-100 m-auto">
    <form action="<?= URL_BASE; ?>?controller=auth/login&action=loginPost" method="POST">
        <img class="mb-1" src="<?= URL_BASE ?>/assets/img/cohete.svg" alt="" width="116">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        <a href="<?= URL_BASE ?>?controller=auth/register&action=register">Create an account</a>
        <p class="mt-5 mb-3 text-body-secondary">© Erickdeps - 2025</p>
    </form>
</main>
<?php require_once './views/auth/auth.footer.php'; ?>