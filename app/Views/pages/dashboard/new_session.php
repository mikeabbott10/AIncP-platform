<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<?php 
if(!isset($data)){?>
    <script src="<?php echo base_url('assets/js/dashboard/upload_file.js'); ?>" defer></script>
<?php }else{ ?>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.stock.min.js" defer></script>
    <script>
        var dataPoints = [];
        <?=json_encode($data)?>.forEach(element => {
            dataPoints.push({
                x: new Date(element.x),
                y: element.y
            })
        });
    </script>
    <script src="<?php echo base_url('assets/js/dashboard/my_stockchart.js'); ?>" defer></script>
<?php } ?>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page breadcrumb
===================================================================== -->
<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item">Subject <?= $subject['code']?></li>
<li class="breadcrumb-item active">New session</li>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page content
===================================================================== -->
<?= $this->section('content') ?>

<?php
if(!isset($data)){
    echo view('Components/upload_file_modal', ['subject' => $subject]);
}
else
{
?>
<div class="w-100 d-flex flex-column align-items-center justify-content-center border border-secondary rounded bg-white bg-opacity-50">
    <?= form_open("dashboard/subject/{$subject['id']}/session/upload_session", 
        [   
            'method'=>'post',
            'class'=>"w-100 d-flex flex-column align-items-center justify-content-center py-2 pb-3 mt-4", 
            'id'=>"newsessionform",
            'style'=>"--bs-border-opacity: .3;"
        ]) ?>
        <?= csrf_field() ?>
        <div id="stockChartContainer" style="height: 400px; width: 100%;"></div>
        

        <div class="col-md-2 mt-4 mb-2">
            <input class="btn btn-primary w-100" type="submit" value="Submit">
        </div>
    </form>
</div>

<?php } ?>

<div class="d-flex col-12 align-items-center justify-content-center mt-1">
    <?php foreach ($errors as $error): ?>
        <span class="text-danger"><?= esc($error) ?></span>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>