<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Register</title>
</head>
<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="{{ asset('assets/images/foto52.jpg') }}" alt="">
        <div class="text">
            <span class="text-1">Complete miles of journey <br> with one step</span>
            <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="signup-form">
                <div class="title">Signup</div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-id-card"></i>
                            <x-text-input id="npk" class="block mt-1 w-full" type="text" name="npk" :value="old('npk')" required autocomplete="npk" placeholder="Enter your NPK" />
                            <x-input-error :messages="$errors->get('npk')" class="mt-2" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-user-tag"></i>
                            <x-text-input id="usertype" class="block mt-1 w-full" type="text" name="usertype" :value="old('usertype')" required autocomplete="usertype" placeholder="Enter your user type" />
                            <x-input-error :messages="$errors->get('usertype')" class="mt-2" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Enter your password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Register">
                        </div>
                        <div class="text sign-up-text">Already have an account? <a href="{{ route('login') }}">Login now</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</body>
</html>