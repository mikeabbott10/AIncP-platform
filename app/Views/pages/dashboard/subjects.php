<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/vendor/datatables/datatables.min.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/vendor/datatables/datatables.min.js'); ?>" defer></script>
<script>
    var deleteResourceBaseUrl = '<?=base_url('dashboard/subject/delete');?>';

    // ==============================================================
    // datatables functions
    // ==============================================================
    /* Formatting function for row details */
    function format(d, tds) {
        // `d` is the original data object for the row
        return (
            '<table class="table child-table" cellpadding="5" cellspacing="0" style="padding-left:50px;">' +
            '<tr>' +
                '<td>Subject Code:</td>' +
                '<td>' +
                    $(d.code).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Name:</td>' +
                '<td>' +
                    $(d.name).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Surname:</td>' +
                '<td>' +
                    $(d.surname).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Gender:</td>' +
                '<td>' +
                    $(d.gender).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Arm Dominance:</td>' +
                '<td>' +
                    $(d.dominance).text() +
                '</td>' +
            '</tr>'+            
            '<tr>' +
                '<td>AHA value:</td>' +
                '<td>' +
                    $(d.aha).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>MACS class:</td>' +
                '<td>' +
                    $(d.macs).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>hemi:</td>' +
                '<td>' +
                    $(d.hemi).text() +
                '</td>' +
            '</tr>' +
            '</table>'
        );
    }
    var initObj = {
        // stateSave: true, // needs same table id everytime the page is loaded (https://datatables.net/reference/option/stateSave)
        columnDefs: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
                targets: 0
            },
            { orderable: false, targets: 0 },
            { data:'code', targets: 1 },
            { data:'name', targets: 2 },
            { data:'surname', targets: 3 },
            { data:'gender', targets: 4 },
            { data:'dominance', targets: 5 },
            { data:'aha', targets: 6 },
            { data:'macs', targets: 7 },
            { data:'hemi', targets: 8 },
            { orderable: false, targets: 9 },
        ],
        order: [[3, 'asc']]
    }
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
echo view('Components/subject/subjects_table_header.php');
foreach ($subjects as $subj){
    echo view_cell('SubjectRow::show', $subj);
}
echo view('Components/subject/subjects_table_footer.php');
?>

<?= $this->endSection() ?>