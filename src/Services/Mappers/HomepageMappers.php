<?php

namespace Services\Mappers;

use DateTime;

/**
 * Class HomepageMappers
 *
 * @package Services\Mappers
 */
class HomepageMappers
{
    /**
     * HomepageMappers constructor.
     */
    public function __construct()
    {
    }

    /**
     * Maps the news entries
     *
     * @param $entries
     * @return array
     */
    public function mapNewsEntries($entries)
    {
        //new DateTime($entry['updated']);
        $releasenews = 0;
        $frontpage   = array();

        foreach($entries as $entry) {
            $maybe = false;

            foreach($entry["category"] as $category) {
                if ($category["term"] == "releases") {
                    if ($releasenews++ > 5) {
                        continue 2;
                    }
                }
                if ($category["term"] == "frontpage") {
                    $maybe = $entry;
                }
            }
            if ($maybe) {
                $maybe['striped_link']     = str_replace('http://php.net/', '', $entry["id"]);
                $maybe['parsed_id']        = parse_url($entry["id"], PHP_URL_FRAGMENT);
                $maybe['updated_date_obj'] = new DateTime($entry['updated']);

                $frontpage[]           = $maybe;
            }
        }

        return $frontpage;
    }

    /**
     * Maps the announcements
     *
     * @param $rawAnnouncements
     * @return string
     */
    public function mapAnnouncements($rawAnnouncements)
    {
        if (is_array($rawAnnouncements)) {
            $conftype     = array(
                'conference' => 'Upcoming conferences',
                'cfp'        => 'Conferences calling for papers',
            );
            $announcements = "";

            foreach($rawAnnouncements as $category => $entries) {
                if ($entries) {
                    $announcements .= '
                      <div class="panel">
                        <a href="/conferences" class="headline" title="' . $conftype[$category] . '">'
                          . $conftype[$category] .
                        '</a>
                        <div class="body">
                          <ul>';

                    foreach (array_slice($entries, 0, 4) as $url => $title) {
                        $title          = preg_replace("'([A-Za-z0-9])([\s\:\-\,]*?)call for(.*?)$'i", "$1", $title);
                        $announcements .= "
                          <li>
                            <a href='$url' title='$title'>
                              $title
                            </a>
                          </li>";
                    }

                    $announcements .= '
                        </ul>
                      </div>
                    </div>';
                }
            }
        } else {
            $announcements = '';
        }

        return $announcements;
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