<?= $this->extend('Layouts/dashboard_layout') ?>

<!-- ===================================================================
## Page head
===================================================================== -->
<?= $this->section('page_related_head') ?>
<link href="<?php echo base_url('assets/css/form_text_input.css'); ?>" rel="stylesheet">
<?= $this->endSection() ?>

<!-- ===================================================================
## Page breadcrumb
===================================================================== -->
<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item active"><?=$subject['code']==''?'New':$subject['code'];?> Subject Card</li>
<?= $this->endSection() ?>

<!-- ===================================================================
## Page content
===================================================================== -->
<?= $this->section('content') ?>
<div class="d-flex justify-content-center">
    <?= form_open('dashboard/subject'.($subject['id']==''?'':'/'.$subject['id']).'/upload', 
        [   
            'method'=>'post',
            'class'=>"subject_data_card d-flex flex-column align-items-center justify-content-center border border-secondary rounded py-2 pb-3 mt-4 bg-white bg-opacity-50", 
            'id'=>"newsubjectform",
            'style'=>"--bs-border-opacity: .3;"
        ]) ?>
        <?= csrf_field() ?>
        
        <div class="col-md-12 mt-1 ps-3">
            <span><strong>Subject Card</strong>: </span>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="name" id="name" maxlength="200" value="<?=$subject['name']?>"/>
            <label for="name" class="form__label label-stay">Name</label>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="surname" id="surname" maxlength="200" value="<?=$subject['surname']?>"/>
            <label for="surname" class="form__label label-stay">Surname</label>
        </div>

        <div class="form__group field w-75">
            <input type="input" class="form__field" placeholder="Name" name="code" id="code" maxlength="18" value="<?=$subject['code']?>" required/>
            <label for="code" class="form__label label-stay">Code*</label>
        </div>
        
        <div class="mt-2">
            <a class="text-secondary" data-bs-toggle="collapse" href="#otherData" aria-expanded="false" aria-controls="otherData">
                <span>more...</span>
            </a>
        </div>

        <div class="collapse col-md-12 row mt-1" id="otherData">
            <div class="col-md-6 my-2">
                <label class="form-label" for="gender">Gender</label>
                <select name="gender" class="form-select" id="gender" form="newsubjectform">
                    <option value="" selected>Gender:</option>
                    <option value="M" <?= $subject['gender']=='M'? 'selected':'' ?> >Male</option>
                    <option value="F" <?= $subject['gender']=='F'? 'selected':'' ?> >Female</option>
                    <option value="O" <?= $subject['gender']=='O'? 'selected':'' ?> >Other</option>
                </select>
            </div>
            
            <div class="col-md-6 my-2">
                <label class="form-label" for="dominance">Dominance</label>
                <select name="dominance" class="form-select" id="dominance" form="newsubjectform">
                    <option value="" selected>Dominance:</option>
                    <option value="R" <?= $subject['dominance']=='R'? 'selected':'' ?> >Right</option>
                    <option value="L" <?= $subject['dominance']=='L'? 'selected':'' ?> >Left</option>
                </select>
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="aha">AHA</label>
                <input type="number" name="aha" placeholder="AHA value" class="form-control" id="aha" min=0  value="<?=$subject['aha']==-1?'':$subject['aha']?>">
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="macs">MACS</label>
                <input type="number" name="macs" placeholder="MACS class" class="form-control" id="macs" min=0  value="<?=$subject['macs']==-1?'':$subject['macs']?>">
            </div>

            <div class="col-md-4 my-2">
                <label class="form-label" for="hemi">hemi</label>
                <input type="number" name="hemi" placeholder="hemi" class="form-control" id="hemi" min=0  value="<?=$subject['hemi']==-1?'':$subject['hemi']?>">
            </div>
        </div>

        <div class="d-flex justify-content-center col-md-5 mt-4 mb-2">
            <input class="btn btn-primary me-2" type="submit" value="Submit">
            <input class="btn btn-danger" type="reset" value="Reset">
        </div>
    </form>
</div>

<div class="d-flex col-12 align-items-center justify-content-center mt-1">
    <?php foreach ($errors as $error): ?>
        <span class="text-danger"><?= esc($error) ?></span>
    <?php endforeach ?>
</div>

<script src="<?php echo base_url('assets/js/dashboard/subject_data_form.js'); ?>" defer></script>

<?= $this->endSection() ?>