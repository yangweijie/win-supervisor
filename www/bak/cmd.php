<?php
set_time_limit(0);
$file = __DIR__.'/log.log';
$loops = range(1,1000);
// file_put_contents($file, var_export($loops, true));
foreach ($loops as $key => $int) {
    file_put_contents($file, date('Y-m-d H:i:s').PHP_EOL, FILE_APPEND);
    sleep(1);
}
