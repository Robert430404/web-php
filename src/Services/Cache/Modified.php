<?php

namespace Services\Cache;

/**
 * Class NotModified
 *
 * @package Services\Cache
 */
class Modified
{
    /**
     * NotModified constructor.
     */
    public function __construct()
    {
    }

    /**
     * Check if the client has the same page cached, if no,
     * inform the user agent what is our last modification date
     *
     * @param $timeStamp
     * @return void
     */
    public function checkModifiedHeaders($timeStamp)
    {
        if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) && ($_SERVER["HTTP_IF_MODIFIED_SINCE"] == $timeStamp)) {
            header("HTTP/1.1 304 Not Modified");
            exit();
        } else {
            header("Last-Modified: " . $timeStamp);
        }
    }
}