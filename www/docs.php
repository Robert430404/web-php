<?php

require_once __DIR__ . '/../src/autoloader.php';
include_once __DIR__ . '/include/prepend.inc';

use Services\Templating\Renderer;

$renderer = new Renderer();

$renderer->render('docs', array(
    'MYSITE'       => $MYSITE,
    'pageTitle'    => 'Documentation',
    'headerConfig' => array(
        "current" => "docs",
    ),
    'shortname'    => false,
    'activeLangs'  => $ACTIVE_ONLINE_LANGUAGES,
    'LANG'         => $LANG,
    'lastlang'     => end($ACTIVE_ONLINE_LANGUAGES),
    'page'         => 'docs.php',
));