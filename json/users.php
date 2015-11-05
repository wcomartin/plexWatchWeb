<?php

$arr = [];

$database = dbconnect();
$plexWatchDbTable = dbTable('user');

$query = "SELECT COUNT(title) as plays, user, time, platform, ip_address, xml FROM $plexWatchDbTable GROUP BY user ORDER BY user COLLATE NOCASE";
$results = getResults($database, $query);

while($row = $results->fetch(PDO::FETCH_ASSOC)){
  unset($row['xml']);
  $arr[] = $row;
}

echo json_encode($arr);
