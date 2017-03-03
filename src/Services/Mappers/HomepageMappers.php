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

                $frontpage[] = $maybe;
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
            $conferenceType = array(
                'conference' => 'Upcoming conferences',
                'cfp'        => 'Conferences calling for papers',
            );
            $announcements  = "";

            foreach($rawAnnouncements as $category => $entries) {
                if ($entries) {
                    $announcements .= '
                      <div class="panel">
                        <a href="/conferences" class="headline" title="' . $conferenceType[$category] . '">'
                          . $conferenceType[$category] .
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
}