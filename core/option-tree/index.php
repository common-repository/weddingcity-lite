<?php

/**
 *. option tree : typography all value get.
 */
if (!function_exists('weddingcity_metabox_body_style')) {

    function weddingcity_metabox_body_style($args) {

        $style = '';

        $weddingcity_Page_Style = get_post_meta(weddingcity_page_id(), $args, true);

        foreach ($weddingcity_Page_Style as $key => $value) {

            if ($key === 'background-image' && $value != '') {

                $style .= sprintf('%1$s:url(%2$s);', $key, $value);

            } elseif ($key === 'font-color' && $value != '') {

                $style .= sprintf('%1$s:%2$s;', esc_html('color'), $value);

            } else {

                if ($value != '') {

                    $style .= sprintf('%1$s:%2$s;', $key, $value);
                }
            }
        }

        return $style;
    }
}

/**
 *  Theme Option value function to get method.
 */
if (!function_exists('weddingcity_option')) {

    function weddingcity_option($key) {

        if (function_exists('ot_get_option')) {

            if (ot_get_option($key) != '') {
                return ot_get_option($key);
            }

        }

        return;
    }
}

/**
 * Layouts Overview option type.
 *
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if (!function_exists('ot_type_weddingcity_overview')) {

    function ot_type_weddingcity_overview() {

        /* format setting outer wrapper */
        echo '<div class="format-setting type-textblock wide-desc">';

        /* description */
        echo '<div class="description">';

        echo '<h4>' . __('WeddingCity - Suggestion And Feedback Form', 'weddingcity') . '</h4>';

        printf('<p>Thank you for buying our product, if you facing any issue, bug, improvement, suggestion. please free fill to update the form sheet. we will work on it and improved our product and release the update.  <a href="%1$s">WeddingCity - Suggestion And Feedback Form.</a>.</p>', WEDDINGCITY_FEEDBACK);

        echo '<p>' . __('Layouts make your theme awesome! With theme options data that you can save/import/export you can package themes with different color variations, or make it easy to do A/B testing on text and so much more. Basically, you save a snapshot of your data as a layout.', 'weddingcity') . '</p>';

        echo '<p>' . __('Once you have created all your different layouts, or theme variations, you can save them to a separate text file for repackaging with your theme. Alternatively, you could just make different variations for yourself and change your theme with the click of a button, all without deleting your previous options data.', 'weddingcity') . '</p>';

        echo '<p class="aside">' . __(' Adding a layout is ridiculously easy, follow these steps and you\'ll be on your way to having a WordPress super theme.', 'weddingcity') . '</p>';

        echo '<h4>' . __('For Developers', 'weddingcity') . ':</h4>';

        echo '<h5>' . __('Creating a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>OptionTre->Settings->Layouts</code> tab.', 'weddingcity') . '</li>';
        echo '<li>' . __('Enter a name for your layout in the text field and hit "Save Layouts", you\'ve created your first layout.', 'weddingcity') . '</li>';
        echo '<li>' . __('Adding a new layout is as easy as repeating the steps above.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Activating a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>OptionTre->Settings->Layouts</code> tab.', 'weddingcity') . '</li>';
        echo '<li>' . __('Click on the activate layout button in the actions list.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Deleting a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>OptionTre->Settings->Layouts</code> tab.', 'weddingcity') . '</li>';
        echo '<li>' . __('Click on the delete layout button in the actions list.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Edit Layout Data', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>Appearance->Theme Options</code> page.', 'weddingcity') . '</li>';
        echo '<li>' . __('Modify and save your theme options and the layout will be updated automatically.', 'weddingcity') . '</li>';
        echo '<li>' . __('Saving theme options data will update the currently active layout, so before you start saving make sure you want to modify the current layout.', 'weddingcity') . '</li>';
        echo '<li>' . __('If you want to edit a new layout, first create it then save your theme options.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h4>' . __('End-Users Mode', 'weddingcity') . ':</h4>';

        echo '<h5>' . __('Creating a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>Appearance->Theme Options</code> page.', 'weddingcity') . '</li>';
        echo '<li>' . __('Enter a name for your layout in the text field and hit "New Layout", you\'ve created your first layout.', 'weddingcity') . '</li>';
        echo '<li>' . __('Adding a new layout is as easy as repeating the steps above.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Activating a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>Appearance->Theme Options</code> page.', 'weddingcity') . '</li>';
        echo '<li>' . __('Choose a layout from the select list and click the "Activate Layout" button.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Deleting a Layout', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('End-Users mode does not allow deleting layouts.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '<h5>' . __('Edit Layout Data', 'weddingcity') . ':</h5>';
        echo '<ul class="docs-ul">';
        echo '<li>' . __('Go to the <code>Appearance->Theme Options</code> tab.', 'weddingcity') . '</li>';
        echo '<li>' . __('Modify and save your theme options and the layout will be updated automatically.', 'weddingcity') . '</li>';
        echo '<li>' . __('Saving theme options data will update the currently active layout, so before you start saving make sure you want to modify the current layout.', 'weddingcity') . '</li>';
        echo '</ul>';

        echo '</div>';

        echo '</div>';

    }

}