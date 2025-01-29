<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
    <div class="card text-white bg-<?php echo esc_attr($args['color']); ?> shadow-sm">
        <div class="card-header d-flex align-items-center">
            <i class="<?php echo esc_attr($args['icon']); ?> me-2"></i>
            <?php echo esc_html($args['title']); ?>
        </div>
        <div class="card-body text-center">
            <h3 class="card-title"><?php echo esc_html($args['count']); ?></h3>
        </div>
    </div>
</div>

