<?php

require_once __DIR__ . '/../src/autoloader.php';
include_once __DIR__ . '/include/prepend.inc';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('getInvolved', array(
    'MYSITE'       => $MYSITE,
    'pageTitle'    => 'Get Involved',
    'headerConfig' => array(
        "current" => "community",
    ),
    'footerConfig' => array(
        'sidebar' => true,
    ),
    'shortname'    => false,
    'page'         => 'get-involved.php',
));
