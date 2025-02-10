<header class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
    <a class="navbar-brand fw-bold text-white" href="#">Inventario</a>

    <!-- Contenedor de iconos -->
    <div class="ms-auto d-flex align-items-center">
        <!-- Icono de notificaciones -->
        <div class="position-relative me-3">
            <i class="fas fa-bell fa-lg text-white"></i>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">3</span>
        </div>

        <!-- Icono de perfil con dropdown -->
        <div class="dropdown">
            <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/user.png" alt="Perfil" class="rounded-circle" width="40" height="40">
                <span class="ms-2">Usuario</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><a class="dropdown-item" href="#">Configuración</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</header>
