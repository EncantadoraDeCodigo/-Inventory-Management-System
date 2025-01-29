<div class="container-fluid p-4" style="margin-left: 250px;">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <?php
        global $wpdb;
        $metrics = [
            ['title' => 'Clientes', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM wp_clients"), 'color' => 'success', 'icon' => 'fas fa-users'],
            ['title' => 'Proveedores', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM wp_providers"), 'color' => 'warning', 'icon' => 'fas fa-truck'],
            ['title' => 'Productos', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM wp_products"), 'color' => 'primary', 'icon' => 'fas fa-box'],
            ['title' => 'Facturas', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM wp_invoices"), 'color' => 'dark', 'icon' => 'fas fa-file-invoice'],
            ['title' => 'Existencia total', 'count' => 148, 'color' => 'info', 'icon' => 'fas fa-clipboard-list'],
            ['title' => 'Existencia vendida', 'count' => 33, 'color' => 'danger', 'icon' => 'fas fa-shopping-cart'],
            ['title' => 'Existencia actual', 'count' => 115, 'color' => 'primary', 'icon' => 'fas fa-chart-bar'],
            ['title' => 'Importe vendido', 'count' => '$413', 'color' => 'orange', 'icon' => 'fas fa-credit-card'],
            ['title' => 'Importe restante', 'count' => '$0', 'color' => 'secondary', 'icon' => 'fas fa-wallet'],
            ['title' => 'Beneficio bruto', 'count' => '$89', 'color' => 'brown', 'icon' => 'fas fa-money-bill'],
            ['title' => 'Beneficio neto', 'count' => '$89', 'color' => 'cyan', 'icon' => 'fas fa-balance-scale']
        ];

        foreach ($metrics as $metric) {
            get_template_part('templates/card-metric', null, $metric);
        }
        ?>
    </div>
</div>
