<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Ticketing</title>
</head>

<body>

    <div class="login-container">

        <h2>Login Sistem Ticketing</h2>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <form method="POST" action="{{ route('login.proses') }}">

            @csrf


            <div>
                <label>Username</label>

                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </div>


            <br>


            <div>
                <label>Password</label>

                <input type="password" name="password" required>
            </div>


            <br>


            <div>
                <label>
                    <input type="checkbox" name="remember" value="1">

                    Ingat saya
                </label>
            </div>


            <br>


            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>
