<?= $this->extend('Layouts/dashboard_layout')?>

<?= $this->section('content') ?>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label label-stay" for="subjgender">Please select the subject from the list.</label>
        <select name="subjgender" class="form-select" id="subjgender">
            <option value="-1" selected>New subject</option>
            <?php foreach ($subjects as $subj): ?>
                <option value="<?=$subj['ID']?>"><?php echo $subj['code']. ' - ' .$subj['name']. ' '.$subj['surname']?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<?= form_open_multipart('dashboard/upload/upload', 
        ['class'=>"row g-3 border border-primary rounded py-2 pb-3 mt-4", 
        'id'=>"newsubjectform",
        'style'=>"--bs-border-opacity: .3;"
        ]) ?>
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
            <label class="form-label" for="subjgender">Gender</label>
            <select name="subjgender" class="form-select" id="subjgender" form="newsubjectform">
                <option selected>Gender:</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
                <option value="o">Other</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="subjdominance">Dominance</label>
            <select name="subjdominance" class="form-select" id="subjdominance" form="newsubjectform">
                <option selected>Dominance:</option>
                <option value="R">Right</option>
                <option value="L">Left</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="subjaha">AHA</label>
            <input type="number" name="subjaha" placeholder="AHA value" class="form-control" id="subjaha" min=0>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="subjmacs">MACS</label>
            <input type="number" name="subjmacs" placeholder="MACS class" class="form-control" id="subjmacs" min=0>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="subjhemi">hemi</label>
            <input type="text" name="subjhemi" placeholder="hemi" class="form-control" id="subjhemi" maxlength="100">
        </div>

        <div class="col-md-4">
            <label class="form-label" for="filechoice">CSV input</label>
            <input type="file" name="userfile" class="form-control" id="filechoice"
                accept="text/plain, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                required
            >
        </div>

        <div class="col-md-5">
        </div>
        <div class="col-md-2">
            <input class="btn btn-primary w-100" type="submit" value="Submit">
        </div>
        <div class="col-md-5">
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

