<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - <?php wp_title(); ?></title>
    <link rel="stylesheet" id="custom-style-css" href="http://localhost/inventorySystem/wordpress/wp-content/themes/inventory-theme/assets/css/custom-style.css?ver=1234567890" type="text/css" media="all">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
    <a class="navbar-brand text-white fw-bold" href="<?php echo site_url('/dashboard'); ?>">
        <i class="fas fa-clipboard-list"></i> Inventario
    </a>

    <div class="ms-auto d-flex align-items-center">
        <span class="text-white me-3">Bienvenido, <strong>StarScale_admin</strong></span>
        
        <a href="<?php echo site_url('/settings'); ?>" class="btn btn-light me-2">
            <i class="fas fa-cog"></i> Configuración
        </a>

        <a href="<?php echo wp_logout_url(); ?>" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Salir
        </a>
    </div>
</header>
