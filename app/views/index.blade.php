<!DOCTYPE html>
<html>
    <head>
        <title>Downtime Meter</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="/styles/css/w3.v4.min.css"/>
		<link rel="stylesheet" href="/styles/css/master.css"/>
    </head>
    <body>

        <div class="w3-row-padding w3-padding-64 w3-container">
            <div class="w3-content">
            
                <!-- Quick info widgets -->
                <div class="w3-row">
                    <!-- Pychart with up- / downtime info -->
                    <div class="w3-col s8">
                        <canvas id="piechart_uptime"></canvas>
                    </div>

                    <div class="w3-col s4">
                        <div class="w3-panel w3-pale-green w3-leftbar w3-rightbar w3-border-green">
                            <h2>{{ $uptimeHours }}</h2>
                            <p>Hours of uptime</p>
                        </div>

                        <div class="w3-panel w3-pale-red w3-leftbar w3-rightbar w3-border-red">
                            <h2>{{ $downtimeHours }}</h2>
                            <p>Hours of downtime</p>
                        </div>
                    </div>

                </div>

                <!-- Graph with uptime -->
                <div class="w3-row">
                    <p>Up- and downtime for the last 7 days.</p>

                    <canvas id="graph_uptime" height="{{ count($dataLastSevenDays) * 10 }}px"></canvas>
                </div>
            </div>
        </div>

        <script src="/styles/scripts/chart.min.js"></script>
        <script>
            var ctx = document.getElementById("graph_uptime").getContext('2d');
            var graph_uptime = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: [
                        @foreach($dataLastSevenDays as $data)
                            @php
                                $dateTime = new DateTime("now", new DateTimeZone(TIMEZONE));
                                $dateTime->setTimestamp(strtotime($data['time']));
                            @endphp

                            "{{ $dateTime->format('d-m-Y H:i') }}",

                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach($dataLastSevenDays as $data)
                                "{{ $data['down'] }}",
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($dataLastSevenDays as $data)
                                @if($data['down'] == -1)
                                    "rgba(255, 0, 0, 0.2)",
                                @else
                                    "rgba(0, 255, 0, 0.2)",
                                @endif
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($dataLastSevenDays as $data)
                                @if($data['down'] == -1)
                                    "rgba(255, 0, 0, 1.0)",
                                @else
                                    "rgba(0, 255, 0, 1.0)",
                                @endif
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                autoSkip: false
                            },
                            gridLines: {
                                offsetGridLines: true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                autoSkip: false,
                                stepSize: 1,
                                min: -1,
                                max: 1,
                                callback: function(value) {}
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });

            var ctx_piechart = document.getElementById("piechart_uptime").getContext('2d');
            var piechart_uptime = new Chart(ctx_piechart, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            {{ $uptimeHours }},
                            {{ $downtimeHours }}
                        ],
                        backgroundColor: [
                            '#00FF00',
                            '#FF0000'
                        ]
                    }],
                    labels: [
                        'Uptime',
                        'Downtime'
                    ]
                }
            });
        </script>

    </body>
</html>
