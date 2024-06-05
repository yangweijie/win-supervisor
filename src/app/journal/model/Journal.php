<?php

namespace app\journal\model;

use think\Model;

class Journal extends Model
{
    protected $name = 'journal';

  	// 自动写入时间戳
    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat         = 'Y-m-d H:i:s';

    protected $type = [
        'rule'    =>  'json',
    ];

}
