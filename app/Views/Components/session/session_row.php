<tr class="tableRow selectable bg-secondary bg-gradient" style="--bs-bg-opacity: 0.14">
    <!-- Tag -->
    <td class="align-middle p-1" style="max-width: 3vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $session['tag'] ?>
        </span>
    </td>
    <!-- Notes -->
    <td class="align-middle p-1" style="max-width: 10vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $session['notes'] ?>
        </span>
    </td>
    <!-- Start time -->
    <td class="align-middle p-1" style="max-width: 7vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $session['start_time'] ?>
        </span>
    </td>
    <!-- End time -->
    <td class="align-middle p-1" style="max-width: 7vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $session['end_time'] ?>
        </span>
    </td>

    <td class="action align-middle p-1 px-2" style="max-width:2vw; height:2rem; overflow:hidden">
        <div class="d-flex justify-content-center">
            <button class="btn btn-secondary remove-row p-1 text-white me-2" style="width:2rem;"
                data-id="<?=$session['id']?>" disabled>
                <i class="bi bi-code-slash"></i>
            </button>
            <button class="btn btn-danger remove-row p-1 text-white" style="width:2rem;"
                data-id="<?=$session['id']?>">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </td>
</tr>