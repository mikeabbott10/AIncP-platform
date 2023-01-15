<?= $this->extend('Layouts/dashboard_layout') ?>

<?= $this->section('content') ?>
<?php
    if($subject_code==-1){
        echo "tutti i soggetti";
    }else
        echo "il soggetto ". $subject_code;
?>
<?= $this->endSection() ?>