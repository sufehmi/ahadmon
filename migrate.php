<?php

$output = '';
exec('protected/yiic migrate', $output);
foreach ($output as $row) {
    echo $row . '<br />';
}

