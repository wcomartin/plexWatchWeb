<?php

$arr = [];

$database = dbconnect();
$query = "SELECT count(DISTINCT user) as users FROM processed";
$results = getResults($database, $query);
$users = $results->fetchColumn();

$arr[] = [
  "name" => "Users",
  "value" => (int)$users
];

$sections = simplexml_load_string(getPmsData('/library/sections')) or die ($PMSdieMsg);

foreach ($sections->children() as $section) {

  if (($section['type'] == 'movie') || ($section['type'] == 'artist'))  {

    $sectionDetails = simplexml_load_string(getPmsData('/library/sections/' . $section['key'] . '/all?X-Plex-Container-Start=0&X-Plex-Container-Size=0')) or die ($PMSdieMsg);

    $arr[] = [
      "name" => (string)$section["title"],
      "value" => (int)$sectionDetails["totalSize"]
    ];

  } else if ($section['type'] == "show") {

    $sectionDetails = simplexml_load_string(getPmsData('/library/sections/' . $section['key'] . '/all?type=2&X-Plex-Container-Start=0&X-Plex-Container-Size=0')) or die ($PMSdieMsg);

    $tvEpisodeCount = simplexml_load_string(getPmsData('/library/sections/' . $section['key'] . '/all?type=4&X-Plex-Container-Start=0&X-Plex-Container-Size=0')) or die ($PMSdieMsg);

    // Cut ' Shows' from the end of the title
    if (strlen($section['title']) > 6 && strcmp(' Shows', substr($section['title'], -6)) == 0) {
      $title = substr($section['title'], 0, -6);
    } else {
      $title = $section['title'];
    }

    $arr[] = [
      "name" => $title . " Shows",
      "value" => (int)$sectionDetails["totalSize"]
    ];
    $arr[] = [
      "name" => $title . " Episodes",
      "value" => (int)$tvEpisodeCount["totalSize"]
    ];

  }

}

$playsquery = "SELECT count(*) FROM processed";
$playsresults = getResults($database, $playsquery);
$plays = $playsresults->fetchColumn();

$arr[] = [
  "name" => "Total Plays",
  "value" => (int)$plays
];

echo json_encode($arr);
