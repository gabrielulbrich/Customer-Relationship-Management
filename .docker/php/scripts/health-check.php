<?php

$response = array(
  'status' => 'ok'
);

header('Content-type: application/json');
echo json_encode($response); 