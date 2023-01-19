<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<?php if (!isset($data)): ?>
    <script src="<?php echo base_url('assets/js/dashboard/upload_file.js'); ?>" defer></script>
<?php else: ?>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.stock.min.js" defer></script>
    <script src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js" defer></script>
    <script>
        var dataPoints = [];
        <?php
        // need this logic to render huge amount of data
        $chunk_index = 0;
        while(true){
            $tmp = $controller->getFileDataChunk($data_file, $chunk_index);
            $plot = $tmp['plot'];
            $chunk_index = $tmp['next_index'];
            $end = $tmp['eof'];
            if($end){
                $data_file = null;
                break;
            }?>
            <?=json_encode($plot)?>.forEach(element => {
                dataPoints.push({
                    x: new Date(element.x),
                    y: element.y
                })
            });
        <?php } ?>
        console.log(dataPoints)
    </script>
    <script src="<?php echo base_url('assets/js/dashboard/my_stockchart.js'); ?>" defer></script>
<?php endif ?>
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
}else{ ?>
    <div class="w-100 d-flex flex-column align-items-center justify-content-center border border-secondary rounded bg-white bg-opacity-50">
        
        <div id="stockChartContainer" style="height: 30vw; width: 95%;">
            <!-- spinner -->
            <div class="d-flex justify-content-center align-items-center w-100 h-100">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </div>
        </div>

        <?= form_open("dashboard/subject/{$subject['id']}/session/upload_session", 
            [   
                'method'=>'post',
                'class'=>"w-100 d-flex flex-column align-items-center justify-content-center py-2 pb-3 mt-4", 
                'id'=>"newsessionform",
                'style'=>"--bs-border-opacity: .3;"
            ]) ?>
            <?= csrf_field() ?>

            <div class="d-flex justify-content-center col-md-12">
                <div class="col-md-4">
                    <label class="form-label" for="data_tag">Data Tag</label>
                    <select name="data_tag" class="form-select" id="data_tag" form="newsessionform" required>
                        <option value="" selected>Data Tag:</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?=$tag['id']?>"><?php echo $tag['label']?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

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