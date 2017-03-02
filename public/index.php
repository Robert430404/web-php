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
    'pageTitle'     => 'Hypertext Preprocessor',
    'headerConfig'  => array(
        'current' => 'home',
        'headtags' => array(
            '<link rel="alternate" type="application/atom+xml" title="PHP: Hypertext Preprocessor" href="' . $MYSITE . 'feed.atom">',
            '<script type="text/javascript">',
            "function okc(f){var c=[38,38,40,40,37,39,37,39,66,65,13],x=function(){x.c=x.c||Array.apply({},c);x.r=function(){x.c=null};return x.c},h=function(e){if(x()[0]==(e||window.event).keyCode){x().shift();if(!x().length){x.r();f()}}else{x.r()}};window.addEventListener?window.addEventListener('keydown',h,false):document.attachEvent('onkeydown',h)}",
            "okc(function(){if(document.getElementById){i=document.getElementById('phplogo');i.src='".$MYSITE."images/php_konami.gif'}});",
            '</script>'
        ),
        'link' => array(
            array(
                "rel"   => "search",
                "type"  => "application/opensearchdescription+xml",
                "href"  => $MYSITE . "phpnetimprovedsearch.src",
                "title" => "Add PHP.net search"
            ),
            array(
                "rel"   => "alternate",
                "type"  => "application/atom+xml",
                "href"  => $MYSITE . "releases/feed.php",
                "title" => "PHP Release feed"
            ),

        ),
        'css'   => array('home.css'),
        'intro' => true
    ),
    'footerConfig'  => array(
        "atom"       => "/feed.atom", // Add a link to the feed at the bottom
        'elephpants' => true,
        'sidebar'    => true
    ),
));
