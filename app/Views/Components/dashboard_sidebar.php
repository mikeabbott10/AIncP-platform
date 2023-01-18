<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo $currentpage == 'Subjects' ? '' : 'collapsed'; ?>" href="<?php echo base_url('dashboard/subject')?>">
                <i class="bi bi-grid"></i>
                <span>Subjects</span>
            </a>
        </li><!-- End subjects Nav -->

        <li class="nav-item">
            <a class="nav-link disabled <?php echo $currentpage == 'x' ? '' : 'collapsed'; ?>" href="<?php echo base_url('dashboard/upload')?>">
                <i class="bi bi-calendar3"></i>
                <span>Coming soon...</span>
            </a>
        </li><!-- End upload Nav -->
    </ul>
</aside>