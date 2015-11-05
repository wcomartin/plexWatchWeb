<?php

$database = dbconnect();
$plexWatchDbTable = dbTable();

$query = "SELECT " .
		"strftime('%Y-%m-%d %H', datetime(time, 'unixepoch', 'localtime')) as date, " .
		"COUNT(title) as count ".
	"FROM $plexWatchDbTable " .
	"WHERE datetime(time, 'unixepoch', 'localtime') >= " .
		"datetime('now', '-24 hours', 'localtime') " .
	"GROUP BY strftime('%Y-%m-%d %H', datetime(time, 'unixepoch', 'localtime')) " .
	"ORDER BY date ASC;";
$hourlyPlays = getResults($database, $query);
$hourlyPlayData = array();
while ($row = $hourlyPlays->fetch(PDO::FETCH_ASSOC)) {
	$hourlyPlayData[] = array('x'=>$row['date'], 'y'=>(int) $row['count']);
}

$query = "SELECT " .
		"strftime('%Y-%m-%d %H', datetime(time, 'unixepoch', 'localtime')) as date, " .
		"COUNT(title) as count " .
	"FROM $plexWatchDbTable " .
	"GROUP BY strftime('%Y-%m-%d %H', datetime(time, 'unixepoch', 'localtime')) " .
	"ORDER BY count(*) desc " .
	"LIMIT 25;";
$maxhourlyPlays = getResults($database, $query);
$maxhourlyPlayData = array();
while ($row = $maxhourlyPlays->fetch(PDO::FETCH_ASSOC)) {
	$maxhourlyPlayData[] = array('x'=>$row['date'], 'y'=>(int) $row['count']);
}

$query = "SELECT " .
		"date(time, 'unixepoch','localtime') as date, " .
		"COUNT(title) as count " .
	"FROM $plexWatchDbTable " .
	"GROUP BY date " .
	"ORDER BY time DESC " .
	"LIMIT 30;";
$dailyPlays = getResults($database, $query);
$dailyPlayData = array();
while ($row = $dailyPlays->fetch(PDO::FETCH_ASSOC)) {
	$dailyPlayData[] = array('x'=>$row['date'], 'y'=>(int) $row['count']);
}

$query = "SELECT " .
		"strftime('%Y-%m', datetime(time, 'unixepoch', 'localtime')) as date, " .
		"COUNT(title) as count " .
	"FROM $plexWatchDbTable " .
	"WHERE datetime(time, 'unixepoch', 'localtime') >= " .
		"datetime('now', '-12 months', 'localtime') " .
	"GROUP BY strftime('%Y-%m', datetime(time, 'unixepoch', 'localtime')) " .
	"ORDER BY date DESC " .
	"LIMIT 13;";
$monthlyPlays = getResults($database, $query);
$monthlyPlayData = array();
while ($row = $monthlyPlays->fetch(PDO::FETCH_ASSOC)) {
	$monthlyPlayData[] = array('x'=>$row['date'], 'y'=>(int) $row['count']);
}

echo json_encode([
  'HourlyPlayData' => $hourlyPlayData,
  'MaxHourlyPlayData' => $maxhourlyPlayData,
  'DailyPlayData' => $dailyPlayData,
  'MonthlyPlayData' => $monthlyPlayData
  ]);
