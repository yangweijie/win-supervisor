<?php
declare (strict_types = 1);

namespace app\index\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class SupervisorApps extends Model
{
    //

    public static function getBin($command){
        $command_arr = explode(' ', $command);
        $bin = [];
        foreach ($command_arr as $k => $v) {
            $bin []= $v;
            if(in_array(pathinfo($v, PATHINFO_EXTENSION), ['exe', 'php'])){
                break;
            }
        }
        $bin = implode(' ', $bin);
        return $bin;
    }
}
