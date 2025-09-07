<!DOCTYPE html>
<html>

<head>
    <title>Informasi Akun Magang</title>
</head>

<body style="font-family: sans-serif;">
    <h2>Selamat Datang di Program Magang PSDMBP!</h2>
    <p>Halo, akun Anda untuk sistem monitoring magang telah berhasil dibuat.</p>
    <p>Silakan gunakan informasi di bawah ini untuk login ke dalam sistem:</p>
    <ul>
        <li><strong>Link Login:</strong> <a href="{{ url('/login') }}">{{ url('/login') }}</a></li>
        <li><strong>Username:</strong> <code>{{ $user->name }}</code></li>
        <li><strong>Email:</strong> <code>{{ $user->email }}</code></li>
        <li><strong>Password Sementara:</strong> <code>{{ $password }}</code></li>
    </ul>
    <p>Mohon segera login dan ganti password Anda melalui menu profil untuk keamanan.</p>
    <p>Terima kasih dan selamat bergabung!</p>
</body>

</html>
