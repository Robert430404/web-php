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