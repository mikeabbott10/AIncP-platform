<?= $this->extend('Layouts/dashboard_layout')?>

<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/css/form_text_input.css'); ?>" rel="stylesheet">
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="d-flex justify-content-center">
    <?= form_open_multipart('dashboard/upload/upload', 
        [
            'class'=>"subject_data_card d-flex flex-column align-items-center justify-content-center border border-secondary rounded py-2 pb-3 mt-4", 
            'id'=>"newsubjectform",
            'style'=>"--bs-border-opacity: .3;"
        ]) ?>
        <div class="w-75">
            <label class="form-label label-stay" for="subjectselection">Please select the subject from the list.</label>
            <select name="subjectselection" class="form-select" id="subjectselection">
                <option value="-1" selected>New subject</option>
                <?php foreach ($subjects as $subj): ?>
                    <option value="<?=$subj['id']?>"><?php echo $subj['surname'] .' '.$subj['name'].' - '.$subj['code']?></option>
                <?php endforeach ?>
            </select>
        </div>

        <hr class="w-100 border-top border-secondary">
        
        <div class="col-md-12 mt-1 ps-3">
            <span><strong>Subject Card</strong>: </span>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="subjname" id='subjname' maxlength="200"/>
            <label for="subjname" class="form__label label-stay">Name</label>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="subjsurname" id='subjsurname' maxlength="200"/>
            <label for="subjsurname" class="form__label label-stay">Surname</label>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="subjcode" id='subjcode' maxlength="20" required/>
            <label for="subjcode" class="form__label label-stay">Code*</label>
        </div>
        
        <div class="mt-1">
            <a class="text-secondary" data-bs-toggle="collapse" href="#otherData" aria-expanded="false" aria-controls="otherData">
                <span>more...</span>
            </a>
        </div>

        <div class="collapse col-md-12 row mt-1" id="otherData">
            <div class="col-md-6 my-2">
                <label class="form-label" for="subjgender">Gender</label>
                <select name="subjgender" class="form-select" id="subjgender" form="newsubjectform">
                    <option value="" selected>Gender:</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>
            
            <div class="col-md-6 my-2">
                <label class="form-label" for="subjdominance">Dominance</label>
                <select name="subjdominance" class="form-select" id="subjdominance" form="newsubjectform">
                    <option value="" selected>Dominance:</option>
                    <option value="R">Right</option>
                    <option value="L">Left</option>
                </select>
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="subjaha">AHA</label>
                <input type="number" name="subjaha" placeholder="AHA value" class="form-control" id="subjaha" min=0>
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="subjmacs">MACS</label>
                <input type="number" name="subjmacs" placeholder="MACS class" class="form-control" id="subjmacs" min=0>
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="subjhemi">hemi</label>
                <input type="number" name="subjhemi" placeholder="hemi" class="form-control" id="subjhemi" min=0>
            </div>
        </div>
        <hr class="w-100 border-top border-secondary">
        <div class="col-md-12 mt-0 ps-3">
            <span><strong>File Data</strong>: Please select a local file you want to upload</span>
        </div>
        <div class="row g-3 col-md-12 mt-1">
            <div class="col-md-1">
            </div>

            <div class="col-md-5">
                <label class="form-label" for="filechoice">CSV input</label>
                <input type="file" name="data_file" class="form-control" id="filechoice"
                    accept="text/plain, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    required
                >
            </div>

            <div class="col-md-4">
                <label class="form-label" for="data_tag">Data Tag</label>
                <select name="data_tag" class="form-select" id="data_tag" form="newsubjectform" required>
                    <option value="" selected>Data Tag:</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?=$tag['id']?>"><?php echo $tag['label']?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-1 d-flex align-content-center" style="flex-wrap:wrap;">
                <span data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="right" 
                        data-bs-content="If the loaded file already refers to a session, please tag it.">
                    <i class="bi bi-info-circle"></i>
                </span>
            </div>

            <div class="col-md-1">
            </div>

        </div>

        <div class="col-md-2 mt-3">
            <input class="btn btn-primary w-100" type="submit" value="Submit">
        </div>
    </form>
</div>

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

