<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('theme'); ?>"><?php _e('Theme:') ?></label>
    <select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>">
        <option value="dark" <?php selected($instance['theme'], 'dark') ?>>Dark</option>
        <option value="light" <?php selected($instance['theme'], 'light') ?>>Light</option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:') ?></label>
    <select id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
        <option value="radial" <?php selected($instance['style'], 'radial') ?>>Radial</option>
        <option value="linear" <?php selected($instance['style'], 'linear') ?>>Linear</option>
    </select>
</p>
