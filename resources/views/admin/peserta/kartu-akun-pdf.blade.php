<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kartu Akun Peserta</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        .card {
            border: 2px solid #333;
            padding: 20px;
            width: 400px;
            margin: 20px auto;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        .content p {
            margin: 10px 0;
        }

        .content strong {
            display: inline-block;
            width: 120px;
        }

        code {
            background-color: #f4f4f4;
            padding: 2px 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <h3>KARTU AKUN PESERTA MAGANG</h3>
            <p>Pusat Sumber Daya Mineral, Batubara dan Panas Bumi</p>
        </div>
        <div class="content">
            <p><strong>Nama Lengkap:</strong> {{ $peserta->nama_lengkap }}</p>
            <p><strong>Username:</strong> <code>{{ $peserta->user->name }}</code></p>
            <p><strong>Email Login:</strong> <code>{{ $peserta->user->email }}</code></p>
            <p><strong>Password:</strong> <code>{{ $password }}</code></p>
        </div>
    </div>
</body>

</html>
