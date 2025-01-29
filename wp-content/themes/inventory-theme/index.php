<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <main>
    <?php

    get_template_part('templates/sidebar');
    get_header();
    get_template_part('templates/page-dashboard');

    get_footer();
    ?>
    </main>
    <?php wp_footer(); ?>


</body>

</html>


