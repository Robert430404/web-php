<?php

require_once __DIR__ . '/../src/autoloader.php';

$_SERVER['BASE_PAGE'] = 'docs.php';
include __DIR__ . '/include/prepend.inc';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('docs', array(
    'MYSITE'        => $MYSITE,
    'pageTitle'     => 'Documentation',
    'headerConfig'  => array(
        "current" => "docs",
    ),
    'ACTIVE_ONLINE_LANGUAGES' => $ACTIVE_ONLINE_LANGUAGES,
    'LANG' => $LANG,
));