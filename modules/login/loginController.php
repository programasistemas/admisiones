<?php

require_once '../../php/includes/routes.config.inc.php';
require_once RESPONSES_PATH;
require_once QUERY_MANAGER_PATH;

$response = generateResponse();
$queryManager = new QueryManager();
$queryManager->fetchData('', [['name' => 'email'], ['name' => 'password']]);
