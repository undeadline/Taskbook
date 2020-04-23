<?php

namespace Zombie;

class Response
{
    /**
     * Return template
     */
    public function view()
    {
        header('Content-Type: text/html');

        ob_end_flush();

        unset($_SESSION['errors']);
        unset($_SESSION['success']);
    }

    /**
     * Redirect on specified url
     *
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }

    /**
     * Redirect on specified url and put errors for next request
     *
     * @param $url
     * @param $errors
     */
    public function redirectWithErrors($url, $errors)
    {
        $_SESSION['errors'] = $errors;

        header('Location: ' . $url);
    }

    /**
     * Set status for response
     *
     * @param int $code
     * @return $this
     */
    public function status(int $code)
    {
        http_response_code($code);

        return $this;
    }
}