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
            width: 7%;
            height: auto;
        }

        .copyright {
            position: absolute;
            bottom: 10px;
            left: 10px;
            z-index: 999;
        }

        .flex-container {
            display: flex;
            height: 100vh;
        }

        .queue {
            width: 40%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .queue img {
            width: auto;
            height: 50%;
        }

        .queue span {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 90px;
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
            <img src="{{ asset('assets/images/queue/box-queuing.png') }}" alt="Queue Box">
            <span id="queue-no"><strong>A001</strong></span>
        </div>
        <div class="slide">
            <div class="slider-container">
                <div class="slider">
                    @for ($i = 1; $i <= 2; $i++)
                        <img src="{{ asset('assets/images/queue/Pic' . $i . '.png') }}" alt="Image {{ $i }}">
                    @endfor
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
        document.addEventListener("DOMContentLoaded", () => {
            const slider = document.querySelector('.slider');
            const images = document.querySelectorAll('.slider img');
            let currentIndex = 0;
            const slideInterval = 5000; // 20 detik
            const slideDuration = 1000; // Durasi slide dalam ms (1 detik)

            function nextSlide() {
                currentIndex = (currentIndex + 1) % images.length;
                slider.style.transition = `transform ${slideDuration}ms ease-in-out`;
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            setInterval(nextSlide, slideInterval);
        });

        // Inisialisasi pertama
        nextSlide();

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
                    const queue = document.getElementById("queue-no");
                    const list2 = response.data.list2

                    // list2.forEach((group, index) => {
                    //     if (group.length > 0) {
                    //         queue.innerHTML = group
                    //             .map(
                    //                 (item) =>
                    //                 `<strong>${item.truck_type}${String(item.QueNo).padStart(3, "0")}</strong>`
                    //             )
                    //             .join("");
                    //     }
                    // });

                },

                error: function(xhr, status, error) {
                    console.log('Error occurred: ' + status + ' - ' + error);
                }
            })
        }

        document.addEventListener('DOMContentLoaded', () => {
            setInterval(updateContent, 5000); // Memperbarui data setiap 5 detik
        });
    </script>
</body>

</html>
