<?php
    class WBS_Loader
    {
        public static function loadWbs($pluginFile)
        {
            if (!self::$loaded)
            {
                self::$loaded = true;
                new WBS_Loader($pluginFile);
            }
        }

        public function __construct($pluginFile)
        {
            $this->pluginFile = wp_normalize_path($pluginFile);
            add_action('plugins_loaded', array($this, 'load'), 0);
            add_filter('plugin_action_links_' . plugin_basename($this->pluginFile), array($this, '_outputSettingsLink'));
        }

        public function load()
        {
            if (!$this->woocommerceAvailable()) return;
            $this->loadLanguage();
            $this->loadFunctions();
            $this->loadClasses();
            WBS_Profile_Manager::setup();
            WBS_Upgrader::setup($this->pluginFile);
        }

        public function _outputSettingsLink($links)
        {
            array_unshift($links, '<a href="'.esc_html(WbsRuleUrls::generic()).'">'.__('Settings', 'woowbs').'</a>');
            return $links;
        }

        public function _loadClass($class)
        {
            foreach ($this->classDirs as $dir) {
                if (file_exists($file = "{$dir}/{$class}.php")) {
                    require_once($file);
                    return true;
                }
            }

            if (in_array($class, array('WBS_Shipping_Rate_Override', 'WBS_Shipping_Class_Override_Set'))) {
                require_once($this->legacyClassesFile);
            }

            return false;
        }

        private static $loaded;
        private $pluginFile;
        private $classDirs;
        private $legacyClassesFile;

        private function woocommerceAvailable()
        {
            return class_exists('WC_Shipping_Method');
        }

        private function loadLanguage()
        {
            load_plugin_textdomain('woowbs', false, dirname(plugin_basename($this->pluginFile)).'/lang/');
        }

        private function loadFunctions()
        {
            require_once(dirname(__FILE__) . "/functions.php");
        }

        private function loadClasses()
        {
            $wbsdir = dirname(__FILE__);
            $this->classDirs = array($wbsdir, "{$wbsdir}/Model", "{$wbsdir}/Upgrade");
            $this->legacyClassesFile = "{$wbsdir}/legacy.php";
            spl_autoload_register(array($this, '_loadClass'));
        }
    }