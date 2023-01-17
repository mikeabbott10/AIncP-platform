<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/vendor/datatables/datatables.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/vendor/datatables/datatables.min.js'); ?>" defer></script>
<script>
    var deleteResourceBaseUrl = '<?=base_url('dashboard/subject/'.$subject['id'].'/sessions/delete');?>';

    // ==============================================================
    // datatables functions
    // ==============================================================
    var initObj = {
        // stateSave: true, // needs same table id everytime the page is loaded (https://datatables.net/reference/option/stateSave)
        columnDefs: [
            { orderable: false, targets: 3 },
        ],
        order: [[1, 'desc']]
    }
</script>
<script src="<?php echo base_url('assets/js/my_datatables.js'); ?>" defer></script>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page breadcrumb
===================================================================== -->
<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item">Subject <?= $subject['code']?></li>
<li class="breadcrumb-item active">Sessions</li>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page content
===================================================================== -->
<?= $this->section('content') ?>

<a class="btn btn-success rounded-pill mb-3" href="<?=base_url('dashboard/session/add')?>"><i class="bi bi-plus-lg"></i> Add a new session</a>
<?php
echo view('Components/session/sessions_table_header.php');
foreach ($sessions as $sess){
    echo view_cell('SessionRow::show', ['session'=>$sess, 'subject_id'=>$subject['id']]);
}
echo view('Components/session/sessions_table_footer.php');
?>

<?= $this->endSection() ?>