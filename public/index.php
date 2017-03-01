<?php // vim: et

require_once __DIR__ . '/../src/autoloader.php';

use Services\Templates\Renderer;

$renderer = new Renderer();

$renderer->render('homepage.php');