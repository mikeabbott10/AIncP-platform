<?= $this->extend('Layouts/login_layout') ?>

<?= $this->section('content') ?>
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
            class="img-fluid" alt="Phone image">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
            <form id="signin_form" action="" method="POST" class="my-5">
                <!-- User code input -->
                <div class="form-outline mb-4">
                    <input type="text" id="usercode" class="form-control form-control-lg" name="uc" placeholder="User code"/>
                    <label class="form-label" for="usercode">User code</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" class="form-control form-control-lg" name="pw" placeholder="Password"/>
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block col-12">Sign in</button>
            </form>
        </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>