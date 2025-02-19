<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen"
    style="background-image: url('{{ asset('storage/bg.jpg') }}'); background-size: cover; background-position: center;">

    <div class="flex bg-gray-50 shadow-lg rounded-lg overflow-hidden max-w-4xl w-[675px]">
        <!-- Bagian Kiri -->
        <div class="w-[340px] flex flex-col items-center justify-center">
            <img src="{{ asset('storage/logo.jpg') }}" alt="Login" class="h-[341px]">
        </div>

        <!-- Bagian Kanan (Form Login) -->
        <div class="w-[250px] p-10">
            <h2 class="w-[250px] flex justify-center text-2xl font-semibold text-[#7887C6] mb-4" style="font-family: 'Poppins', sans-serif;">
                Masuk
            </h2>    

            @if(session('error'))
                <p class="text-red-500 text-sm">{{ session('error') }}</p>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-[250px] px-4 py-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-[250px] px-4 py-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="w-[250px] bg-[#7887C6] text-white py-2 rounded-lg hover:bg-[#6b78b4] transition">Masuk</button>
            </form>
        </div>
    </div>

</body>

</html>
