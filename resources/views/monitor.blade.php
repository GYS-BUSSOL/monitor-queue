<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYS - QMS</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon_gys.ico') }}" type="image/x-icon">
    <style>
        @media screen and (min-width: 1220px) {
            .container {
                height: 10vh;
            }

            body {
                margin: 0;
                padding: 0;
                overflow-y: hidden;
                overflow-x: hidden;
                height: 100vh;
                width: 100%;
            }

            .gang-card {
                flex: 1 1 calc(33.33% - 75px);
                margin: 10px;
                box-sizing: border-box;
            }

            .gang-card .app-card .card-title {
                margin-top: -20px;
                font-size: 3em;
            }

            .gang-card .app-card {
                height: 250px;
            }

            .gang-card .app-card .icon-success {
                font-size: 2em;
            }

            #statusCards {
                margin-top: -10px;
            }

            /* .content {
                padding: 20px;
                background-color: #f4f4f4;
                flex: 1;
            } */

            .legend-container {
                margin-top: -50px;
            }

            .card-footer {
                margin-top: -50px;
            }


        }



        /* tablet */
        @media screen and (min-width: 768px) and (max-width: 1220px) {

            body {
                margin: 0;
                padding: 0;
                overflow-y: hidden;
                overflow-x: hidden;
                height: 100vh;
                width: 100%;
            }

            .gang-card {
                flex: 1 1 calc(33.33% - 75px);
                margin: 10px;
                box-sizing: border-box;
            }

            .status-card .card-header span {
                font-size: 0.9em;
            }

            .card-footer {
                margin-top: -30px;
            }
        }

        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* Menghilangkan scroll pada halaman */
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
        }

        .container {
            max-width: 100%;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .title {
            color: #00765a;
            font-size: 2.5em;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .title:after {
            content: '';
            display: block;
            width: 100px;
            margin: 0.5rem auto;
            border-bottom: 4px solid #00765a;
        }

        .date-time {
            font-size: 1.2em;
            color: #555;
            text-align: center;
            margin-bottom: 1rem;
        }

        .app-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, .1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            height: 95%;
            transition: none;
        }

        .app-card .card-header {
            padding: 1rem;
            width: 100%;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            color: white;
        }

        .app-card .card-body {
            padding: 1rem;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .app-card .card-title {
            font-size: 5em;
            font-weight: bold;
            margin: 0;
            color: #3c4858;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .app-card .card-footer {
            width: 100%;
            padding: 1rem;
            text-align: center;
        }

        .app-card .status-icon {
            font-size: 3em;
            margin-bottom: 0.5rem;
        }

        .info-middle {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .info-middle i {
            margin-right: 0.5rem;
        }

        .status-card {
            height: 150px;
        }

        .status-card .card-header {
            font-size: 1em;
        }

        .status-card .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2em;
        }

        .header-green {
            background-color: #00765a;
        }

        .header-grey {
            background-color: grey;
        }

        .header-red {
            background-color: red;
        }

        .header-blue {
            background-color: #007bff;
        }

        .header-yellow {
            background-color: #ffc107;
        }

        .header-purple {
            background-color: #6f42c1;
        }

        .header-orange {
            background-color: #fd7e14;
        }

        .gang-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            object-fit: inherit;
        }

        .gang-card {
            flex: 1 1 calc(16.66% - 75px);
            box-sizing: border-box;
            margin: 10px;
        }

        .queue-table {
            margin-right: 20px;
        }

        .queue-table table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, .1);
        }

        .queue-table th,
        .queue-table td {
            padding: 1rem;
            border: 1px solid #ddd;
            text-align: center;
        }

        .queue-table th {
            background-color: #00765a;
            color: #ffffff;
            font-weight: bold;
        }

        .queue-table td {
            font-size: 1.2em;
            color: #333;
        }

        .main-content {
            display: flex;
            width: 100%;
            justify-content: center;
        }

        @media only screen and (max-width: 768px) {
            .gang-card {
                flex: 1 1 calc(50% - 20px);
            }

            .card-responsive {
                flex: 1 1 calc(50% - 20px);
                min-width: 150px;
                margin-bottom: 1rem;
            }

            .card-footer {
                margin-top: -20px;
            }

            .app-card .card-title {
                font-size: 3em;
            }
        }

        .legend-container {
            display: flex;
            justify-content: center;
            margin-top: 0.1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 1rem;
            font-size: 1em;
        }

        .legend-item i {
            margin-right: 0.5rem;
            font-size: 1.5em;
        }

        .status-cards-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .status-cards-container .col-md-2 {
            flex: 1;
            min-width: 150px;
            margin-bottom: 1rem;
        }

        .title-reason {
            background: red;
            color: #FFFFFF;
            border: 1px solid red;
            padding: 10px;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: -15px;
        }

        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
        }

        .logo img {
            width: 8%;
            height: auto;
        }

        .copyright {
            position: absolute;
            bottom: 10px;
            left: 10px;
            z-index: 999;
            font-size: 22px
        }
    </style>
</head>

