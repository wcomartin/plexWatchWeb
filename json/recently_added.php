<?php

$arr = [];

$limit = ($_GET['limit'] ? $_GET['limit'] : '10');

$recentRequest = simplexml_load_string(getPmsData(
  '/library/recentlyAdded?X-Plex-Container-Start=0&X-Plex-Container-Size=' . $limit)) or die($PMSdieMsg);

foreach ($recentRequest->children() as $recentXml) {
  $obj = (array)$recentXml->attributes();
  $arr[] = $obj['@attributes'];
}

echo json_encode($arr);
