<?= $this->extend('Layouts/dashboard_layout')?>

<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label label-stay" for="subjectselection">Please select the subject from the list.</label>
        <select name="subjectselection" class="form-select" id="subjectselection">
            <option value="-1" selected>New subject</option>
            <?php foreach ($subjects as $subj): ?>
                <option value="<?=$subj['ID']?>"><?php echo $subj['code']. ' - ' .$subj['name']. ' '.$subj['surname']?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<?= form_open_multipart('dashboard/upload/upload', 
        [
            'class'=>"row g-3 border border-secondary rounded py-2 pb-3 mt-4", 
            'id'=>"newsubjectform",
            'style'=>"--bs-border-opacity: .3;"
        ]) ?>
        <div class="col-md-12 mt-1">
            <span><strong>Subject Data</strong>:</span>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="subjname">Name</label>
            <input type="text" name="subjname" placeholder="Subject Name" class="form-control" id="subjname" maxlength="200">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="subjsurname">Surname</label>
            <input type="text" name="subjsurname" placeholder="Subject Surname" class="form-control" id="subjsurname" maxlength="200">
        </div>
        
                <div class="col-md-2">
                    <label class="form-label" for="subjcode">Code</label>
                    <input type="text" name="subjcode" placeholder="Subject Code" class="form-control" id="subjcode" maxlength="20" required>
                </div>
        
        <div class="col-md-2">
            <label class="form-label" for="subjdominance">Dominance</label>
            <select name="subjdominance" class="form-select" id="subjdominance" form="newsubjectform" required>
                <option value="" selected>Dominance:</option>
                <option value="R">Right</option>
                <option value="L">Left</option>
            </select>
        </div>

        <div class="col-md-12 mt-1">
            <a data-bs-toggle="collapse" href="#otherData" aria-expanded="false" aria-controls="otherData">
                <span><strong>more...</strong></span>
            </a>
        </div>

        <div class="collapse col-md-12 row ms-1 mt-1" id="otherData">
            <div class="col-md-3">
                <label class="form-label" for="subjgender">Gender</label>
                <select name="subjgender" class="form-select" id="subjgender" form="newsubjectform">
                    <option value="" selected>Gender:</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="subjaha">AHA</label>
                <input type="number" name="subjaha" placeholder="AHA value" class="form-control" id="subjaha" min=0>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="subjmacs">MACS</label>
                <input type="number" name="subjmacs" placeholder="MACS class" class="form-control" id="subjmacs" min=0>
            </div>

            <div class="col-md-3">
                <label class="form-label" for="subjhemi">hemi</label>
                <input type="number" name="subjhemi" placeholder="hemi" class="form-control" id="subjhemi" min=0>
            </div>
        </div>
        
        <div class="col-md-12 mt-4">
            <span><strong>File Data</strong>:</span>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="filechoice">CSV input</label>
            <input type="file" name="data_file" class="form-control" id="filechoice"
                accept="text/plain, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label" for="data_tag">Data Tag</label>
            <select name="data_tag" class="form-select" id="data_tag" form="newsubjectform" required>
                <option value="" selected>File Data Tag:</option>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?=$tag['ID']?>"><?php echo $tag['label']?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-md-1 d-flex align-content-center" style="flex-wrap:wrap;">
            <span data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="right" 
                    data-bs-content="If the loaded file already refers to a session, please tag it.">
                <i class="bi bi-info-circle"></i>
            </span>
        </div>

        <div class="col-md-2">
        </div>
        <div class="col-md-2">
            <input class="btn btn-primary w-100" type="submit" value="Submit">
        </div>
</form>

<div class="d-flex col-12 align-items-center justify-content-center mt-1">
    <?php foreach ($errors as $error): ?>
        <span class="text-danger"><?= esc($error) ?></span>
    <?php endforeach ?>
</div>

<script>
    // set global subjects variable
    var subjects = <?= json_encode($subjects) ?>;
</script>
<script src="<?php echo base_url('assets/js/dashboard/upload_file.js'); ?>" defer></script>

<?= $this->endSection() ?>

