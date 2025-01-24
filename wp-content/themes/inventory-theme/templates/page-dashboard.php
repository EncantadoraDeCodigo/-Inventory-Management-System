<?php
/* Template Name: Dashboard */
get_header();
?>
<div class="container mt-4">
    <h1 class="text-center">Dashboard</h1>
    <div class="row">
    <div class="row">
    <!-- Tarjeta Clientes -->
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Clientes</div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php
                    global $wpdb;
                    $clients_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_clients");
                    echo $clients_count;
                    ?>
                </h5>
            </div>
        </div>
    </div>
    <!-- Más tarjetas -->
</div>

    </div>
</div>
<?php
get_footer();
?>
