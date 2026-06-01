<?php
defined('ABSPATH') || exit;

define('DESQ_VERSION', '1.0.0');
define('DESQ_DIR', get_template_directory());
define('DESQ_URI', get_template_directory_uri());

require_once DESQ_DIR . '/inc/setup.php';
require_once DESQ_DIR . '/inc/enqueue.php';
require_once DESQ_DIR . '/inc/cpt.php';
require_once DESQ_DIR . '/inc/acf.php';
require_once DESQ_DIR . '/inc/options.php';
