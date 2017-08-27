<?php

namespace Controllers;

use Controllers\Database;

class Ping
{
    private $has_internet_connection = 0;
    private $no_internet_connection = 1;

    /**
     * Send a ping to the default gateway to make sure that
     * we do have a network connection.
     * 
     * If we have a network connection we're going
     * to ping the internet ip address to check if
     * the internet is reachable
     *
     * @return void
     */
    public function send()
    {
        // Make sure we have a network connection
        if(!$this->ping(NETWORK_DEFAULT_GATEWAY)) {
            return;
        }

        $hasInternetConnection = $this->ping(IP_ADDRESS);

        $status = -1;
        if($hasInternetConnection) {
            $status = 1;
        }

        $database = new Database();
        $database->insertDownTime($status);
    }

    /**
     * Ping the give IP address
     * 
     * The -W flag sets the timeout for the ping command
     * The -c flag sets the number of pings to send
     *
     * @param String $ipAddress
     * @return bool
     */
    private function ping(String $ipAddress) : bool
    {
        exec("/bin/ping -W 1 -c 1 $ipAddress", $outcome, $status);

        return $status == $this->has_internet_connection;
    }
}