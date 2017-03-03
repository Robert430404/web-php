<div class="row clearfix">
    <div class="blurb">
        <p>PHP is a popular general-purpose scripting language that is especially suited to web development.</p>
        <p>Fast, flexible and pragmatic, PHP powers everything from your blog to the most popular websites in the
            world.</p>
    </div>
    <div class="download">
        <h3>Download</h3>
        <ul>
            <?php foreach (get_active_branches() as $major => $releases) : ?>
                <?php foreach ((array)$releases as $release) :

                    $version                 = $release['version'];
                    list($major, $minor, $_) = explode('.', $version);
                ?>
                    <li>
                        <a class='download-link' href='/downloads.php#v<?php echo $version; ?>'>
                            <?php echo $version; ?>
                        </a>
                        <span class='dot'>&middot;</span>
                        <a class='notes' href='/ChangeLog-<?php echo $major; ?>.php#<?php echo $version; ?>'>
                            Release Notes
                        </a>
                        <span class='dot'>&middot;</span>
                        <a class='notes' href='/migration<?php echo $major; echo $minor; ?>'>
                            Upgrading
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>