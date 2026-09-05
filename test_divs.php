<?php
$c=file_get_contents('resources/views/admin/voters.blade.php');
echo 'Div: '.substr_count($c, '<div').' EndDiv: '.substr_count($c, '</div');
echo "\n";
$c=file_get_contents('resources/views/admin/teachers.blade.php');
echo 'Div: '.substr_count($c, '<div').' EndDiv: '.substr_count($c, '</div');
