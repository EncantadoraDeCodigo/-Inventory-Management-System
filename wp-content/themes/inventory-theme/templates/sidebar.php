<nav class="bg-dark text-white p-2" style="width: 250px; height: 100vh; position: fixed; top: 50; left: 0; overflow-y: auto;">
    <div class="text-center">
        
        <img src="<?php echo get_template_directory_uri(); ?>/assets/imagenes/logo.png" width="80" class="rounded-circle">
        <p class="mt-2">Diego Carmona Bernal</p>
        <small>carmona.bernal.diego@email.com</small>
    </div>
    <hr class="border-light">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/dashboard'); ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/clients'); ?>">
                <i class="fas fa-users"></i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/products'); ?>">
                <i class="fas fa-box"></i> Gestión de Productos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/inventory'); ?>">
                <i class="fas fa-warehouse"></i> Gestión de Existencias
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/reports'); ?>">
                <i class="fas fa-chart-line"></i> Reportes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="<?php echo site_url('/settings'); ?>">
                <i class="fas fa-cog"></i> Configuración
            </a>
        </li>
    </ul>
</nav>
