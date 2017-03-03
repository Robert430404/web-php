<?php

namespace Services\Templating;

/**
 * Class Renderer
 *
 * @package Services\Templating
 */
class Renderer
{
    private $viewVariables;

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
        $this->viewVariables = $variables;

        extract($this->viewVariables, EXTR_SKIP);
        ob_start();
        include_once __DIR__ . '/../../Views/' . $template . '.php';
        ob_end_flush();
    }

    /**
     * Loads A Partial
     *
     * @param $partial
     * @return mixed
     */
    public function loadPartial($partial)
    {
        extract($this->viewVariables, EXTR_SKIP);
        include_once __DIR__ . '/../../Views/Partials/' . $partial . '.php';
    }
}