<body>
    <div
        style="background: url('{{ asset('assets/images/queue/background.png') }}') center/cover no-repeat; height: 100vh;">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </div>
        <div class="container">
            <h1 class="title">Queue Management System</h1>
            <div class="date-time" id="currentDateTime"></div>
            <div class="main-content">
                <div class="gang-container" id="gangContainer">
                    @php
                        $i = 0;
                        $namaGrader = session('nama');
                    @endphp
                    @foreach ($data['applications'] as $app)
                        @php
                            $iconClass = $app['queue'] ? 'fas fa-check-circle icon-success text-success' : '';
                            if ($app['active_gang'] == '1') {
                                $headerClass = $app['queue'] ? 'header-green' : 'header-grey';
                                $cardTitle = $app['queue']
                                    ? $app['type'] . sprintf('%03d', $app['queue'])
                                    : '<i class="fas fa-minus-circle text-muted"></i>';
                                $reason = '';
                            } else {
                                $headerClass = 'header-red';
                                $cardTitle = '<i class="fas fa-times-circle text-danger"></i>';
                                $reason = $app['reason']
                                    ? '<span class="title-reason">' . $app['reason'] . '</span>'
                                    : '';
                            }
                        @endphp

                        <div class="gang-card">
                            <div class="card app-card">
                                <div class="card-header {{ $headerClass }}">
                                    {{ $app['name'] }}
                                </div>
                                <div class="card-body mb-3">
                                    @if ($app['queue'])
                                        <div class="info-middle timer" id="timerInQueue{{ $i }}"
                                            data-initial-duration="0">
                                            <i class="fas fa-clock"></i>
                                            <span id="timeInQueue{{ $i }}"></span>
                                        </div>
                                        @if (!empty($namaGrader) || $namaGrader !== null)
                                            <div class="grader-name">
                                                <i class="fas fa-user"></i>
                                                <strong>{{ $app['grader'] }}</strong>
                                            </div>
                                        @endif
                                    @endif
                                    <h5 class="card-title">
                                        {!! $cardTitle !!}
                                    </h5>
                                    {!! $reason !!}
                                </div>
                                <div class="card-footer -mt-5">
                                    <i class="{{ $iconClass }} status-icon"></i>
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            </div>
            <div class="status-cards-container card-responsive" id="statusCards">
                <div class="col-md-2">
                    <div class="card app-card status-card">
                        <div class="card-header header-green">
                            <span>Total Registered Trucks</span>
                        </div>
                        <div class="card-body">
                            {{ $data['is_registed'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card app-card status-card">
                        <div class="card-header header-yellow">
                            <span>Total Trucks in Queue</span>
                        </div>
                        <div class="card-body">
                            {{ $data['in_queue'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card app-card status-card">
                        <div class="card-header header-orange">
                            <span>Total Trucks in Progress</span>
                        </div>
                        <div class="card-body">
                            {{ $data['in_progress'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card app-card status-card">
                        <div class="card-header header-blue">
                            <span>Total Completed Trucks</span>
                        </div>
                        <div class="card-body">
                            {{ $data['complited'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card app-card status-card">
                        <div class="card-header header-red">
                            <span>Total Outstanding Trucks</span>
                        </div>
                        <div class="card-body">
                            {{ $data['outstanding_trucks'] }}
                        </div>
                    </div>
                </div>

            </div>
            <div class="legend-container">
                <div class="legend-item">
                    <i class="fas fa-square text-red" style="color: red;"></i> Non-Active
                </div>
                <div class="legend-item">
                    <i class="fas fa-square" style="color: grey;"></i> Active-no truck unloading
                </div>
                <div class="legend-item">
                    <i class="fas fa-square" style="color: #00765a;"></i> Active-truck unloading
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>2025 &copy; <a href="https://garudayamatosteel.com">GYS</a> All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const applications = @json($data['applications']);

        function updateContent() {
            $.ajax({
                url: '/',
                method: 'GET',
                cache: false,
                success: function(response) {
                    let gangContainer = $(response).find('#gangContainer').html();
                    $('#gangContainer').html(gangContainer);
                    let statusCardContainer = $(response).find('#statusCards').html();
                    $('#statusCards').html(statusCardContainer);
                },
                error: function(xhr, status, error) {
                    console.log('Error occurred: ' + status + ' - ' + error);
                }
            })
        }

        setInterval(updateContent, 5000);

        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentDateTime').innerHTML = now.toLocaleDateString('en-US', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        function timeInQueue() {
            const initialDurations = {};
            const timeInQueue = {};
            applications.forEach((app, index) => {
                if (app['durasi'] !== null) {
                    const [hours, minutes, seconds] = app.durasi.split(':').map(Number);
                    const initialDuration = hours * 3600 + minutes * 60 + seconds;

                    let timeInQueue = initialDuration;

                    setInterval(() => {
                        timeInQueue++;
                        const timeElement = document.getElementById(`timeInQueue${index}`);

                        if (timeElement) {
                            const hours = Math.floor(timeInQueue / 3600).toString().padStart(2, '0');
                            const minutes = Math.floor((timeInQueue % 3600) / 60).toString().padStart(2,
                                '0');
                            const seconds = (timeInQueue % 60).toString().padStart(2, '0');
                            timeElement.innerHTML = `${hours}:${minutes}:${seconds}`;
                        }
                    }, 1000);
                }
            });
        }

        // Panggil fungsi timeInQueue
        timeInQueue();
    </script>
</body>

</html>
