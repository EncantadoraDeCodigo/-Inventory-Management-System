<div class="container-fluid p-4" style="margin-left: 250px;">
    <h5 class="fw-bold mb-3">Dashboard</h5>
    <div class="row">
        <?php
        global $wpdb; // Objeto global para interactuar con la base de datos
        $metrics = [ // Definimos las métricas dinámicas
            ['title' => 'Clientes', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM clients"), 'color' => '#28a745', 'icon' => 'bi bi-person-workspace'],
            ['title' => 'Proveedores', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM providers"), 'color' => '#fd7e14', 'icon' => 'fas fa-truck'],
            ['title' => 'Productos', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM products"), 'color' => '#6610f2', 'icon' => 'fas fa-box'],
            ['title' => 'Facturas', 'count' => $wpdb->get_var("SELECT COUNT(*) FROM invoices"), 'color' => '#6c757d', 'icon' => 'fas fa-file-invoice'],
            ['title' => 'Existencia total', 'count' => 148, 'color' => '#007bff', 'icon' => 'fas fa-clipboard-list'],
            ['title' => 'Existencia vendida', 'count' => 33, 'color' => '#dc3545', 'icon' => 'fas fa-shopping-cart'],
            ['title' => 'Existencia actual', 'count' => 115, 'color' => '#17a2b8', 'icon' => 'fas fa-chart-bar'],
            ['title' => 'Importe vendido', 'count' => '$413', 'color' => '#fd7e14', 'icon' => 'fas fa-credit-card'],
            ['title' => 'Importe pagado', 'count' => '$414', 'color' => '#28a745', 'icon' => 'fas fa-credit-card'],
            ['title' => 'Importe restante', 'count' => '$0', 'color' => '#6c757d', 'icon' => 'fas fa-wallet'],
            ['title' => 'Beneficio bruto', 'count' => '$89', 'color' => '#795548', 'icon' => 'fas fa-money-bill'],
            ['title' => 'Beneficio neto', 'count' => '$89', 'color' => '#17a2b8', 'icon' => 'fas fa-balance-scale']
        ];

        foreach ($metrics as $metric) { // Generamos las métricas dinámicamente
            get_template_part('templates/card-metric', null, $metric);
        }
        ?>
    </div>
</div>
