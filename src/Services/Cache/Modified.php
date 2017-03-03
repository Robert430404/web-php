<?php

namespace Services\Cache;

/**
 * Class NotModified
 *
 * This class is designed to standardize the procedure of caching
 * view files from the "controller" what ever that may be. This
 * gives us a consistent method of caching content.
 *
 * @package Services\Cache
 */
class Modified
{
    /**
     * Modified constructor.
     */
    public function __construct()
    {
    }

    /**
     * Checks your modified headers
     *
     * This method checks if the client has the same page cached locally,
     * if no, inform the user agent of our last modification date and
     * cache the page locally.
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

    /**
     * Attempts to disable local caching on the page its called.
     *
     * This method tries to disable the local caching for the page this
     * is called on.
     *
     * @return void
     */
    public function disablePublicCache()
    {
        header("Cache-Control: private");
        header("Pragma: no-cache");
    }

    /**
     * Returns the timestamp string in GMD format
     *
     * Note that this is not a RFC 822 date (the tz is always GMT)
     *
     * @return string
     */
    public function getTimestampString()
    {
        $timestamps = $this->mapTimestamps();
        $timestamp  = max($timestamps);

        return gmdate("D, d M Y H:i:s ", $timestamp) . "GMT";
    }

    /**
     * Maps the time stamps
     *
     * This is used to get the latest modified date for the caching
     * method.
     *
     * @return array
     */
    private function mapTimestamps()
    {
        $timestamps = array();

        // Get the modification date of the index
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/index.php");

        /*
           The date of prepend.inc represents the age of ALL
           included files. Please touch it if you modify any
           other include file (and the modification affects
           the display of the index page). The cost of stat'ing
           them all is prohibitive.
        */
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/include/prepend.inc");

        // These are the only dynamic parts of the frontpage
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/include/pregen-confs.inc");
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/include/pregen-news.inc");
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/include/version.inc");
        $timestamps[] = @filemtime(__DIR__ . "/../../../public/js/common.js");

        return $timestamps;
    }
}