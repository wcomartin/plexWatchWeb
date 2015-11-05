<?php

require_once(dirname(__FILE__) . '/includes/functions.php');

header('Content-Type: application/json');

$PMSdieMsg = "Failed to access Plex Media Server. Please check your settings.";

include(dirname(__FILE__) . '/json/' . $_GET['resource'] . '.php');
