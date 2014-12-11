<?php


class BathHacked_Widgets_CarParks extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('bathhacked_carparks', 'Bath: Hacked Car Parks', array(
           'description' => 'Live Bath Car Park Occupancy'
        ));
    }

    public function widget($args, $instance)
    {
        ob_start();

        include(__DIR__ . '/../../views/car-parks-widget.php');

        $view = ob_get_clean();

        echo $view;
    }

    public function form($instance)
    {
        ob_start();

        include(__DIR__ . '/../../views/car-parks-form.php');

        $view = ob_get_clean();

        echo $view;
    }

    public function update( $newInstance, $oldInstance)
    {
        $instance = $oldInstance;

        $instance['title'] = !empty($newInstance['title'])  ? strip_tags($newInstance['title']) : '';
        $instance['theme'] = !empty($newInstance['theme'])  ? strip_tags($newInstance['theme']) : 'dark';
        $instance['style'] = !empty($newInstance['style'])  ? strip_tags($newInstance['style']) : 'linear';

        return $instance;
    }
}