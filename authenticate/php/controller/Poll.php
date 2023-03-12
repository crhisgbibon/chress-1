<?php

$previousState = (int)$_POST["data"][0];

$waitCount = 0;
$sleep = 3;

do {
  sleep($sleep);
  $waitCount += $sleep;
  $pollData = rand(0,1);
  $newState = $pollData;
} while ($newState == $previousState);

$output = [$newState, $waitCount];

echo json_encode($output);