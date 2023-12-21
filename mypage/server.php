<?php
$data = json_decode(file_get_contents('php://input'), true);

$bookTitle = $data['name'] ?? '';
$bookImg = $data['image'] ?? '';