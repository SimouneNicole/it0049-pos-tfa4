<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="form-stage">
    <div class="page-heading-row">
        <div>
            <h1 class="page-title"><?= esc($title) ?></h1>
            <p class="lead-statement">Create a new user account.</p>
        </div>
        <a class="button button-secondary" href="<?= site_url('users') ?>">Back to Users</a>
    </div>

    <form class="glass-form" method="post" action="<?= site_url('users') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= esc(old('username'), 'attr') ?>" maxlength="50">
            <div class="field-error"><?= validation_show_error('username') ?></div>
        </div>

        <div class="form-group">
            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name" value="<?= esc(old('full_name'), 'attr') ?>" maxlength="100">
            <div class="field-error"><?= validation_show_error('full_name') ?></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" maxlength="255" autocomplete="new-password">
            <div class="field-error"><?= validation_show_error('password') ?></div>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirm password</label>
            <input type="password" id="password_confirm" name="password_confirm" maxlength="255" autocomplete="new-password">
            <div class="field-error"><?= validation_show_error('password_confirm') ?></div>
        </div>

        <button class="button button-primary" type="submit">Add User</button>
    </form>
</div>
<?= $this->endSection() ?>
