<?php

namespace Services\Templates;

/**
 * Class Renderer
 *
 * @package Services\Templates
 */
class Renderer
{
    /**
     * Renderer constructor.
     */
    public function __construct()
    {
    }

    /**
     * Renders A Provided View
     *
     * @param $template
     * @param array $variables
     */
    public function render($template, $variables = array())
    {
        extract($variables, EXTR_SKIP);

        ob_start();

        include_once __DIR__ . '/../../Views/' . $template . '.php';

        ob_end_flush();
    }
}