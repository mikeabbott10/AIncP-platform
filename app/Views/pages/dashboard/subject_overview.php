<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/vendor/datatables/datatables.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/vendor/datatables/datatables.min.js'); ?>" defer></script>
<script>
    var deleteSubjectBaseUrl = '<?=base_url('dashboard/subject/delete');?>';
</script>
<script src="<?php echo base_url('assets/js/my_datatables.js'); ?>" defer></script>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page breadcrumb
===================================================================== -->
<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active">Home</li>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page content
===================================================================== -->
<?= $this->section('content') ?>

<a class="btn btn-success rounded-pill mb-3" href="<?=base_url('dashboard/subject/add')?>"><i class="bi bi-plus-lg"></i> Add a new subject</a>
<?php
echo view('Components/subjects_table_header.php');
foreach ($subjects as $subj){
    echo view_cell('SubjectRow::show', ['subj' => $subj]);
}
echo view('Components/subjects_table_footer.php');
?>

<?= $this->endSection() ?>