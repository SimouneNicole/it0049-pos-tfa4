<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="form-stage">
    <div class="page-heading-row">
        <div>
            <h1 class="page-title"><?= esc($title) ?></h1>
            <p class="lead-statement">Update this customer's account details.</p>
        </div>
        <a class="button button-secondary" href="<?= site_url('customers') ?>">Back to Customers</a>
    </div>

    <form class="glass-form" method="post" action="<?= site_url('customers/' . $customer['id']) ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name" value="<?= esc(old('full_name', $customer['full_name']), 'attr') ?>" maxlength="100">
            <div class="field-error"><?= validation_show_error('full_name') ?></div>
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" value="<?= esc(old('email', $customer['email']), 'attr') ?>" maxlength="100">
            <div class="field-error"><?= validation_show_error('email') ?></div>
        </div>

        <div class="form-group">
            <label for="phone">Phone number <span class="optional">Optional</span></label>
            <input type="text" id="phone" name="phone" value="<?= esc(old('phone', $customer['phone']), 'attr') ?>" maxlength="20">
            <div class="field-error"><?= validation_show_error('phone') ?></div>
        </div>

        <button class="button button-primary" type="submit">Update Customer</button>
    </form>
</div>
<?= $this->endSection() ?>
