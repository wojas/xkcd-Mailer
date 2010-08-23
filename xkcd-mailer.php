<?php
    /**
     * xkcd-Mailer
     *
     * Sends HTML-email containing hotlinked latest xkcd
     * strip with alt/title-text underneath the image.
     *
     * @author Ismo Vuorinen
     * @version $Id$
     * @license http://www.opensource.org/licenses/mit-license.php The MIT License
     * @copyright 23 August, 2010
     * @package default
     **/
    
    // Your timezone, PHP5 required.
    date_default_timezone_set("Europe/Helsinki");
    
    // Your destination
    $mail = "ivuorinen@gmail.com";
    $from = "xkcd mailer <xkcdmailer@example.com>";

    $feed = "http://xkcd.com/atom.xml";
    $data = simplexml_load_file($feed);
    $item = $data->entry[0];
    $date = date("Y-m-d", strtotime($item->updated));
    preg_match("#title=\"(.+)\"#iU", $item->summary, $t);

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: '. $from . "\r\n";

    $subject    = "xkcd {$date}: {$item->title}";
    $punchline  = $t[1];

    $msg = "<h1><a href=\"{$item->id}\">{$item->title}</a></h1>\n"
        . "<small>Posted {$date}</small><br />\n"
        . $item->summary."<br />\n"
        . "<p>{$punchline}</p>\n";

    mail($mail, $subject, $msg, $headers);