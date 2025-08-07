<?php require_once './views/auth/auth.header.php'; ?>
<main class="form-signin w-100 m-auto">
    <form action="<?= URL_BASE ?>?controller=auth/register&action=registerProcess" method="POST">
        <img class="mb-1" src="<?= URL_BASE ?>/assets/img/cohete.svg" alt="" width="116">
        <h1 class="h3 mb-3 fw-normal">Please sign up</h1>
        <div class="form-floating">
            <input type="text" class="form-control" name="name" id="floatingInput" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" placeholder="John Doe">
            <label for="floatingInput">Name</label>
        </div>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <select name="membership_id" class="form-select my-3" required>
            <option value="0" selected disabled>Select a membership</option>
            <option value="1">Basic ($49)</option>
            <option value="2">Premium ($99)</option>
        </select>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign up</button>
        <a href="<?= URL_BASE ?>?controller=auth/login&action=login">Do you have an account? Sign in now.</a>
        <p class="mt-5 mb-3 text-body-secondary">© Erickdeps - 2025</p>
    </form>
</main>
<?php require_once './views/auth/auth.footer.php'; ?>