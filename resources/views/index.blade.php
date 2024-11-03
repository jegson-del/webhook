<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.1/dist/tailwind.min.css" rel="stylesheet">
    <title>Business Comparison Technical Test</title>
    <script type="text/javascript" src="/js/app.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <script>
        function checkCaptcha() {
            const num1 = parseInt(document.getElementById('num1').value);
            const num2 = parseInt(document.getElementById('num2').value);
            const userAnswer = parseInt(document.getElementById('captcha_answer').value);
            const correctAnswer = num1 + num2;

            document.getElementById('submit_button').disabled = userAnswer !== correctAnswer;
        }
    </script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-md space-y-4">
        @csrf
        <h2 class="text-2xl font-bold text-center">Register</h2>

        <div>
            <label for="first_name" class="block text-sm font-medium">First Name</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('first_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('last_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
                <label for="image">Profile Image:</label>
                <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*">
        </div>
        @error('image_path')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <div class="flex items-center">
            <input type="checkbox" name="terms_accepted" id="terms_accepted" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" value ="1" {{ old('terms_accepted') ? 'checked' : '' }}>
            <label for="terms_accepted" class="ml-2 block text-sm">I accept the terms and conditions</label>
        </div>
        @error('terms_accepted')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <!-- CAPTCHA Math Question -->
        @php
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
        @endphp

        <input type="hidden" id="num1" value="{{ $num1 }}">
        <input type="hidden" id="num2" value="{{ $num2 }}">

        <div>
            <label class="block text-sm font-medium">What is {{ $num1 }} + {{ $num2 }}?</label>
            <input type="number" id="captcha_answer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" oninput="checkCaptcha()">
        </div>

        <button type="submit" id="submit_button" class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600" disabled>Submit</button>
    </form>
</body>
</html>