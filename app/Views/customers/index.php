<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="table-stage">
    <div class="page-heading-row">
        <h1 class="page-title"><?= esc($title) ?></h1>
        <a class="button button-primary" href="<?= site_url('customers/new') ?>">Add Customer</a>
    </div>

    <div class="glass-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th scope="col">Full name</th>
                    <th scope="col">Email address</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td class="cell-primary"><?= esc($customer['full_name'] ?? $customer['fullName']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone']) ?></td>
                        <td><a class="text-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
