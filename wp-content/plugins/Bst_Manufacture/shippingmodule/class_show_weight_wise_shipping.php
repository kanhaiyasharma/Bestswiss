<?php
 /*
 * Custom class to manage weight wise shipping
 *
 */

 class BST_Weight_Based_Shipping extends WC_Weight_Based_Shipping{

        const PLUGIN_PREFIX = 'woowbs_';

        public $plugin_id = self::PLUGIN_PREFIX;

        public $sttingarra =array();

        /*public function __construct($profileId = null)
        {

            $manager = WBS_Profile_Manager::instance();

            // Force loading profiles when called from WooCommerce 2.3.9- save handler
            // to activate process_admin_option() with appropriate hook
            if (!isset($profileId)) {
                $manager->profiles();
            }

            //$this->id = $manager->find_suitable_id($profileId);
            //$this->profile_id = $profileId;

            //$this->method_title = __('Weight Based', 'woowbs');

            //$this->sttingarra = new WbsSettingsHtmlTools($this);

            //$this->init();
        }*/

    
 	    public function htmlform()
        {

            $woocommerce = WC();

            $htmlformval = array(
                ### Meta ###
                array(
                    'type' => 'title',
                    'title' => __('Rule Settings', 'woowbs'),
                ),
                    'enabled'    => array(
                        'title'   => __('Enable/Disable', 'woowbs'),
                        'type'    => 'checkbox',
                        'label'   => __('Enable this rule', 'woowbs'),
                        'default' => '0',
                        'name'    => 'weightShip_enable'
                    ),
                    /*'tax_status' => array(
                        'title'       => __('Tax Status', 'woowbs'),
                        'type'        => 'select',
                        'default'     => 'taxable',
                        'class'		  => 'availability wc-enhanced-select',
                        'name'    => 'weightShip_taxstatus',
                        'options'     => array(
                            'taxable'   => __('Taxable', 'woowbs'),
                            'none'      => __('None', 'woowbs'),
                        ),
                    ),*/
                ### Conditions ###
                array(
                    'type' => 'title',
                    'title' => __('Conditions', 'woowbs'),
                    'description' => __('Define when the delivery option should be shown to the customer. All the following conditions must be met to activate the rule.', 'woowbs'),
                ),
                    'weight' => array(
                        'title'       => __('Order Weight', 'woowbs'),
                        'type'        => 'wbs_range',
                        'name'    => 'weightShip_weight',
                        'totalcondition' => 1
                    ),
                    'subtotal' => array(
                        'title'       => __('Order Subtotal', 'woowbs'),
                        'type'              => 'wbs_custom',
                        'wbs_real_type'     => 'wbs_range',
                        'wbs_row_class'     => 'wbs-subtotal',
                        'name'    => 'weightShip_subtotal',
                        'totalcondition' => 1
                    ),

                ### Calculations ###
                array(
                    'type' => 'title',
                    'title' => __('Maximum cart total / weight', 'woowbs'),
                    'description' => __('The total cost or weight after which shipping free.', 'woowbs'),
                ),
                    'maxiumm_weight'        => array(
                        'title'       => __('Maximum weight', 'woowbs'),
                        'type'        => 'weight',
                        'description' => __('Leave empty if dont want to apply this rule.', 'woowbs'),
                        'default' => '0'
                    ),
                    'maximum_cost' => array(
                        'title'       => __('Maximum Cost', 'woowbs'),
                        'type'        => 'price',
                        'description' =>__('Leave empty if dont want to apply this rule.'),
                        'default' => '0'
                    )

            );

            $placeholders = array
            (
                'weight_unit' => __(get_option('woocommerce_weight_unit'), 'woowbs'),
                'currency' => get_woocommerce_currency_symbol(),
            );

            foreach ($htmlformval as &$field)
            {
                $field['description'] = wbst(@$field['description'], $placeholders);
            }
            $htmlformval['placholder']=array(
                'weight_unit' => __(get_option('woocommerce_weight_unit'), 'woowbs'),
                'currency' => get_woocommerce_currency_symbol(),
            );

            //$htmlformval = apply_filters('wbs_profile_settings_form', $this->form_fields, $this);
            return $htmlformval;
        }

 }


?>