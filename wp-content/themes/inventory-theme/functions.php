<?php
function inventory_system_setup() {
    // Registrar menús
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'inventorySystem')
    ));
}
add_action('after_setup_theme', 'inventory_system_setup');

function inventory_system_scripts() {
    // Cargar estilos
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Cargar scripts
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'inventory_system_scripts');
?>
