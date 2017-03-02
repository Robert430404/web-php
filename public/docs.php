<?php

require_once __DIR__ . '/../src/autoloader.php';

$_SERVER['BASE_PAGE'] = 'docs.php';
include_once __DIR__ . '/include/prepend.inc';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('docs', array(
    'MYSITE'       => $MYSITE,
    'pageTitle'    => 'Documentation',
    'headerConfig' => array(
        "current" => "docs",
    ),
    'activeLangs'  => $ACTIVE_ONLINE_LANGUAGES,
    'LANG'         => $LANG,
    'lastlang'     => end($ACTIVE_ONLINE_LANGUAGES),
    'page'         => 'docs',
));