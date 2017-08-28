<?php

namespace Controllers;

use Illuminate\View;

class Index
{
    /**
     * Display the graphs
     * 
     * We divide the up- and downtime row count by 12 because we
     * add a record every 5 minutes
     *
     * @return void
     */
    public static function index()
    {
        $database = new Database();
        $pdo = $database->connect();

        // Hours of downtime
        $stmt = $pdo->query('SELECT down FROM downtime WHERE down = -1;');
        $downtimeRecords = $stmt->rowCount();

        $downtimeHours = round($downtimeRecords / 12, 1);

        // Hours of uptime
        $stmt = $pdo->query('SELECT down FROM downtime WHERE down = 1;');
        $uptimeRecords = $stmt->rowCount();

        $uptimeHours = round($uptimeRecords / 12, 1);

        // Data (Last 7 days)
        $stmt = $pdo->query('SELECT time, down FROM downtime WHERE time >= DATE(NOW()) - INTERVAL 7 DAY;');
        $dataLastSevenDays = $stmt->fetchAll();

        return $GLOBALS['blade']->make('index', [
            'uptimeHours'       => $uptimeHours,
            'downtimeHours'     => $downtimeHours,
            'dataLastSevenDays' => $dataLastSevenDays
        ]);
    }
}