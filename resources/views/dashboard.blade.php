<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SMAN 12 LUWU | Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <!-- Start Landing Page -->
    <div class="landing-page">
        <header>
            <div class="container">
                <a href="#" class="logo">SMAN <b>12</b> LUWU</a>
                {{-- <ul class="links">
                    <li>Home</li>
                    <li>About Us</li>
                    <li>Work</li>
                    <li>Info</li>
                    <li>Get Started</li>
                </ul> --}}
            </div>
        </header>
        <div class="content">
            <div class="container">
                <div class="info">
                    <h2>Download Absensi Mobile App</h2>
                    <p>
                        Aplikasi ini memberikan kemudahan untuk absensi murid dan menginput jurnal harian dengan cepat
                        dan akurat. Fitur unggulannya meliputi absensi otomatis, laporan real-time, serta integrasi dengan sistem sekolah. Tingkatkan efisiensi dan komunikasi dalam
                        manajemen kelas dengan aplikasi absensi sekarang!
                    </p>
                    <button id="download">Unduh APK v1.1.1</button>
                    <button id="web">Buka Aplikasi Web</button>
                </div>

                <div class="image">
                    <img src="{{ asset('assets/img/landing-page.png') }}">
                </div>
            </div>
        </div>
    </div>
    <!-- End Landing Page -->
    <script>
        document.getElementById('download').addEventListener('click', function() {
            window.location.href = ".{{ $link_android }}";
        });
        document.getElementById('web').addEventListener('click', function() {
            window.location.href = "https://web.sman12-luwu.my.id";
        });
    </script>
</body>

</html>
