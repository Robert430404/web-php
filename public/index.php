<?php // vim: et

require_once __DIR__ . '/../src/autoloader.php';
include_once __DIR__ . '/include/pregen-news.inc';
include_once __DIR__ . '/include/pregen-confs.inc';
include_once __DIR__ . '/include/prepend.inc';
include_once __DIR__ . '/include/branches.inc';
include_once __DIR__ . '/include/version.inc';

use Services\Cache\Modified;
use Services\Mappers\HomepageMappers;
use Services\Templates\Renderer;

$renderer = new Renderer();
$mapper   = new HomepageMappers();
$modified = new Modified();

$frontpage     = $mapper->mapNewsEntries($NEWS_ENTRIES);
$announcements = $mapper->mapAnnouncements($CONF_TEASER);
$tsstring      = $mapper->getTimestampString();

$modified->checkModifiedHeaders($tsstring);

$_SERVER['BASE_PAGE'] = 'index.php';

mirror_setcookie("LAST_NEWS", $_SERVER["REQUEST_TIME"], 60*60*24*365);

$renderer->render('homepage.php', array(
    'MYSITE'        => $MYSITE,
    'frontpage'     => $frontpage,
    'announcements' => $announcements,
    'footerConfig'  => array(
        "atom"       => "/feed.atom", // Add a link to the feed at the bottom
        'elephpants' => true,
        'sidebar'    => true
    ),
));
