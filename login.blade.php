<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="{{ asset('assets/images/Header5-750x460.jpg') }}" alt="">
        <div class="text">
          <span class="text-1">Every new friend is a <br> new adventure</span>
          <span class="text-2">Let's get connected</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="login-form">
                <div class="title">Login</div>
                
                <!-- Menampilkan pesan sukses jika ada -->
                @if (session('status'))
                    <div class="alert alert-success" style="color: green; margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-id-card"></i>
                            <x-text-input id="npk" class="block mt-1 w-full" type="text" name="npk" :value="old('npk')" placeholder="Masukkan NPK" required autofocus autocomplete="username" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password" />
                        </div>
                        <div class="input-box">
                            <i class="fas fa-clock"></i>
                            <x-text-input id="target-jam-running" class="block mt-1 w-full" type="number" name="target_jam_running" placeholder="Masukan Target running (menit)" required />
                        </div>

                        <!-- Tabel untuk No Mesin dan Nama Mesin -->
                        <div class="input-box">
                            <table style="width: 100%; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <label for="no-mesin">No Mesin:</label>
                                        <select id="no-mesin" name="no_mesin" class="block mt-1 w-full">
                                            @for ($i = 1; $i <= 59; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <label for="nama-mesin">Nama Mesin:</label>
                                        <select id="nama-mesin" name="nama_mesin" class="block mt-1 w-full">
                                            <option value="Mesin 1">Mesin 1</option>
                                            <option value="Mesin 2">Mesin 2</option>
                                            <option value="Mesin 3">Mesin 3</option>
                                            <option value="Mesin 4">Mesin 4</option>
                                            <option value="Mesin 5">Mesin 5</option>
                                            <option value="Mesin 6">Mesin 6</option>
                                            <option value="Mesin 7">Mesin 7</option>
                                            <option value="Mesin 8">Mesin 8</option>
                                            <option value="Mesin 9">Mesin 9</option>
                                            <option value="Mesin 10">Mesin 10</option>
                                            <option value="Mesin 11">Mesin 11</option>
                                            <option value="Mesin 12">Mesin 12</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Tabel untuk Part Mesin dan Shift -->
                        <div class="input-box">
                            <table style="width: 100%; margin-top: 20px;">
                                <tr>
                                    <td>
                                        <label for="part-mesin">Part Mesin:</label>
                                        <select id="part-mesin" name="part_mesin" class="block mt-1 w-full">
                                            <option value="Part A">Part A</option>
                                            <option value="Part B">Part B</option>
                                            <option value="Part C">Part C </option>
                                            <option value="Part D">Part D</option>
                                            <option value="Part E">Part E</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label for="shift">Shift:</label>
                                        <select id="shift" name="shift" class="block mt-1 w-full">
                                            <option value="1">Shift 1</option>
                                            <option value="2">Shift 2</option>
                                            <option value="3">Shift 3</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="text">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            @endif
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Log in">
                        </div>
                        <div class="text sign-up-text">
                            Don't have an account? <a href="{{ route('register') }}">Sign up now</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</body>
</html>