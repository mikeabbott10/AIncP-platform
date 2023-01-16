<?= $this->extend('Layouts/dashboard_layout') ?>

<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/vendor/datatables/datatables.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/vendor/datatables/datatables.min.js'); ?>" defer></script>
<script src="<?php echo base_url('assets/js/my_datatables.js'); ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
    if($subject_code==-1){
        if(count($subjects)>0){
            echo view('Components/subjects_table_header.php');
            foreach ($subjects as $subj){
                echo view_cell('SubjectRow::show', ['subj' => $subj]);
            }
            echo view('Components/subjects_table_footer.php');
        }
    }else
        echo "il soggetto ". $subject_code;
?>
<?= $this->endSection() ?>