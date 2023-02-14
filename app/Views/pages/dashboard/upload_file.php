<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<script src="<?php echo base_url('assets/js/dashboard/upload_file.js'); ?>" defer></script>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_title') ?>
Save new session
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item">Subject <?= $subject['code']?></li>
<li class="breadcrumb-item active">New session</li>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page content
===================================================================== -->
<?= $this->section('content') ?>

<?= view('Components/upload_file_modal', ['subject' => $subject]); ?>

<div class="d-flex col-12 align-items-center justify-content-center mt-1">
    <?php foreach ($errors as $error): ?>
        <span class="text-danger"><?= esc($error) ?></span>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>