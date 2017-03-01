<?php // vim: et

require_once __DIR__ . '/../src/autoloader.php';    // Autoload Classes

include_once __DIR__ . '/include/pregen-news.inc';
include_once __DIR__ . '/include/pregen-confs.inc';
include_once __DIR__ . '/include/prepend.inc';
include_once __DIR__ . '/include/branches.inc';
include_once __DIR__ . '/include/version.inc';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('homepage.php', array(
    'NEWS_ENTRIES' => $NEWS_ENTRIES,
    'CONF_TEASER'  => $CONF_TEASER,
    'MYSITE'       => $MYSITE
));