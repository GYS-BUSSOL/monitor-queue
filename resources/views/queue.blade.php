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
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
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

        .date-time {
            color: black;
            position: absolute;
            bottom: 10px;
            left: 10px;
            z-index: 999;
            font-size: 22px;
            font-weight: bold;
        }

        .flex-container {
            display: flex;
            height: 100vh;
        }

        .queue {
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .queue-image {
            width: 60%;
            margin-bottom: 10px;
        }

        .queue span {
            position: absolute;
            top: 47%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 120px;
            text-align: center;
        }

        .slide {
            width: 60%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .slider-container {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        .slider {
            display: flex;
            height: 100%;
            transition: transform 1s ease-in-out;
        }

        .slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .blink {
            width: 50%;
            animation: blinker 3s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="flex-container"
        style="background: url('{{ asset('assets/images/queue/background.png') }}') center/cover no-repeat;">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </div>
        <div class="queue">
            <img class="queue-image" src="{{ asset('assets/images/queue/queuing-box.png') }}" alt="Queue Box">
            <span id="queue-no"></span>
            <img class="blink" src="{{ asset('assets/images/queue/information-text.png') }}" alt="Tulisan">
        </div>
        <div class="slide">
            <div class="slider-container">
                <div class="slider">
                    @for ($i = 1; $i <= 12; $i++)
                        <img src="{{ asset('assets/images/queue/img' . $i . '.png') }}" alt="Image {{ $i }}">
                    @endfor
                </div>
            </div>
        </div>
        {{-- <div class="copyright">
            <p>2025 &copy; <a href="https://garudayamatosteel.com">GYS</a> All rights reserved.</p>
        </div> --}}
        <div class="date-time" id="currentDateTime"></div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let currentQueueIndex = 0;

        function updateContent() {
            $.ajax({
                url: '/get-waiting',
                method: 'GET',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                success: function(response) {
                    const list2 = response.data.list2
                    const queue = document.getElementById("queue-no");

                    const queueNumbers = list2.flatMap((group) =>
                        group.map(
                            (item) =>
                            `${item.truck_type}${String(item.QueNo).padStart(3, "0")}`
                        )
                    );

                    console.log(queueNumbers)

                    if (queueNumbers.length > 0) {
                        queue.innerHTML = `<strong>${queueNumbers[currentQueueIndex]}</strong>`;
                        currentQueueIndex = (currentQueueIndex + 1) % queueNumbers.length;
                    } else {
                        queue.innerHTML = `<strong>-</strong>`;
                    }


                },
                error: function(xhr, status, error) {
                    console.log('Error occurred: ' + status + ' - ' + error);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateContent();
            setInterval(updateContent, 10000);
            slideImage();
        });


        function slideImage() {
            const slider = document.querySelector('.slider');
            const images = document.querySelectorAll('.slider img');
            let currentIndex = 0;
            const slideInterval = 15000;
            const slideDuration = 1000; // Durasi slide dalam ms (1 detik)
            // Duplikasi gambar pertama untuk looping
            const firstClone = images[0].cloneNode(true);
            slider.appendChild(firstClone);

            function nextSlide() {
                currentIndex++;

                // Animasi geser ke gambar berikutnya
                slider.style.transition = `transform ${slideDuration}ms ease-in-out`;
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Reset ke awal saat mencapai gambar terakhir (cloning)
                if (currentIndex === images.length) {
                    setTimeout(() => {
                        slider.style.transition = 'none'; // Matikan animasi
                        slider.style.transform = `translateX(0)`;
                        currentIndex = 0;
                    }, slideDuration);
                }
            }

            setInterval(nextSlide, slideInterval);
        }

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
