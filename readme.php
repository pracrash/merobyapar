<?php
    function osc_getRelativeWebURL() {
        $url = $_SERVER['REQUEST_URI'];
        $pos = strpos($url, '/oc-installer');
        return substr($url, 0, strpos($url, '/oc-installer'));
    }

    function osc_getAbsoluteWebURL() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . osc_getRelativeWebURL();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en-US">
    <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>OSClass - Readme</title>
            <link rel="stylesheet" type="text/css" media="all" href="oc-includes/osclass/installer/install.css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="container">
                <div id="header" class="readme">
                    <h1 id="logo">
                        <a href="http://osclass.org/" target="_blank">
                            <img src="oc-includes/images/osclass-logo.png" alt="OSClass" title="OSClass" />
                        </a>
                        <br/>
                        Version 3.0
                    </h1>
                </div>
                <div id="content">
                    <div id="introduction">
                        <h2 class="title">Introduction</h2>
                        <div class="space-left-10">
                            <p>
                                OSClass is an open source project for classifieds. In a few steps you can build
                                a classified site. Some features: easy installation, multi-language, extensibility through plugins,
                                search engines friendly (sitemap, robots, urls seo-friendly) and a lot more features.
                            </p>
                        </div>
                    </div>
                    <div id="install">
                        <h2 class="title">Installation</h2>
                        <div class="space-left-10">
                            <p>Here’s a quick step-by-step guide of the installation process:</p>
                            <ol>
                                <li>Download and unzip the OSClass package.</li>
                                <li>Move the OSClass unzipped files to the desired location on your server.</li>
                                <li>Execute the OSClass installation script by accessing <code>oc-includes/osclass/install.php</code> from your browser:
                                    <ul>
                                        <li>If you’ve installed it in the domain’s root directory, you’ll have to go to: <code>http://example.com/oc-includes/osclass/install.php</code></li>
                                        <li>If you’ve installed it in a subdirectory inside the domain, <em>classifieds</em>, for example, go to: <code>http://example.com/classifieds/oc-includes/osclass/install.php</code></li>
                                    </ul>
                                </li>
                                <li>Follow the installer’s instructions:
                                    <ul>
                                        <li>First of all, make sure the server has the required permissions to write in the files and directories specified. This will allow you to create a basic configuration file as well as upload images, documents, etc.</li>
                                        <li>Step 1: Add your access details to the database. If you haven’t created it yet, the installer will ask for another account with permissions that allows it to do it for you.</li>
                                        <li>Step 2: Add the basic installation details and select your classfieds site’s reach: international, local, regional…</li>
                                        <li>Step 3: Choose the categories you want to use on your site. If you don’t select a category, you’ll have to add it later from your admin panel.</li>
                                        <li>Your installation is finished! Use the automatically generated password to access your admin panel (/oc-admin).</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </div>
                     <div id="upgrade">
                        <h2 class="title">How to upgrade</h2>
                        <p>
                            OSClass will show an autoupgrade message at admin panel if a new (and stable) version is available. Only need follow instructions for begin the upgrade.
                            We recommend to do a backup before you attempt to upgrade your OSClass installation, you could perform that from the admin panel (if you modified any
                            core file, it will probably be replaced by new version software. Be carefull).
                        </p>
                        <div class="space-left-10"><h3 style="border-bottom: 1px solid grey;color: #444444;">Autoupgrade</h3>
                            <p>The Autoupgrade feature will perform the following steps for you :
                                <ul>
                                    <li>Step 1: Check if there's a new version os OSClass.</li>
                                    <li>Step 2: Download it.</li>
                                    <li>Step 3: Unzip it.</li>
                                    <li>Step 4: Remove old files, copy new ones (remember: if you edited any core file, it will probable be replaced by a new one).</li>
                                    <li>Step 5: Perform changes in the tables (if necessary).</li>
                                    <li>Step 6: Perform extra-actions (if necessary).</li>
                                </ul>
                            </p>
                         </div>
                        <p>Follow the link and after a few moments you will be enjoying
                            a new version of your favorite open source classifieds software. Had you expected more steps or difficult instructions? Sorry! but we made that easy.
                        </p>
                        <div class="space-left-10"><h3 style="border-bottom: 1px solid grey;color: #444444;">Manual upgrade</h3>
                            <p>
                                You could also upgrade OSClass downloading the upgrade package, unzip it and replace the files on your server with the ones on the package.
                                Then run manually oc-includes/osclass/upgrade-funcs.php for do upgrade complete.
                            </p>
                        </div>
                        <p>If you experienced any problem during the process, please don't hesitate in contact us in <a href="http://forums.osclass.org/">OSClass Support Forums</a>.
                            We recommend to perform a backup of database and files before each upgrade. You could backup your data from the "Backup" option in the admin panel.
                            If you want to run the autoupgrade manually you could do that from the following URL : http://www.yourdomain.com/path/to/osclass/oc-admin/tools.php?action=upgrade
                        </p>
                    </div>
                    <div id="resources">
                        <h2 class="title">Online Resources</h2>
                        <div class="space-left-10">
                            <p>If you have any questions that aren't addressed in this document, please look at the online resources:</p>
                            <dl class="space-left-25">
                                <dt><a href="http://doc.osclass.org/" target="_blank">OSClass Wiki</a></dt>
                                <dd>
                                    The wiki is where all information about OSClass is placed.
                                </dd>
                                <dt><a href="http://osclass.org/blog/" target="_blank">OSClass Blog</a></dt>
                                <dd>
                                    This is where you'll find the latest updates and news related to OSClass.
                                </dd>
                                <dt><a href="http://forums.osclass.org/" target="_blank">OSClass Support Forums</a></dt>
                                <dd>
                                    If you've looked everywhere and still can't find an answer.
                                    To help them help you be sure to use a descriptive thread title
                                    and describe your question in as much detail as possible.
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div id="license">
                        <h2 class="title">License</h2>
                        <p class="space-left-10">OSClass is released under the GPLv3 (see <a href="licenses.txt" target="_blank">licenses.txt</a>).</p>
                    </div>
                </div>
                <div id="footer">
                    <ul>
                        <li><a href="http://admin.osclass.org/feedback.php" target="_blank">Feedback</a></li>
                        <li><a href="http://forums.osclass.org/index.php" target="_blank">Forums</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>