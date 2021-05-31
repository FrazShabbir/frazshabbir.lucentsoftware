<?php

namespace ContentEgg\application\admin;

defined('\ABSPATH') || exit;

use ContentEgg\application\components\Config;
use ContentEgg\application\Plugin;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\models\PriceAlertModel;
use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\helpers\TextHelper;

/**
 * GeneralSettings class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2020 keywordrush.com
 */
class GeneralConfig extends Config {

    private static $affiliate_modules;

    public function page_slug()
    {
        return Plugin::slug() . '';
    }

    public function option_name()
    {
        return 'contentegg_options';
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::slug, __('Settings', 'content-egg') . ' &lsaquo; Content Egg', __('Settings', 'content-egg'), 'manage_options', $this->page_slug, array($this, 'settings_page'));
    }

    public static function langs()
    {
        return array(
            'ar' => 'Arabic (ar)',
            'bg' => 'Bulgarian (bg)',
            'ca' => 'Catalan (ca)',
            'zh_CN' => 'Chinese (zh_CN)',
            'zh_TW' => 'Chinese (zh_TW)',
            'hr' => 'Croatian (hr)',
            'cs' => 'Czech (cs)',
            'da' => 'Danish (da)',
            'nl' => 'Dutch (nl)',
            'en' => 'English (en)',
            'et' => 'Estonian (et)',
            'tl' => 'Filipino (tl)',
            'fi' => 'Finnish (fi)',
            'fr' => 'French (fr)',
            'de' => 'German (de)',
            'el' => 'Greek (el)',
            'iw' => 'Hebrew (iw)',
            'hi' => 'Hindi (hi)',
            'hu' => 'Hungarian (hu)',
            'is' => 'Icelandic (is)',
            'id' => 'Indonesian (id)',
            'it' => 'Italian (it)',
            'ja' => 'Japanese (ja)',
            'ko' => 'Korean (ko)',
            'lv' => 'Latvian (lv)',
            'lt' => 'Lithuanian (lt)',
            'ms' => 'Malay (ms)',
            'no' => 'Norwegian (no)',
            'fa' => 'Persian (fa)',
            'pl' => 'Polish (pl)',
            'pt' => 'Portuguese (pt)',
            'br' => 'Portuguese (br)',
            'ro' => 'Romanian (ro)',
            'ru' => 'Russian (ru)',
            'sr' => 'Serbian (sr)',
            'sk' => 'Slovak (sk)',
            'sl' => 'Slovenian (sl)',
            'es' => 'Spanish (es)',
            'sv' => 'Swedish (sv)',
            'th' => 'Thai (th)',
            'tr' => 'Turkish (tr)',
            'uk' => 'Ukrainian (uk)',
            'ur' => 'Urdu (ur)',
            'vi' => 'Vietnamese (vi)',
        );
    }

    protected function options()
    {

        $post_types = get_post_types(array('public' => true), 'names');
        if (isset($post_types['attachment']))
            unset($post_types['attachment']);

        $total_price_alerts = PriceAlertModel::model()->count('status = ' . PriceAlertModel::STATUS_ACTIVE);
        $sent_price_alerts = PriceAlertModel::model()->count('status = ' . PriceAlertModel::STATUS_DELETED
                . ' AND TIMESTAMPDIFF( DAY, complet_date, "' . \current_time('mysql') . '") <= ' . PriceAlertModel::CLEAN_DELETED_DAYS);

        $export_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=content-egg-tools&action=subscribers-export');

        return array(
            'lang' => array(
                'title' => __('Website language', 'content-egg'),
                'description' => __('The frontend language.', 'content-egg'),
                'dropdown_options' => self::langs(),
                'callback' => array($this, 'render_dropdown'),
                'default' => self::getDefaultLang(),
                'section' => __('General settings', 'content-egg'),
            ),
            'post_types' => array(
                'title' => 'Post Types',
                'description' => __('What post types do you want to use for Content Egg?', 'content-egg'),
                'checkbox_options' => $post_types,
                'callback' => array($this, 'render_checkbox_list'),
                'default' => array('post', 'page'),
                'section' => __('General settings', 'content-egg'),
            ),
            'cashback_integration' => array(
                'title' => __('Cashback Tracker integration', 'content-egg'),
                'description' => sprintf(__('Integration with %s plugin.', 'content-egg'), '<a target="_blanl" href="https://www.keywordrush.com/cashbacktracker">Cashback Tracker</a>') . ' ' .
                __('Convert all affiliate links to trackable cashback links if possible.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'enabled' => __('Enabled', 'content-egg'),
                    'disabled' => __('Disabled', 'content-egg'),
                ),
                'default' => 'enabled',
                'section' => __('General settings', 'content-egg'),
            ),
            'external_featured_images' => array(
                'title' => __('External featured images', 'content-egg'),
                'description' => __('Featured images from URL', 'content-egg') .
                '<p class="description">' . __('', 'content-egg') . '</p>',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'disabled' => __('Disabled - internal image is used', 'content-egg'),
                    'enabled_internal_priority' => __('Enabled - internal image has priority', 'content-egg'),
                    'enabled_external_priority' => __('Enabled - external image has priority', 'content-egg'),
                ),
                'default' => 'disabled',
                'section' => __('General settings', 'content-egg'),
            ),
            
            'woocommerce_modules' => array(
                'title' => __('Modules for synchronization', 'content-egg'),
                'description' => __('Select modules for automatic synchronization with WooCommerce.', 'content-egg'),
                'checkbox_options' => self::getAffiliteModulesList(),
                'callback' => array($this, 'render_checkbox_list'),
                'default' => array(),
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_product_sync' => array(
                'title' => __('Automatic synchronization', 'content-egg'),
                'description' => __('How to choose product for automatic synchronization with WooCommerce.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'min_price' => __('Minimum price', 'content-egg'),
                    'max_price' => __('Maximum price', 'content-egg'),
                    'random' => __('Random', 'content-egg'),
                    'manually' => __('Manually only', 'content-egg'),
                ),
                'default' => 'min_price',
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_attributes_sync' => array(
                'title' => __('Attributes synchronization', 'content-egg'),
                'description' => __('Also synchronize attributes automatically for synchronized product.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_attributes_filter' => array(
                'title' => __('Global attributes filter', 'content-egg'),
                'description' => __('How to create wocommerce attributes when synchronizing. Please, read documentation about them in our docs.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Default filter', 'content-egg'),
                    'whitelist' => __('Whitelist attribute names', 'content-egg'),
                    'blacklist' => __('Blacklist attribute names', 'content-egg'),
                ),
                'default' => '',
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_attributes_list' => array(
                'title' => __('Attributes list', 'content-egg'),
                'description' => __('Black / white list of woocommerce global (filterable) attributes. Enter a comma separated list.', 'content-egg'),
                'callback' => array($this, 'render_textarea'),
                'default' => '',
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_echo_update_date' => array(
                'title' => __('Update date', 'content-egg'),
                'description' => __('Show price update date for WooCommerce products.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Disabled', 'content-egg'),
                    'amazon' => __('Amazon only', 'content-egg'),
                    'all' => __('All modules', 'content-egg'),
                ),
                'default' => 'amazon',
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_echo_price_per_unit' => array(
                'title' => __('Price per unit', 'content-egg'),
                'description' => __('Show price per unit', 'content-egg') .
                '<p class="description">' .
                __('This option is available for Amazon and Ebay modules only.', 'content-egg') . '<br>' .
                '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => __('WooCommerce', 'content-egg'),
            ),
            'woocommerce_btn_text' => array(
                'title' => __('Buy button text', 'content-egg'),
                'description' => __('Overwrite the button text for external products.', 'content-egg') . ' ' . __('You can use tags: %MERCHANT%, %DOMAIN%, %PRICE%, %STOCK_STATUS%.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'strip_tags',
                ),
                'section' => __('WooCommerce', 'content-egg'),
            ),            
            
            'rel_attribute' => array(
                'title' => 'Rel attribute for affiliate links',
                'description' => sprintf(__('<a target="_blank" href="%s">Qualify</a> your affiliate links to Google.', 'content-egg'), 'https://support.google.com/webmasters/answer/96569'),
                'checkbox_options' => array(
                    'nofollow' => 'nofollow',
                    'sponsored' => 'sponsored',
                    'external' => 'external',
                    'noopener' => 'noopener',
                    'noreferrer' => 'noreferrer',
                    'ugc' => 'ugc',
                ),
                'callback' => array($this, 'render_checkbox_list'),
                'default' => array('nofollow'),
                'section' => __('Templates', 'content-egg'),
            ),
            'filter_bots' => array(
                'title' => __('Filter bots', 'content-egg'),
                'description' => __('Bots can\'t activate parsers.', 'content-egg') .
                '<p class="description">' . __('Updating price and keyword updating is made with page opening. If we determine update by useragent, and page is opened by one of known bots, no parsers will work in this case.', 'content-egg') . '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => __('General settings', 'content-egg'),
            ),
            
            
            
            'price_history_days' => array(
                'title' => __('Price history', 'content-egg'),
                'description' => __('How long save price history. 0 - deactivate price history.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 180,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 365,
                        'message' => sprintf(__('The field "%s" can\'t be more than %d.', 'content-egg'), __('Price history', 'content-egg'), 365),
                    ),
                ),
                'section' => __('Price alerts', 'content-egg'),
            ),
            'price_drops_days' => array(
                'title' => __('Price drops period', 'content-egg'),
                'description' => __('Used for Price Movers widget.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '1.' => __('The last 1 day', 'content-egg'),
                    '2.' => sprintf(__('The last %d days', 'content-egg'), 2),
                    '3.' => sprintf(__('The last %d days', 'content-egg'), 3),
                    '4.' => sprintf(__('The last %d days', 'content-egg'), 4),
                    '5.' => sprintf(__('The last %d days', 'content-egg'), 5),
                    '6.' => sprintf(__('The last %d days', 'content-egg'), 6),
                    '7.' => sprintf(__('The last %d days', 'content-egg'), 7),
                    '21.' => sprintf(__('The last %d days', 'content-egg'), 21),
                    '30.' => sprintf(__('The last %d days', 'content-egg'), 30),
                    '90.' => sprintf(__('The last %d days', 'content-egg'), 90),
                    '180.' => sprintf(__('The last %d days', 'content-egg'), 180),
                    '360.' => sprintf(__('The last %d days', 'content-egg'), 360),
                ),
                'default' => '30.',
                'section' => __('Price alerts', 'content-egg'),
            ),
            'price_alert_enabled' => array(
                'title' => 'Price alert',
                'description' => __('Allow visitors to subscribe for price drop alert on email.', 'content-egg') .
                '<p class="description">' . sprintf(__('Active subscriptions now: <b>%d</b>', 'content-egg'), $total_price_alerts) .
                '. ' . sprintf(__('Messages are sent for last %d days: <b>%d</b>', 'content-egg'), PriceAlertModel::CLEAN_DELETED_DAYS, $sent_price_alerts) . '.' .
                ' ' . sprintf(__('Export: [ <a href="%s">All</a> | <a href="%s">Active</a> ]', 'content-egg'), $export_url, $export_url . '&active_only=true') . '</p>' .
                '<p class="description">' .
                __('"Price history" option must be enabled.', 'content-egg') . '<br>' .
                __('Recommendation: Go to Settings - Privacy and select Privacy Policy page.', 'content-egg') .
                '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => __('Price alerts', 'content-egg'),
            ),
            'button_color' => array(
                'title' => __('Button color', 'content-egg'),
                'description' => __('Button color for default templates.', 'content-egg'),
                'callback' => array($this, 'render_color_picker'),
                'default' => '#d9534f',
                'validator' => array(
                    'trim',
                ),
                'section' => __('Templates', 'content-egg'),                
            ),
            'price_color' => array(
                'title' => __('Price color', 'content-egg'),
                'description' => __('Price color for default templates.', 'content-egg'),
                'callback' => array($this, 'render_color_picker'),
                'default' => '#dc3545',
                'validator' => array(
                    'trim',
                ),
                'section' => __('Templates', 'content-egg'),                
            ),            
            'btn_text_buy_now' => array(
                'title' => __('Buy now button text', 'content-egg'),
                'description' => sprintf(__('It will be used instead of "%s".', 'content-egg'), __('Buy Now', 'content-egg-tpl')) . ' ' . __('You can use tags: %MERCHANT%, %DOMAIN%, %PRICE%, %STOCK_STATUS%.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'strip_tags',
                ),
                'section' => __('Templates', 'content-egg'),                                
            ),
            'btn_text_coupon' => array(
                'title' => __('Coupon button text', 'content-egg'),
                'description' => sprintf(__('It will be used instead of "%s".', 'content-egg'), __('Shop Sale', 'content-egg-tpl')),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'strip_tags',
                ),
                'section' => __('Templates', 'content-egg'),                                
            ),
            'show_stock_status' => array(
                'title' => __('Stock status', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'show_status' => __('Show stock status', 'content-egg'),
                    'hide_status' => __('Hide stock status', 'content-egg'),
                    'show_outofstock' => __('Show OutOfStock status only', 'content-egg'),
                    'show_instock' => __('Show InStock status only', 'content-egg'),
                ),
                'default' => 'show_status',
                'section' => __('Templates', 'content-egg'),                                
            ),   
            
            'redirect_prefix' => array(
                'title' => __('Redirect prefix', 'content-egg'),
                'description' => __('Custom prefix for local redirect links.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'alpha_numeric'),
                        'message' => sprintf(__('The field "%s" can contain only Latin letters and digits.', 'content-egg'), __('Redirect prefix', 'content-egg')),
                    ),
                ),
                'section' => __('General settings', 'content-egg'),                               
            ),
            'outofstock_product' => array(
                'title' => __('Out of Stock products', 'content-egg'),
                'description' => __('How to deal with Out of Stock products.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Do nothing', 'content-egg'),
                    'hide_price' => __('Hide price', 'content-egg'),
                    'hide_product' => __('Hide product', 'content-egg'),
                ),
                'default' => '',
                'section' => __('General settings', 'content-egg'),                
            ),
            'from_name' => array(
                'title' => __('From Name', 'content-egg'),
                'description' => __('This name will appear in the From Name column of emails sent from CE plugin.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                ),
                'section' => __('Price alerts', 'content-egg'),
            ),
            'from_email' => array(
                'title' => __('From Email', 'content-egg'),
                'description' => __('Customize the From Email address.', 'content-egg') . ' ' . __('To avoid your email being marked as spam, it is recommended your "from" match your website.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'valid_email'),
                        'message' => sprintf(__('Field "%s" filled with wrong data.', 'content-egg'), 'Email'),
                    ),
                ),
                'section' => __('Price alerts', 'content-egg'),
            ),
            'search_modules' => array(
                'title' => __('Search modules', 'content-egg'),
                'description' => __('Select modules to search on frontend.', 'content-egg') . ' ' .
                __('Do not select more than 1-2 modules.', 'content-egg') . '<br>' .
                __('Please note, AE modules work slowly and are not recommended for use as search modules.', 'content-egg') . '<br>' .
                __('Do not forget to add search widget or shorcode [content-egg-search-form].', 'content-egg'),
                'checkbox_options' => self::getAffiliteModulesList(),
                'callback' => array($this, 'render_checkbox_list'),
                'default' => array(),
                'section' => __('Frontend search', 'content-egg'),
            ),
            'search_page_tpl' => array(
                'title' => __('Search page template', 'content-egg'),
                'description' => __('Template for body of search page.', 'content-egg') . ' ' .
                __('You can use shortcodes, for example: [content-egg module=Amazon template=grid]', 'content-egg'),
                'callback' => array($this, 'render_textarea'),
                'default' => '',
                'section' => __('Frontend search', 'content-egg'),
            ),

            'logos' => array(
                'title' => __('Merchant logos', 'external-importer'),
                'description' => __('You can add your own custom merchant logos.', 'external-importer'),
                'callback' => array($this, 'render_logo_fields_block'),
                'validator' => array(
                    array(
                        'call' => array($this, 'formatLogoFields'),
                        'type' => 'filter',
                    ),
                ),
                'default' => array(),
                'section' => __('Templates', 'content-egg'),                            
            ),
        );
    }

    public static function getDefaultLang()
    {
        $locale = \get_locale();
        $lang = explode('_', $locale);
        if (array_key_exists($lang[0], self::langs()))
            return $lang[0];
        else
            return 'en';
    }

    public function settings_page()
    {
        \wp_enqueue_script('jquery-ui-tabs');
        \wp_enqueue_style('contentegg-admin-ui-css', \ContentEgg\PLUGIN_RES . '/css/jquery-ui.min.css', false, \ContentEgg\application\Plugin::version);

        PluginAdmin::render('settings', array('page_slug' => $this->page_slug()));
    }

    private static function getAffiliteModulesList()
    {
        if (self::$affiliate_modules === null)
        {
            self::$affiliate_modules = ModuleManager::getInstance()->getAffiliteModulesList(false);
        }
        return self::$affiliate_modules;
    }

    public function render_logo_fields_line($args)
    {
        $i = isset($args['_field']) ? $args['_field'] : 0;
        $name = isset($args['value'][$i]['name']) ? $args['value'][$i]['name'] : '';
        $value = isset($args['value'][$i]['value']) ? $args['value'][$i]['value'] : '';

        echo '<input name="' . \esc_attr($args['option_name']) . '['
        . \esc_attr($args['name']) . '][' . $i . '][name]" value="'
        . \esc_attr($name) . '" class="text" placeholder="' . \esc_attr(__('Domain name', 'external-importer')) . '"  type="text"/>';
        echo '<input name="' . \esc_attr($args['option_name']) . '['
        . \esc_attr($args['name']) . '][' . $i . '][value]" value="'
        . \esc_attr($value) . '" class="regular-text ltr" placeholder="' . \esc_attr(__('Logo URL', 'external-importer')) . '"  type="text"/>';
    }

    public function render_logo_fields_block($args)
    {
        if (is_array($args['value']))
            $total = count($args['value']) + 3;
        else
            $total = 3;

        for ($i = 0; $i < $total; $i++)
        {
            echo '<div style="padding-bottom: 5px;">';
            $args['_field'] = $i;
            $this->render_logo_fields_line($args);
            echo '</div>';
        }
        if ($args['description'])
            echo '<p class="description">' . $args['description'] . '</p>';
    }

    public function formatLogoFields($values)
    {
        $results = array();
        foreach ($values as $k => $value)
        {
            $name = trim(\sanitize_text_field($value['name']));
            if ($host = TextHelper::getHostName($values[$k]['name']))
                $name = $host;

            $value = trim(\sanitize_text_field($value['value']));

            if (!$name || !$value)
                continue;

            if (!filter_var($value, FILTER_VALIDATE_URL))
                continue;

            if (in_array($name, array_column($results, 'name')))
                continue;

            $result = array('name' => $name, 'value' => $value);
            $results[] = $result;
        }

        return $results;
    }

}
