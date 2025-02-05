<?php
// Función para cargar los estilos y scripts del tema

function inventory_enqueue_assets() {
    // Cargar Bootstrap desde CDN
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css', array(), null, 'all');

    // Cargar el CSS personalizado DESPUÉS de Bootstrap
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/assets/css/custom-style.css',
        array('bootstrap-css'), // Asegura que Bootstrap se cargue antes
        filemtime(get_template_directory() . '/assets/css/custom-style.css'),
        'all'
    );

    // Cargar Bootstrap JS desde CDN
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'inventory_enqueue_assets');
