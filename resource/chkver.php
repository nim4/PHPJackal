<?php
error_reporting(0);
$LAST='3.1.0';
if($_GET['v']==$LAST){echo'<strong>You have the latest version.</strong>';} 
else {
echo '<strong>Your version is outdated!</strong> Last version is <strong>2.0.3</strong>.
<br /><br />New in '.$LAST.': <br />
<ul>
<li>More safe-mode bypass methods</li>
<li>Script is more configurable</li>
<li>Better interface</li>
</ul>
<br /> You can get latest version from <a href="http://'.$_SERVER['HTTP_HOST'].'/download.php?file=PHPJackal.php.gz" target="_blank">http://'.$_SERVER['HTTP_HOST'].'/download.php?file=PHPJackal.php.gz</a>.
';
}
?>
