<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="auth-stage">
    <div class="auth-heading">
        <p class="eyebrow">Protected staff access</p>
        <h1 class="page-title"><?= esc($title) ?></h1>
        <p class="lead-statement">Enter a valid staff username and password to manage customer and user accounts.</p>
    </div>

    <form class="glass-form auth-form" method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= esc(old('username'), 'attr') ?>" maxlength="50" autocomplete="username" autofocus>
            <div class="field-error"><?= validation_show_error('username') ?></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" maxlength="255" autocomplete="current-password">
            <div class="field-error"><?= validation_show_error('password') ?></div>
        </div>

        <button class="button button-primary" type="submit">Log In</button>
    </form>
</div>
<?= $this->endSection() ?>
