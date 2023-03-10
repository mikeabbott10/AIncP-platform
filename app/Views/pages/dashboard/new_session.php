<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/css/form_text_input.css'); ?>" rel="stylesheet">

<script src="https://code.highcharts.com/stock/highstock.js" defer></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js" defer></script>
<script src="https://code.highcharts.com/modules/accessibility.js" defer></script>
<script>
    const dataURL = '<?=base_url("/dashboard/subject/{$subject['id']}/session/getData");?>';
</script>
<script src="<?php echo base_url('assets/js/dashboard/my_highchart.js'); ?>" defer></script>

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

<div class="w-100 d-flex flex-column align-items-center justify-content-center border border-secondary rounded bg-white bg-opacity-50">
    <div id="container" style="height: 30vw; width: 95%;"></div>

    <?= form_open("dashboard/subject/{$subject['id']}/session/upload_session", 
        [   
            'method'=>'post',
            'class'=>"w-100 d-flex flex-column align-items-center justify-content-center py-2 pb-3 mt-1 spinner-btn-form", 
            'id'=>"newsessionform",
            'style'=>"--bs-border-opacity: .3;"
        ]) ?>
        <?= csrf_field() ?>

        <div class="form__group field w-75 mb-4 mt-0">
            <input type="input" class="form__field" placeholder="Notes" name="notes" id="notes" maxlength="200" />
            <label for="notes" class="form__label label-stay">Notes</label>
        </div>

        <div class="d-flex justify-content-center col-md-12">
            <div class="col-md-4">
                <label class="form-label" for="tag_id">Data Tag</label>
                <select name="tag_id" class="form-select" id="tag_id" form="newsessionform" required>
                    <option value="" selected>Data Tag:</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?=$tag['id']?>"><?php echo $tag['label']?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <input type="hidden" name="file_id" value="<?=$file_id;?>"/>
        <input type="hidden" name="start_time"/>
        <input type="hidden" name="end_time"/>

        <div class="col-md-2 mt-4 mb-2">
            <button class="btn btn-primary w-100 spinner-btn" type="submit">
                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>Submit
            </button>
        </div>
    </form>
</div>

<div class="d-flex col-12 align-items-center justify-content-center mt-1">
    <?php foreach ($errors as $error): ?>
        <span class="text-danger"><?= esc($error) ?></span>
    <?php endforeach ?>
</div>

<?= $this->endSection() ?>