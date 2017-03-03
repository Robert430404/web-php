<?php

require_once __DIR__ . '/../src/autoloader.php';
include_once __DIR__ . '/include/prepend.inc';
include_once __DIR__ . '/include/gpg-keys.inc';
include_once __DIR__ . '/include/version.inc';

use Services\Templates\Renderer;
use Services\Cache\Modified;

$renderer = new Renderer();
$modified = new Modified();

$modified->disablePublicCache();
$renderer->render('downloads', array(
    'MYSITE'       => $MYSITE,
    'RELEASES'     => $RELEASES,
    'pageTitle'    => 'Downloads',
    'SHOW_COUNT'   => 4,
    'headerConfig' => array(
        'link' => array(
            array(
                "rel"   => "alternate",
                "type"  => "application/atom+xml",
                "href"  => $MYSITE . "releases/feed.php",
                "title" => "PHP Release feed"
            ),
        ),
        "current" => "downloads",
    ),
    'footerConfig' => array(
        'sidebar' => true,
    ),
    'shortname'    => false,
    'page'         => 'downloads.php',
));