<?php

namespace DjPanel\MainBundle;

use Exception;

class LiquidSoap
{

    /**
     * Sends a command to the Liquidsoap Telnet Server
     * @param string  $command    Command to Send
     * @param boolean $throwError Indicates whether to throw an error if there is a problem connecting to the server
     * @return string
     * @throws Exception
     */
    public static function sendCommand($command, $throwError=false)
    {
        $return = "";
        $fp = @fsockopen("localhost", 1234);
        if ($fp === false) {
            if ($throwError) {
                throw new Exception("Couldn't connect to the Liquidsoap server");
            } else {
                return "...";
            }
        } else {
            fwrite($fp, "{$command}\nexit\n");
            while (!feof($fp)) {
                $return .= fgets($fp); // ,128
            }
            fclose($fp);
        }
        return strstr($return, 'END', true);
    }

    /**
     * Returns the meta data for the current track which is being played
     * @return array
     */
    public static function getNowPlaying()
    {
        // Get metadata from liquidsoap
        $data = self::sendCommand("metadata 0");

        // Parse data
        // Format e.g:
        // title="I Will Wait"
        // artist="Mumford and Sons"
        $nowPlaying = array();
        $rows = explode("\n", $data);

        foreach ($rows as $row) {
            // Parse key="value"
            $key = substr($row, 0, strpos($row, "="));
            $value = substr($row, strpos($row, "=") + 1);
            $value = substr($value, 1, strlen($value) - 2);

            $nowPlaying[$key] = $value;
        }

        return $nowPlaying;
    }

    /**
     * Indicates whether the Liquidsoap Server is online
     * @return boolean
     */
    public static function isOnline()
    {
        try {
            self::sendCommand("uptime", true);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

}