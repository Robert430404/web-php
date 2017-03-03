<?php foreach ($announcements as $category => $entries) : ?>
    <div class="panel">
        <a href="/conferences" class="headline" title="<?php echo $conferenceType[$category]; ?>">
            <?php echo $conferenceType[$category]; ?>
        </a>
        <div class="body">
            <ul>
                <?php foreach (array_slice($entries, 0, 4) as $url => $title) :
                $title = preg_replace("'([A-Za-z0-9])([\s\:\-\,]*?)call for(.*?)$'i", "$1", $title); ?>
                <li>
                    <a href='$url' title='$title'>
                        <?php echo $title; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>

<p class="panel"><a href="/cal.php">User Group Events</a></p>
<p class="panel"><a href="/thanks.php">Special Thanks</a></p>
<div class="panel social-media">
    <span class="headline">Social media</span>
    <div class="body">
        <ul>
            <li>
                <a href="https://twitter.com/official_php">
                    <i class="icon-twitter"></i>
                    @official_php
                </a>
            </li>
        </ul>
    </div>
</div>