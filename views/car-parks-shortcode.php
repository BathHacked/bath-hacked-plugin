<?php

$pluginOptions = get_option('bath_hacked_settings');

if(empty($pluginOptions) || empty($pluginOptions['bath_hacked_car_parks_url'])) return;

?>

<div data-car-parks data-url="<?php echo $pluginOptions['bath_hacked_car_parks_url'] ?>" data-style="<?php echo $atts['style'] ?>" data-theme="<?php echo $atts['theme'] ?>"></div>
