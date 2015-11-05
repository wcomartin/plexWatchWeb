<?php

$arr = [];

$statusSessions = simplexml_load_string(getPmsData('/status/sessions')) or die ($PMSdieMsg);

foreach ($statusSessions->children() as $recentXml) {
  $obj = (array)$recentXml->attributes();
  $arr[] = $obj['@attributes'];
}

echo json_encode($arr);
