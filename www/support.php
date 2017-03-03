<?php
// $Id$
$_SERVER['BASE_PAGE'] = 'support.php';

require_once __DIR__ . '/../src/autoloader.php';
include_once __DIR__ . '/include/prepend.inc';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('support', array(
    'MYSITE'       => $MYSITE,
    'pageTitle'    => 'Getting Help',
    'headerConfig' => array(
        'current' => 'help',
    ),
    'footerConfig' => array(
        'sidebar' => true,
    ),
    'page'         => 'support.php',
));