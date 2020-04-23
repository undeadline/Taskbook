<?php

namespace Zombie;

class View
{
    /**
     * Template name
     *
     * @var string
     */
    private $view;

    /**
     * Variables is used in template
     *
     * @var array
     */
    private $params;

    /**
     * Response status code
     *
     * @var int
     */
    private $status;

    /**
     * View constructor.
     * @param int $status
     * @param string $view
     * @param array $params
     */
    public function __construct(int $status, string $view, array $params = [])
    {
        $this->view = $view;
        $this->params = $params;
        $this->status = $status;

        $this->getTemplate();
    }

    /**
     *  Buffering template and include variables
     */
    private function getTemplate()
    {
        $view = Config::get('basepath') . "/views/$this->view" . '.php';
        if (file_exists($view)) {
            ob_start();
            extract($this->params);
            require_once $view;
        }
    }
}