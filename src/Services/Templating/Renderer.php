<?php

namespace Services\Templating;

/**
 * Class Renderer
 *
 * This class is designed to standardize the procedure of loading
 * view file from the "controller" what ever that may be. This
 * gives us a consistent method of presenting content.
 *
 * @package Services\Templating
 */
class Renderer
{
    /**
     * This contains the variables that were passed to the view
     * These are persisted so in loadPartial, they can be re
     * extracted for use in partial views.
     *
     * @var array
     */
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
     * This method is meant to be called once via the entry point
     * of the script. As of now that means the script that gets
     * hit inside of the www folder when the request is made.
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
     * This method is meant to be called from within View scripts.
     * This allows all output to be buffered before the output
     * is sent to the user.
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