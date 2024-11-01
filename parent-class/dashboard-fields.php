<?php

/**
 *  WeddingCity Email Builder
 */

if (!class_exists('WeddingCity_Form_Fields')) {

    /**
     *  WeddingCity Emails
     */
    class WeddingCity_Form_Fields extends WeddingCity_User {

        /**
         * Member Variable
         *
         * @var instance
         */
        private static $instance;

        /**
         *  Initiator
         */
        public static function get_instance() {

            if (!isset(self::$instance)) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct() {

            do_action('weddingcity_texonomy');
        }

        public static function display_horizontal_tab_with_content($_list_of_data) {

            if (WeddingCity_Loader::array_condition($_list_of_data)):

            ?>  <div class="card">
                  <div class="card-header">
                      <?php

            print '<ul class="nav nav-tabs card-header-tabs nav-justified" id="myTab" role="tablist">';

            foreach ($_list_of_data as $key => $value) {

                printf('<li class="nav-item">
                                      <a class="nav-link %1$s" id="%2$s-tab" data-toggle="tab" href="#%2$s" role="tab" aria-controls="%2$s" aria-selected="%4$s">%3$s</a>
                                  </li>',

                    // 1
                    ($value['active'] == true) ? 'active' : '',

                    // 2
                    sanitize_title($value['tab_name']),

                    // 3
                    esc_html($value['tab_name']),

                    // 4
                    ($value['active'] == true) ? 'true' : 'false'
                );
            }

            print '</ul>';

            print '</div><div class="tab-content" id="myTabContent">';

            foreach ($_list_of_data as $key => $value) {

                printf('<div class="tab-pane fade %1$s" id="%2$s" role="tabpanel" aria-labelledby="%2$s-tab">',

                    // 1
                    ($value['active'] == true) ? 'active show' : '',

                    // 1
                    sanitize_title($value['tab_name']),

                    // 2
                    esc_html($value['tab_name'])
                );

                /**
                 *  @link https://www.geeksforgeeks.org/php-call_user_func-function/
                 */

                self::weddingcity_form_start(array(

                    'tab_name' => esc_html($value['tab_name']),

                    'form_id' => esc_attr($value['form_id']),
                ));

                call_user_func(array($value['class'], $value['function']));

                self::weddingcity_form_end(array(

                    'btn_id' => esc_attr($value['btn_id']),

                    'btn_name' => esc_html($value['btn_name']),

                    'nonce' => $value['nonce'],

                    'form_bottom' => $value['form_bottom'],
                ));

                print '</div>';
            }

            print '</div></div>';

            endif;
        }

        public static function display_card_section_with_content($_list_of_data) {

            if (WeddingCity_Loader::array_condition($_list_of_data)):

                foreach ($_list_of_data as $key => $value) {

                    /**
                     *  @link https://www.geeksforgeeks.org/php-call_user_func-function/
                     */

                    self::weddingcity_form_start(array(

                        'title' => esc_html($value['tab_name']),

                        'form_id' => esc_attr($value['form_id']),

                        'form_top' => $value['form_top'],
                    ));

                    call_user_func(array($value['class'], $value['function']));

                    self::weddingcity_form_end(array(

                        'btn_id' => esc_attr($value['btn_id']),

                        'btn_name' => esc_html($value['btn_name']),

                        'nonce' => $value['nonce'],

                        'form_bottom' => $value['form_bottom'],
                    ));
                }

            endif;
        }

        public static function display_tab_with_content($_list_of_data) {

            if (WeddingCity_Loader::array_condition($_list_of_data)):

            ?>
          <div class="row">
              <div class="col-xl-3 mb-4">
                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      <?php

            foreach ($_list_of_data as $key => $value) {

                if ($value['display'] == true) {

                    printf('<a class="nav-link %1$s" id="%2$s-tab" data-toggle="pill" href="#%2$s" role="tab" aria-controls="%2$s" aria-selected="true">%3$s</a>',

                        // 1
                        ($value['active'] == true) ? 'active' : '',

                        // 1
                        sanitize_title($value['tab_name']),

                        // 2
                        esc_html($value['tab_name'])
                    );
                }
            }

            ?>

                  </div>
              </div>

              <div class="col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">

                      <?php

            foreach ($_list_of_data as $key => $value) {

                if ($value['display'] == true) {

                    printf('<div class="tab-pane fade %1$s" id="%2$s" role="tabpanel" aria-labelledby="%2$s-tab">',

                        // 1
                        ($value['active'] == true) ? 'active show' : '',

                        // 1
                        sanitize_title($value['tab_name']),

                        // 2
                        esc_html($value['tab_name'])
                    );

                    /**
                     *  @link https://www.geeksforgeeks.org/php-call_user_func-function/
                     */

                    self::weddingcity_form_start(array(

                        'title' => esc_html($value['tab_name']),

                        'form_id' => esc_attr($value['form_id']),
                    ));

                    call_user_func(array($value['class'], $value['function']));

                    self::weddingcity_form_end(array(

                        'btn_id' => esc_attr($value['btn_id']),

                        'btn_name' => esc_html($value['btn_name']),

                        'nonce' => $value['nonce'],

                        'form_bottom' => $value['form_bottom'],
                    ));

                    print '</div>';

                }
            }

            ?>

                </div>
              </div>
            </div>

          <?php

            endif; // if is array
        }

        /**
         *
         *.  Form Top Section
         *
         */
        public static function weddingcity_form_start($_get_args) {

            $defaults = array(

                'title' => '',
                'form_id' => '',
                'form_top' => '',
            );

            $args = wp_parse_args($_get_args, $defaults);

            ?>  <div class="card">

                <?php if (!empty($args['title'])): ?>

                      <div class="card-header"><?php echo $args['title']; ?></div>

                <?php endif;?>

                    <form id="<?php echo esc_attr($args['form_id']); ?>" enctype="multipart/form-data" method="post"  autocomplete="off">
            <?php
}

        public static function weddingcity_form_end($_get_args) {

            $defaults = array(

                'btn_id' => '',
                'btn_name' => '',
                'nonce' => '',
                'form_bottom' => '',
            );

            $args = wp_parse_args($_get_args, $defaults);

            extract($args);

            if (!empty($btn_id) && !empty($btn_name) && !empty($nonce)) {

                /**
                 *. Form Bottom Section
                 */

                self::section_card_body_start();

                printf('<div class="%1$s"><button type="submit" id="%2$s" name="%2$s" class="btn btn-default">%3$s</button>%4$s %5$s</div>',

                    // 1
                    self::get_section_grid('12'),

                    // 2
                    esc_attr($btn_id),

                    // 3
                    esc_html($btn_name),

                    // 4
                    self::weddingcity_number_of_nonce_fields($nonce),

                    // 5 - form bottom
                    $form_bottom
                );

                self::section_card_body_end();

            }

            ?></form></div><?php
}

        public static function weddingcity_number_of_nonce_fields($_get_data) {

            $_get_number_of_nonce = '';

            foreach (explode(',', $_get_data) as $key => $value) {

                $_get_number_of_nonce .= wp_nonce_field($value, $value, true, false);
            }

            return $_get_number_of_nonce;
        }

        /**
         *  Grid - Column
         */
        public static function get_section_grid($args) {

            if ($args == '12') {

                return 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12';

            } elseif ($args == '6') {

                return 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';

            } elseif ($args == '4') {

                return 'col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12';

            } else {

                return 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12';
            }
        }

        /**
         * Body Start
         * @param  boolean $border [description]
         * @return [type]          [description]
         */
        public static function section_card_body_start($border = true) {

            if ($border == true) {

                $_border = 'border-top';
            }

            ?><div class="card-body <?php echo $_border; ?>"><div class="row"><?php
}

        public static function section_card_body_end() {

            ?></div></div><?php
}

        /**
         * Input Field
         */
        public static function weddingcity_dashboard_section_info($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'heading_tag' => 'h4',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                            <h4>%2$s</h4>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['lable'])
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        /**
         * Input Field
         */
        public static function weddingcity_dashboard_section_text($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'text',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <input id="%2$s" value="%4$s" name="%2$s" type="%5$s" placeholder="%6$s" class="form-control input-md %2$s %7$s" %8$s>
                          </div>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        /**
         * Date Field
         */
        public static function weddingcity_dashboard_section_date($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'text',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf('  <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <input id="%2$s" value="%4$s" name="%2$s" type="%5$s" placeholder="%6$s" class="form-control input-md wedding_date %7$s" %8$s>
                              <div class="venue-form-calendar"><i class="far fa-calendar-alt"></i></div>
                          </div>
                      </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        /**
         *  Website
         */
        public static function weddingcity_dashboard_section_website($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'url',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <input id="%2$s" value="%4$s" name="%2$s" type="%5$s" placeholder="%6$s" class="form-control input-md %2$s %7$s" %8$s>
                          </div>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_dashboard_section_email($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'email',
                'is_disable' => true,
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <input %9$s id="%2$s" value="%4$s" name="%2$s" type="%5$s" placeholder="%6$s" class="form-control input-md %2$s %7$s" %8$s>
                          </div>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : '',

                // 9 - disable
                ($args['is_disable'] == true) ? 'disabled' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_dashboard_section_textarea($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf('<div class="%1$s">
                        <div class="form-group">
                            %3$s
                            <textarea class="summerynotes %6$s" id="%2$s" name="%2$s" rows="6" placeholder="%5$s" %7$s>%4$s</textarea>
                        </div>
                    </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                (!empty($args['lable']))

                ? sprintf('<label class="control-label" for="%2$s">%1$s</label>', esc_html($args['lable']), esc_html($args['name']))

                : '',

                // 4
                esc_html($args['value']),

                // 5 - placeholder
                esc_html($args['placeholder']),

                // 6 - class
                esc_html($args['class']),

                // 7 - required ?
                ($args['require'] == true) ? 'required' : ''

            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        /**
         *  Number Field
         */
        public static function weddingcity_dashboard_section_number($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'placeholder' => esc_html__('Placeholder', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'number',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <input id="%2$s" value="%4$s" name="%2$s" type="%5$s" placeholder="%6$s" class="form-control input-md %2$s %7$s" %8$s>
                          </div>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_dashboard_section_select($_get_args) {

            $defaults = array(

                'grid' => absint('4'),
                'name' => esc_html__('Field Name', 'weddingcity'),
                'lable' => esc_html__('Lable Name', 'weddingcity'),
                'options' => '',
                'require' => true,
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'data_taxonomy' => '',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf('  <div class="%1$s">
                          <div class="form-group">
                              <label class="control-label" for="%2$s">%3$s</label>
                              <select id="%2$s" name="%2$s" %7$s class="wide mb20 %6$s" %5$s>%4$s</select>
                          </div>
                      </div>',

                // 1 - grid setting
                self::get_section_grid(absint($args['grid'])),

                // 2 - for, name, id
                esc_attr($args['name']),

                // 3 - lable
                esc_html($args['lable']),

                // 4 - retrive options
                $args['options'],

                // 5 - required ?
                ($args['require'] == true) ? 'required' : '',

                // 6 - class
                esc_html($args['class']),

                // 7 - data taxonomy
                (!empty($args['data_taxonomy']))

                ? sprintf('data-taxonomy="%1$s"', $args['data_taxonomy'])

                : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_dashboard_section_password_field($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Password Field', 'weddingcity'),
                'lable' => esc_html__('Password Field', 'weddingcity'),
                'placeholder' => esc_html__('Password', 'weddingcity'),
                'require' => true,
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'type' => 'password',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">

                          <div class="form-group row">

                              <div class="col-sm-4"><label class="control-label" for="%2$s">%3$s</label></div>

                              <div class="col-sm-8">

                                  <div class="input-group">

                                  <div class="input-group-prepend" data-state="hidden"><div class="input-group-prepend" data-state="hidden"><span class="input-group-text"><i class="fas fa fa-eye"></i></span></div></div>

                                  <input type="%5$s" id="%2$s" name="%2$s" class="form-control %7$s" placeholder="%6$s" %8$s>

                                  </div>
                              </div>

                          </div>

                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                esc_html($args['value']),

                // 5 - type
                esc_html($args['type']),

                // 6 - placeholder
                esc_html($args['placeholder']),

                // 7 - class
                esc_html($args['class']),

                // 8 - required ?
                ($args['require'] == true) ? 'required' : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_dashboard_section_switch_field($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('Switch Field', 'weddingcity'),
                'lable' => esc_html__('Switch Field', 'weddingcity'),
                'placeholder' => esc_html__('Switch Field', 'weddingcity'),
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'value' => false,
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">

                          <div class="form-group">

                              <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">%3$s
                                      <div class="switch-notification">
                                          <label class="switch">
                                              <input type="checkbox" %4$s class="custom-control-input" name="%2$s" id="%2$s">
                                              <span class="slider"></span>
                                          </label>
                                      </div>
                                  </li>
                              </ul>

                          </div>

                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['name']),

                // 3
                esc_html($args['lable']),

                // 4
                ($args['value'] == 'on') ? esc_attr('checked') : ''
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_map($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'id' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            printf(' <div class="%1$s">
                            <div id="%2$s"></div>
                        </div>',

                // 1
                self::get_section_grid(absint($args['grid'])),

                // 2
                esc_html($args['id'])
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_listing_amenities($_get_args) {

            $defaults = array(

                'grid' => absint('6'),
                'id' => '',
                'class' => '',
                'options' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'post_id' => '',
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            $venue_amenities =

            (is_array(WeddingCity_Listing_Meta::listing_venue_amenities(absint($args['post_id'])))

                && count(WeddingCity_Listing_Meta::listing_venue_amenities(absint($args['post_id']))) >= absint('0')
            )

            ? WeddingCity_Listing_Meta::listing_venue_amenities(absint($args['post_id']))

            : array();

            if ($args['options'] != '') {

                $i = absint('0');

                foreach ($args['options'] as $args_value) {

                    if ($args_value['name'] != '') {

                        $_checked =

                        (in_array(sanitize_title($args_value['name']), $venue_amenities))

                        ? 'checked' : '';

                        ?>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                  <div class="custom-control custom-checkbox">

                                    <input <?php echo $_checked; ?> data-value="<?php echo absint($i); ?>" value="<?php echo esc_html(sanitize_title($args_value['name'])); ?>"
                                      type="checkbox" name="venue_amenities" class="custom-control-input" id="amenities_<?php echo absint($i) ?>">

                                    <label class="custom-control-label" for="amenities_<?php echo absint($i) ?>"><?php echo esc_html($args_value['name']); ?></label>

                                  </div>
                              </div>

                          <?php

                        $i++;
                    }
                }
            }

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        /**
         *  WeddingCity Featured Map
         */
        public static function weddingcity_single_image_upload($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'id' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,

                'image_id' => '',
                'image_src' => '',
                'btn_lable' => esc_html__('Upload Featured Image', 'weddingcity'),

                'object' => esc_attr('Featured_Image_Object'),
            );

            $args = wp_parse_args($_get_args, $defaults);

            if ($args['group_start'] == true) {

                self::section_card_body_start($args['border_top']);
            }

            WeddingCity_Media_Upload::weddingcity_single_media_upload_e(

                esc_attr($args['object']),

                absint($args['image_id']),

                esc_url($args['image_src']),

                esc_html($args['btn_lable'])
            );

            if ($args['group_end'] == true) {

                self::section_card_body_end();
            }
        }

        public static function weddingcity_featured_listing($_get_args) {

            $defaults = array(

                'grid' => absint('12'),
                'name' => esc_html__('featured_listing', 'weddingcity'),
                'lable' => esc_html__('Featured Listing', 'weddingcity'),
                'placeholder' => esc_attr__('Featured Listing', 'weddingcity'),
                'value' => '',
                'class' => '',
                'group_start' => true,
                'group_end' => true,
                'border_top' => true,
                'post_id' => '',
            );

            $args = wp_parse_args($_get_args, $defaults);

            extract($args);

            $_vendor_post_id = absint(get_post_meta($post_id, 'listing_vendor', true));

            $_capacity_featured_listing = absint(get_post_meta($_vendor_post_id, 'capacity_featured_listing', true));

            $_number_of_featured_listing = absint(get_post_meta($_vendor_post_id, 'number_of_featured_listing', true));

            $_is_featured_listing = (get_post_meta($post_id, 'featured_listing', true) == 'on')

            ? esc_html('checked')

            : '';

            if ($_capacity_featured_listing > $_number_of_featured_listing || WeddingCity_Listing_Meta::featured_listing($_vendor_post_id) == 'on') {

                if ($args['group_start'] == true) {

                    self::section_card_body_start($args['border_top']);
                }

                printf('  <div class="%1$s">
                              <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">%2$s
                                      <div class="switch-notification">
                                          <label class="switch">
                                              <input type="checkbox" %3$s class="custom-control-input" name="%4$s" id="%4$s">
                                              <span class="slider"></span>
                                        </label>
                                      </div>
                                  </li>
                              </ul>
                          </div>',

                    // 1
                    self::get_section_grid(absint($_grid)),

                    // 2
                    esc_html__('If you want to show this listing as a Featured Listing ?', 'weddingcity'),

                    // 3
                    $_is_featured_listing,

                    // 4
                    esc_attr($name)
                );

                if ($args['group_end'] == true) {

                    self::section_card_body_end();
                }
            }
        }
    }

    /**
     *  Kicking this off by calling 'get_instance()' method
     */
    WeddingCity_Form_Fields::get_instance();

}