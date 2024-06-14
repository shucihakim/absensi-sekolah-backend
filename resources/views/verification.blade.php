<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sukses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    
    <div class="container">
        <div class="text-center mt-5">
            @if ($success)
                <div class="alert alert-success" role="alert">
                    <h1 class="card-title">Verifikasi Sukses!</h1>
                    <p class="card-text lead">Akun Anda telah berhasil diverifikasi.</p>
                    <p class="card-text lead">{{ $message }}</p>
                    <a href="app://absensi-app" class="btn btn-primary">Menuju Aplikasi</a>
                </div>
            @else
                <div class="alert alert-danger" role="alert">
                    <h1 class="card-title">Gagal Verifikasi!</h1>
                    <p class="card-text">Akun Anda gagal diverifikasi.</p>
                    <p class="card-text">{{ $message }}</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
