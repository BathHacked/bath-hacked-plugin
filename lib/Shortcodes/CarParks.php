<?php


class BathHacked_Shortcodes_CarParks
{

    public function render($atts, $content='')
    {
        $atts = shortcode_atts(array(
            'theme' => 'dark',
            'style' => 'radial'
        ), $atts, 'bh_car_parks');

        ob_start();

        include(__DIR__ . '/../../views/car-parks-shortcode.php');

        $view = ob_get_clean();

        return $view;
    }

}