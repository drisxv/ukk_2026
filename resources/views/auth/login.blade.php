<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sarana Sekolah</title>
    @vite('resources/css/app.css')
</head>

<body>
    <main class="login">
        <div class="card bg-blue-800 text-white p-6 rounded-lg shadow-md mx-auto mt-10 w-full max-w-md">
            <h1 class="text-2xl text-center font-bold mb-4">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4 flex flex-col">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="bg-white text-gray-800 placeholder:text-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required autofocus>
                </div>
                <div class="mb-4 flex flex-col">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="bg-white text-gray-800 placeholder:text-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex w-full items-center justify-center">
                    <button type="submit" class="bg-white text-blue-800 hover:bg-slate-200 font-bold py-2 px-4 rounded">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>