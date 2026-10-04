<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="hero-split">
    <div class="hero-copy">
        <h1 class="page-title"><?= esc($title) ?></h1>
        <p class="lead-statement">Customer and staff records, kept in one clear place.</p>
    </div>
    <div class="hero-lens-stage" aria-hidden="true">
        <div class="glass-lens">
            <div class="lens-glow"></div>
            <div class="lens-ring"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
