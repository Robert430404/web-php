<?php $this->loadPartial('header'); ?>

    <h1>Documentation</h1>
    <div class="content-box">

        <p>
            The PHP Manual is available online in a selection of languages.
            Please pick a language from the list below.
        </p>

        <p>
            More information about php.net URL shortcuts by visiting our
            <a href="urlhowto.php">URL howto page</a>.
        </p>

        <p>
            Note, that many languages are just under translation, and
            the untranslated parts are still in English. Also some translated
            parts might be outdated. The translation teams are open to
            contributions.
        </p>

        <div class="warning">
            <p>
                Documentation for PHP 4 has been removed from the
                manual, but there is archived version still available. For
                more informations, please read <a href="/manual/php4.php">
                    Documentation for PHP 4</a>.
            </p>
        </div>
    </div>

    <table class="standard">
        <tr>
            <th>Formats</th>
            <th>Destinations</th>
        </tr>
        <tr>
            <th class="sub">View Online</th>
            <td>
                <?php foreach ($activeLangs as $langcode => $langname) : ?>
                    <?php if (!file_exists(__DIR__ . "/../../public/manual/$langcode/index.php")) :
                        continue;
                    endif; ?>
                    <?php if ($langcode == $LANG) : // Make preferred language bold ?>
                        <strong>
                    <?php endif; ?>
                        <a href="/manual/<?php echo $langcode; ?>/"><?php echo $langname; ?></a><?php echo ($lastlang != $langname) ? ",\n" : "\n"; ?>
                    <?php if ($langcode == $LANG) : ?>
                        </strong>
                    <?php endif; ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <th class="sub">Downloads</th>
            <td>
                For downloadable formats, please visit our
                <a href="download-docs.php">documentation downloads</a> page.
            </td>
        </tr>
    </table>

    <h2 class="content-header">More documentation</h2>
    <ul class="content-box listed">
        <li>
            If you are interested in how the documentation is edited and translated,
            you should read the <a href="http://doc.php.net/tutorial/">Documentation HOWTO</a>.
        </li>
        <li>
            <a href="http://gtk.php.net/">PHP-GTK related documentation</a>
            is hosted on the PHP-GTK website.
        </li>
        <li>
            <a href="http://pear.php.net/manual/">Documentation of PEAR and the various
                packages</a> can be found on a separate server.
        </li>
        <li>
            You can still read a copy of the original <a href="/manual/phpfi2.php">PHP/FI
                2.0 Manual</a> on our site, which we only host for historical purposes.
            The same applies to the <a href="/manual/php3.php">PHP 3 Manual</a>, and
            the <a href="/manual/php4.php">PHP 4 Manual</a>.
        </li>
    </ul>

<?php $this->loadPartial('footer'); ?>
