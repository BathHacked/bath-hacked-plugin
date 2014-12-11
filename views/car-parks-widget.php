<?php

$pluginOptions = get_option('bath_hacked_settings');

if(empty($pluginOptions) || empty($pluginOptions['bath_hacked_car_parks_url'])) return;

?>


<?php echo $args['before_widget'] ?>


<?php if(!empty($instance['title'])): ?>
    <?php echo $args['before_title'], $instance['title'], $args['after_title']  ?>
<?php endif; ?>

<div data-car-parks data-url="<?php echo $pluginOptions['bath_hacked_car_parks_url'] ?>" data-style="<?php echo $instance['style'] ?>" data-theme="<?php echo $instance['theme'] ?>"></div>

<?php echo $args['after_widget'] ?>