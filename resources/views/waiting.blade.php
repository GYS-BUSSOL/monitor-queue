<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYS - QMS</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/images/favicon_gys.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        /* CSS Global */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            /* Menghilangkan scroll pada halaman */
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            gap: 20px;
            max-width: 100%;
        }

        /* Section Title */
        .section-title {
            font-size: 2.3em;
            color: #00765a;
            text-align: center;
            margin: 10px 0;
            border-bottom: 2px solid #00765a;
            display: inline-block;
            padding: 0 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Card Styles */
        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            width: 100%;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            height: 300px;
            /* Fixed height for scrolling inside */
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .card-header {
            background-color: #ff7f00;
            /* Example color for header */
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            font-size: 1.3em;
        }

        .card-header.green {
            background-color: #006400;
        }

        .card-content {
            padding: 10px;
            overflow-y: auto;
            /* Enable scroll inside the card */
            height: 100%;
            /* Take the rest of the height */
        }

        .date-time {
            font-size: 1 em;
            color: #555;
            text-align: right;
            margin-bottom: 1rem;
            margin-right: 20px;
        }

        /* Style untuk tabel */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px 12px;
            text-align: center;
            font-size: 15px;
            color: #555;
        }

        .table th {
            font-weight: bold;
            color: #666;
            /* Warna teks untuk heading */
            border-bottom: 1px solid #ddd;
            ali
        }

        .table td {
            padding-top: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card {
                width: 100%;
            }

            body,
            html {
                overflow-y: scroll;
            }
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

        <div class="date-time" id="currentDateTime"></div>
        <div class="container">
            <div class="section-title">WAITING AREA</div>
            <div class="card-wrapper" id="waitingArea">
                @php
                    $i = 0;
                @endphp
                @foreach ($data['type'] as $type)
                    <div class="card">
                        <div class="card-header orange">
                            {{ strtoupper($type->type) . ' (' }} <span id="totalType{{ $i }}"></span>
                            {{ ')' }}
                        </div>
                        <div class="card-content">
                            <table class="table">
                                <tr>
                                    <th>Queue Number</th>
                                    <th>Truck Number</th>
                                </tr>
                                <tbody id="waiting{{ $i }}"></tbody>
                            </table>
                        </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
            <div class="section-title">TO SCRAP YARD</div>
            <div class="card-wrapper" id="scrapYard">
                @php
                    $i = 0;
                @endphp
                @foreach ($data['type2'] as $group)
                    <div class="card">
                        <div class="card-header green">
                            {{ strtoupper($group->type) }}
                            <br>
                            {{ '( ' . $group->loc . ' )' }}
                        </div>
                        <div class="card-content">
                            <table class="table">
                                <tr>
                                    <th>Queue Number</th>
                                    <th>Truck Number</th>
                                </tr>
                                <tbody id="scrap{{ $i }}"></tbody>
                            </table>
                        </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach

            </div>
        </div>
        {{-- <div class="copyright">
            <p>2025 &copy; <a href="https://garudayamatosteel.com">GYS</a> All rights reserved.</p>
        </div> --}}
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let isSpeechSynthesisActivated = false;
        let previousWaitingArea = '';
        let previousScrapYard = '';

        function activateSpeechSynthesis() {
            if (!isSpeechSynthesisActivated) {
                document.body.addEventListener('click', function() {
                    isSpeechSynthesisActivated = true;
                    const testUtterance = new SpeechSynthesisUtterance(
                        "Pengecekan sistem suara otomatis, di aktifkan.");
                    testUtterance.lang = 'id-ID';
                    window.speechSynthesis.speak(testUtterance); // Aktivasi suara dengan klik
                    console.log(isSpeechSynthesisActivated)
                }, {
                    once: true
                }); // Event listener hanya dipanggil sekali
            }
        }

        function announceNewData(newContent, previousContent, area) {
            const newItems = $(newContent).find('.item').filter((index, item) => {
                const itemId = $(item).data('id');
                return !$(previousContent).find(`[data-id="${itemId}"]`).length;
            });

            if (newItems.length > 0) {
                newItems.each((index, item) => {
                    const itemName = $(item).text().trim();
                    const queueNumber = itemName; // Anggap itemName adalah nomor antrian

                    const queueNumberWords = convertNumberToWords(queueNumber);
                    // Format pesan suara untuk mengumumkan nomor antrian
                    const startMessage = `Nomor antrian`;
                    const endMessage = `silahkan menuju ke ${area}`
                    console.log(startMessage, queueNumberWords, endMessage);
                    speakText(startMessage, queueNumberWords, endMessage);
                });
            }
        }

        function getFemaleVoice(lang = 'id-ID') {
            const voices = window.speechSynthesis.getVoices();
            return voices.find(voice => voice.lang === lang && voice.name.toLowerCase().includes('female')) ||
                voices.find(voice => voice.lang === lang && voice.name.toLowerCase().includes('cewek')) ||
                voices.find(voice => voice.lang === lang && voice.name.toLowerCase().includes('woman')) ||
                voices.find(voice => voice.lang === lang && voice.name.toLowerCase().includes('wanita')) ||
                voices.find(voice => voice.lang === lang);
        }

        function speakText(startMessage, queueNumberWords, endMessage) {
            if (isSpeechSynthesisActivated) {
                const start = new SpeechSynthesisUtterance(startMessage);
                const number = new SpeechSynthesisUtterance(queueNumberWords);
                const end = new SpeechSynthesisUtterance(endMessage);
                start.lang = 'id-ID';
                number.lang = 'id-ID';
                end.lang = 'id-ID';
                const voiceFemale = getFemaleVoice('id-ID');
                if (voiceFemale) {
                    start.voice = voiceFemale;
                    number.voice = voiceFemale;
                    end.voice = voiceFemale;
                } else {
                    console.log('Voice Female Not Found')
                }
                start.volume = 1.5;
                start.rate = 1;
                start.pitch = 1;
                number.volume = 1.5;
                number.rate = 0.7;
                number.pitch = 1;
                end.volume = 1.5;
                end.rate = 1;
                end.pitch = 1;
                window.speechSynthesis.speak(start);
                window.speechSynthesis.speak(number);
                window.speechSynthesis.speak(end);
            } else {
                console.log('Speech synthesis is not activated.');
            }
        }

        function convertNumberToWords(number) {
            const angkaTerbilang = [
                'nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'
            ];


            const letters = number.replace(/[0-9]/g, ''); // Ambil huruf
            const digits = number.replace(/\D/g, ''); // Ambil angka

            let words = '';

            // Jika ada huruf, tambahkan huruf terlebih dahulu
            if (letters) {
                words += letters + ' ';
            }

            // Jika ada angka, konversikan angka tersebut ke dalam kata
            for (let i = 0; i < digits.length; i++) {
                words += angkaTerbilang[parseInt(digits.charAt(i))] + ' ';
            }


            return words.trim();
        }

        function compareAreasForMovement(previousArea, newArea, fromArea, toArea) {
            const previousItems = $(previousArea).find('.item');
            const newItems = $(newArea).find('.item');

            // Membandingkan item baru antara area sebelumnya dan area sekarang
            newItems.each((index, newItem) => {
                const newItemId = $(newItem).data('id');
                const existingItem = previousItems.filter(`[data-id="${newItemId}"]`);

                // Jika item tidak ditemukan di area sebelumnya, berarti item ini baru pindah
                if (existingItem.length === 0) {
                    const queueNumber = $(newItem).text().trim();

                    // Pastikan hanya mengumumkan suara jika antrian berpindah dari Waiting ke Scrap
                    if (fromArea === 'Waiting Area' && toArea === 'Scrap Yard') {
                        announceMovement(queueNumber, fromArea, toArea);
                    }
                }
            });
        }


        function updateContent() {
            $.ajax({
                url: '/get-waiting',
                method: 'GET',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'),
                },
                success: function(response) {
                    const waitingAreaElement = document.getElementById("waitingArea");
                    const scrapYardElement = document.getElementById("scrapYard");
                    const totalType = document.getElementById("totalType");

                    const list = response.data.list
                    const list2 = response.data.list2
                    const type = response.data.type

                    type.forEach((group, index) => {
                        const typeElementId = `totalType${index}`;
                        const typeElement = document.getElementById(typeElementId);
                        typeElement.innerHTML = group.total
                    });

                    // WAITING AREA
                    list.forEach((group, index) => {
                        const waitingElementId = `waiting${index}`;
                        const waitingElement = document.getElementById(waitingElementId);

                        if (waitingElement) {
                            if (group.length > 0) {
                                // Add data to the element
                                waitingElement.innerHTML = group
                                    .map(
                                        (item) => `
                                        <tr>
                                            <td>${item.truck_type}${String(item.QueNo).padStart(3, "0")}</td>
                                            <td>${item.VechileNo}</td>
                                        </tr>`
                                    )
                                    .join("");
                            }
                        }
                    });

                    // SCRAP YARD
                    list2.forEach((group, index) => {
                        const scrapElementId = `scrap${index}`;
                        const scrapElement = document.getElementById(scrapElementId);

                        if (scrapElement) {
                            if (group.length > 0) {
                                // Add data to the element
                                scrapElement.innerHTML = group
                                    .map(
                                        (item) => `
                                        <tr>
                                            <td class="item" data-id="${item.QueNo}">${item.truck_type}${String(item.QueNo).padStart(3, "0")}</td>
                                            <td>${item.VechileNo}</td>
                                        </tr>`
                                    )
                                    .join("");
                            }
                        }
                    });

                    if (isSpeechSynthesisActivated) {
                        // Simpan HTML setelah pembaruan
                        const waitingAreaContent = waitingAreaElement.innerHTML;
                        const scrapYardContent = scrapYardElement.innerHTML;

                        // Memeriksa perubahan antara Waiting Area dan Scrap Yard
                        compareAreasForMovement(previousWaitingArea, waitingAreaContent, 'Waiting Area',
                            'Scrap Yard');
                        compareAreasForMovement(previousScrapYard, scrapYardContent, 'Scrap Yard',
                            'Waiting Area');

                        // Memanggil announceNewData untuk mengumumkan data baru yang masuk
                        announceNewData(waitingAreaContent, previousWaitingArea, 'Waiting Area');
                        announceNewData(scrapYardContent, previousScrapYard, 'Scrap Yard');

                        previousWaitingArea = waitingAreaContent;
                        previousScrapYard = scrapYardContent;
                    }

                },

                error: function(xhr, status, error) {
                    console.log('Error occurred: ' + status + ' - ' + error);
                }
            })
        }

        document.addEventListener('DOMContentLoaded', () => {
            activateSpeechSynthesis();
            updateContent();
            setInterval(updateContent, 5000); // Memperbarui data setiap 5 detik
        });


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
    </script>
</body>

</html>
