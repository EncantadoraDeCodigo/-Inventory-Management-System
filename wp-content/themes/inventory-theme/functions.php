<?php
// Función para cargar los estilos y scripts del tema
function inventory_enqueue_assets() {
    // Cargar estilos
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // Cargar scripts
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'inventory_enqueue_assets');


