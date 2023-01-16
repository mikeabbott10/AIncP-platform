<tr class="tableRow selectable bg-secondary bg-gradient" style="--bs-bg-opacity: 0.14">
    <td class="action text-center" style="width: 1rem;"></td>
    <!-- Code -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['code'] ?></span>
    </td>
    <!-- Name -->
    <td class="align-middle p-1" style="max-width: 7vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $subject['name'] ?>
        </span>
    </td>
    <!-- Surname -->
    <td class="align-middle p-1" style="max-width: 7vw; height:0.5rem; overflow:hidden">
        <span style="display: inline-block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
                position: relative; top: 50%; transform: translateY(-60%);">
            <?= $subject['surname'] ?>
        </span>
    </td>
    <!-- Gender -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['gender'] ?></span>
    </td>
    <!-- Dominance -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['dominance'] ?></span>
    </td>
    <!-- AHA -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['AHA'] ?></span>
    </td>
    <!-- MACS -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['MACS'] ?></span>
    </td>
    <!-- hemi -->
    <td class="align-middle p-1" style="width: 6rem; height:0.5rem; overflow:hidden">
        <span style="white-space: pre;"><?= $subject['hemi'] ?></span>
    </td>
    <td class="action align-middle p-1 px-2" style="width:2rem; height:2rem; overflow:hidden">
        <div class="d-flex justify-content-center">
            <a class="btn btn-dark edit-row p-1 me-1 text-white" style="width:2rem;"
                href="<?=base_url('dashboard/subjects/'.$subject['ID'])?>">
                <i class="bi bi-pencil-square"></i>
            </a>
            <button class="btn btn-danger remove-row p-1" style="width:2rem;"
                data-ID="<?=$subject['ID']?>">
                <i class="bi bi-trash text-white"></i>
            </button>
        </div>
    </td>
</tr>