<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Point of Sale') ?> | POS</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="site-canvas">
        <header class="nav-capsule-wrapper">
            <nav class="nav-capsule" aria-label="Primary Navigation">
                <a href="<?= base_url('/') ?>" class="nav-brand">POS</a>
                <div class="nav-divider" aria-hidden="true"></div>
                <?php
                    $currentUri = trim(service('request')->getPath(), '/');
                ?>
                <div class="nav-links">
                    <a href="<?= base_url('/') ?>" class="nav-item <?= $currentUri === '' ? 'is-active' : '' ?>">Home</a>
                    <a href="<?= base_url('about') ?>" class="nav-item <?= $currentUri === 'about' ? 'is-active' : '' ?>">About</a>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url('customers') ?>" class="nav-item <?= str_starts_with($currentUri, 'customers') ? 'is-active' : '' ?>">Customers</a>
                        <a href="<?= base_url('users') ?>" class="nav-item <?= str_starts_with($currentUri, 'users') ? 'is-active' : '' ?>">Users</a>
                        <span class="nav-user" title="Signed-in username"><?= esc(session()->get('username')) ?></span>
                        <a href="<?= base_url('logout') ?>" class="nav-item">Logout</a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="nav-item <?= $currentUri === 'login' ? 'is-active' : '' ?>">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <main class="content-stage">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="status">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>
