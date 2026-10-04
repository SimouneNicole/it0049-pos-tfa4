<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="table-stage">
    <div class="page-heading-row">
        <h1 class="page-title"><?= esc($title) ?></h1>
        <a class="button button-primary" href="<?= site_url('users/new') ?>">Add User</a>
    </div>

    <div class="glass-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th scope="col">Avatar</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?php $avatarUrl = ! empty($user['avatar'])
                                ? base_url('uploads/' . $user['avatar'])
                                : base_url('images/avatar-placeholder.svg'); ?>
                            <img class="avatar-thumbnail" src="<?= esc($avatarUrl, 'attr') ?>" alt="<?= esc($user['full_name']) ?> avatar">
                        </td>
                        <td class="cell-primary"><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name'] ?? $user['fullName']) ?></td>
                        <td><a class="text-link" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
