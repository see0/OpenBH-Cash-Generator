<?php
/******** Syndk8's OpenBH *********
 *
 * This program is free software
 * licensed under the GPLv2 license.
 * You may redistribute it and/or
 * modify it under the terms of
 * the GPLv2 license (see license.txt)
 *
 * Warning:
 * OpenBH is for educational use
 * Use OpenBH at your own risk !
 *
 * Credits:
 * https://www.syndk8.com/openbh/people.html
 *
 ********************************/


/**
 *   manage/alibs/LogParser.php
 *   Probably parsing logfiles ;)
 *
 *   @author Neek
 */

class LogParser
{
    public $logs = array();

    function  __construct($days) {
        for($i=0;$i<$days;$i++) {
            $logfile = strtotime("today -$i days");
            array_push($this->logs,$this->prepArr($logfile));
        }
    }

    function prepArr($file) {
        /*
         * sessid
         * keyword
         * filename
         * remote addr
         * remote hostname
         * time
         * referer
         * useragent
         */
        $path = sprintf('../data/logs/%s.txt',$file);
        if(!file_exists($path)) {
            return array();
        }
        $ret = array();
        if (($handle = fopen($path, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ';', '"')) !== FALSE) {
                    array_push($ret,
                            array(
                            'sessID'=>$data[0],
                            'keyword'=>$data[1],
                            'filename'=>$data[2],
                            'remote_addr'=>$data[3],
                            'remote_host'=>$data[4],
                            'time'=>$data[5],
                            'referer'=>$data[6],
                            'useragent'=>$data[7]
                        )
                    );
            }
            fclose($handle);
        }
        return $ret;
    }
}

// print_r(prepArr('../../data/logs/1.txt'));

?>
