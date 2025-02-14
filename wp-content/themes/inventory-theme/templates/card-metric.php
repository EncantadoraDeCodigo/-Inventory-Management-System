<div class="col-lg-3 col-md-5 col-sm-6 mb-3">
    <div class="dashboard-card d-flex align-items-center p-3" style="background-color: <?php echo esc_attr($args['color']); ?>;">
        <div class="icon-container me-3">
            <i class="<?php echo esc_attr($args['icon']); ?>"></i>
        </div>
        <div class="text-container">
            <span class="fw-bold"><?php echo esc_html($args['title']); ?></span>
            <h3 class="fw-bold m-0"><?php echo esc_html($args['count']); ?></h3>
        </div>
    </div>
</div>
