<?php
get_header();
get_template_part('templates/page-dashboard');
get_footer();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>> 

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <h1><?php bloginfo('name'); ?></h1>
        <nav><?php wp_nav_menu(); ?></nav>
    </header>
    <main>
        <h2>tu mejor activo es tu mente y  nadie puede te lo puede quitar./h2>
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                the_title('<h3>', '</h3>');
                the_content();
            }
        }
        ?>
    </main>
    <?php wp_footer(); ?>
</body>
</html>



