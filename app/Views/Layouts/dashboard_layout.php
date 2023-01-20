<!DOCTYPE html>
<html lang="en" class="notranslate" translate="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google" content="notranslate" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aincp Platform - Dashboard</title>

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <!-- Vendor JS Files -->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.6.2.min.js'); ?>" defer></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>" defer></script>

    <script src="<?php echo base_url('assets/js/main.js'); ?>" defer></script>

    <?= $this->renderSection('page_related_head') ?>
</head>
<body>
    <?php echo view('Components/dashboard_header') ?>
    <?php echo view('Components/dashboard_sidebar') ?>

    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1><?= $this->renderSection('page_title') ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?= $currentpage; ?></li>
                    <?= $this->renderSection('breadcrumb') ?>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </section>
    </main>
    
    <?php echo view('Components/dashboard_footer') ?>
</body>
</html>