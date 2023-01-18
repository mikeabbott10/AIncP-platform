<!-- Modal -->
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="uploadModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalTitle"><strong>First step</strong></h5>
        <a class="btn close" href="<?= base_url("dashboard/subject/{$subject['id']}/session") ?>" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
        <?= form_open_multipart("dashboard/subject/{$subject['id']}/session/upload_file", 
            [
                'class'=>'spinner-btn-form',
                'id'=>"newfileform"
            ]) ?>
            <?= csrf_field() ?>
            <!-- ==========================================================================
            ## body inside form
            =========================================================================== -->
            <div class="modal-body">
                <div class="mb-2">
                    <span>Please select a local file you want to upload</span>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="filechoice">CSV input</label>
                    <input type="file" name="data_file" class="form-control" id="filechoice"
                        accept="text/plain, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        required
                    >
                </div>
            </div>
            <!-- ==========================================================================
            ## footer inside form
            =========================================================================== -->
            <div class="modal-footer">
                <button type="submit" form="newfileform" class="btn btn-primary spinner-btn">
                  <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>Upload
                </button>
            </div>
        </form>
    </div>
  </div>
</div>