<?php

$page = ( $_GET['page'] ? $_GET['page'] : '0');
$pageSize = ( $_GET['pageSize'] ? $_GET['pageSize'] : '25');

$arr = [];

$plexWatchDbTable = dbTable();
$database = dbconnect();
$query = "SELECT * FROM " . $plexWatchDbTable . " ORDER BY id DESC LIMIT " . $page . ", " . $pageSize;
$results = getResults($database, $query);
while($row = $results->fetch(PDO::FETCH_ASSOC)){
  $arr[] = $row;
}

echo json_encode($arr);
