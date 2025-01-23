<?php
$htmlString = "hello &amp; welcome to &lt;PHP&gt; programming!";
$decodedstring = html_entity_decode($htmlString);
echo $decodedstring;

?>
