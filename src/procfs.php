<?php

/**
 * Linux Proc file system
 *
 * @date 2015-03-10
 * @author Claude Seo. <dmseo@nextown.net>
 */
class procfs
{

    public function getCpuProfile()
    {
        $lines = $this->_readFile('/proc/cpuinfo');
        $arr = array();
        foreach ($lines as $line) {
            $startPos = strpos($line, ':');
            $key = $this->_replace(substr($line, 0, $startPos));
            $value = $this->_replace(substr($line, $startPos, strlen($line)));
            $arr[$key] = $value;
        }
        $arr['usage'] = shell_exec("vmstat | awk '{ print $13 }' | sed -n '3p'");
        return $arr;
    }

    public function getUptime()
    {
        $lines = $this->_readFile('/proc/uptime');
        $startPos = strpos($lines[0], ' ');
        $uptime = substr($lines[0], 0, $startPos);
        $idle = substr($lines[0], $startPos, strlen($lines[0]));
        return array('uptime' => $uptime, 'idle' => $idle);
    }

    public function getLoadAve()
    {
        $lines = $this->_readFile('/proc/loadavg');
        $arr = explode(' ', $lines[0]);
        $entity = explode('/', $arr[3]);
        return array(
            '1' => $arr[0],
            '5' => $arr[1],
            '15' => $arr[2],
            'entity' => array(
                'current' => $entity[0],
                'total' => $entity[1]
            )
        );
    }

    public function getMemoryProfile()
    {
        $lines = $this->_readFile('/proc/meminfo');
        $arr = array();
        foreach ($lines as $line) {
            $startPos = strpos($line, ': ');
            $key = $this->_replace(substr($line, 0, $startPos));
            $value = $this->_replace(substr($line, $startPos + 1, strlen($line)));
            $value = str_replace(' kB', '', $value);
            $arr[$key] = $value;
        }
        $arr['usage'] = (($arr['MemTotal'] - $arr['MemAvailable']) / $arr['MemTotal']) * 100;
        return $arr;
    }

    public function getDiskSize()
    {
        return array(
            'total' => disk_total_space('/'),
            'free' => disk_free_space('/'),
            'usage' => disk_free_space('/') / disk_total_space('/') * 100
        );
    }

    public function getNetwork($network)
    {
        $rx = shell_exec("cat /proc/net/dev | grep " . $network . " | awk '{print $2}'");
        $tx = shell_exec("cat /proc/net/dev | grep " . $network . " | awk '{print $10}'");
        return array(
            'rx' => $rx,
            'tx' => $tx
        );
    }

    private function _replace($str)
    {
        return preg_replace('/\t\r\n|\r|\n|\t/', '', $str);
    }

    private function _readFile($filePath)
    {
        $arr = [];
        foreach (file($filePath) as $line) {
            array_push($arr, $line);
        }
        return $arr;
    }

}