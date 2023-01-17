<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo $currentpage == 'Subjects' ? '' : 'collapsed'; ?>" href="<?php echo base_url('dashboard/subject')?>">
                <i class="bi bi-grid"></i>
                <span>Subjects</span>
            </a>
        </li><!-- End subjects Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $currentpage == 'Upload Subject Data' ? '' : 'collapsed'; ?>" href="<?php echo base_url('dashboard/upload')?>">
                <i class="bi bi-grid"></i>
                <span>Upload Subject Data</span>
            </a>
        </li><!-- End upload Nav -->
    </ul>
</aside>