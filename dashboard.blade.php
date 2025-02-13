<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .ng-summary {
            display: flex;
            justify-content: space-around; /* Menempatkan elemen dengan jarak yang sama */
            gap: 20px; /* Jarak antar elemen */
            color: white; /* Warna teks */
            background-color: orange; /* Warna latar belakang */
            padding: 15px; /* Jarak dalam elemen */
            border-radius: 5px; /* Sudut membulat */
            margin: 20px 0; /* Jarak atas dan bawah */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek kedalaman */
        }

        .ng-summary div {
            flex: 1; /* Membuat setiap elemen memiliki lebar yang sama */
            text-align: center; /* Pusatkan teks di dalam elemen */
            font-weight: bold; /* Tebalkan teks */
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            background-color: #007bff; /* Warna latar belakang header */
            color: white; /* Warna teks header */
            padding: 10px; /* Jarak dalam header */
            border-radius: 5px; /* Sudut membulat */
        }

        .header-item {
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .button-container {
            margin-top: 20px;
        }

        .button-row {
            display: flex;
            justify-content: center; /* Menyusun tombol ke tengah */
            align-items: center; /* Pusatkan secara vertikal */
        }

        .button-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 10px; /* Jarak antar tombol */
        }

        .modal {
            display: none; /* Sembunyikan modal secara default */
            position: fixed; /* Posisi tetap */
            z-index: 1000; /* Di atas elemen lain */
            left: 0;
            top: 0;
            width: 100%; /* Lebar penuh */
            height: 100%; /* Tinggi penuh */
            background-color: rgba(0, 0, 0, 0.5); /* Latar belakang transparan */
            justify-content: center; /* Pusatkan konten secara vertikal */
            align-items: center; /* Pusatkan konten secara horizontal */
        }

        .modal.active {
            display: flex; /* Tampilkan modal jika aktif */
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Lebar modal */
            text-align: center; /* Pusatkan teks di dalam modal */
        }

        .close-button {
            cursor: pointer;
            float: right;
        }

        .modal-button-container {
            display: flex;
            flex-direction: column; /* Susun tombol secara vertikal */
            gap: 10px; /* Jarak antar tombol */
            margin-top: 20px; /* Jarak atas untuk tombol */
        }

        .modal-button {
            padding: 10px; /* Padding untuk tombol */
            background-color: orange; /* Warna latar belakang tombol */
            color: white; /* Warna teks tombol */
            border: none; /* Hapus border */
            border-radius: 5px; /* Sudut membulat */
            cursor: pointer; /* Tangan saat hover */
            transition: background-color 0.3s; /* Efek transisi */
        }

        .modal-button:hover {
            background-color: darkorange; /* Warna saat hover */
        }

        .notification {
            margin: 20px 0;
            padding: 10px;
            color: white; /* Warna teks notifikasi */
            border-radius: 5px; /* Sudut membulat */
            display: none; /* Sembunyikan notifikasi secara default */
        }

        .notification.running {
            background-color: green; /* Warna latar belakang untuk mesin berjalan */
        }

        .notification.stopped {
            background-color: red; /* Warna latar belakang untuk mesin berhenti */
        }

        .input-field {
            margin-top: 10px;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Tabel untuk No Mesin, Nama Mesin, Nama Part, dan Shift */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #007bff;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .dropdown {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Styling for Lose Time Box */
        .lose-time-box {
            background-color: #fff; /* Background color of the box */
            border: 1px solid #007bff; /* Border color */
            border-radius: 5px; /* Rounded corners */
            padding: 10px; /* Padding inside the box */
            text-align: center; /* Center text */
            margin: 10px 0; /* Margin around the box */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }

        .lose-time-title {
            font-weight: bold; /* Bold title */
            margin-bottom: 5px; /* Space below the title */
        }

        .lose-time {
            font-size: 24px; /* Larger font size for the timer */
            color: #333; /* Timer text color */
        }
    </style>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>
        </x-slot>

        <!-- Notifikasi status mesin -->
        <div id="notification" class="notification"></div>

        <!-- Menampilkan jumlah NG berdasarkan kategori dalam format tabel -->
        <div class="ng-summary">
            <div>Short Shoot: <span id="short-shoot-count">0</span></div>
            <div>Silver: <span id="silver-count">0</span></div>
            <div>Scratch: <span id="scratch-count">0</span></div>
            <div>Weldline: <span id="weldline-count">0</span></div>
            <div>Flash: <span id="flash-count">0</span></div> <!-- New Category -->
            <div>Burn Mark: <span id="burn-mark-count">0</span></div> <!-- New Category -->
            <div>Flow Lines: <span id="flow-lines-count">0</span></div> <!-- New Category -->
            <div>Lainnya: <span id="lainnya-count">0</span></div>
        </div>

        <!-- Tabel untuk No Mesin, Nama Mesin, Nama Part, dan Shift -->
        <table>
            <thead>
                <tr>
                    <th>No Mesin</th>
                    <th>Nama Mesin</th>
                    <th>Nama Part</th> <!-- Kolom baru untuk Nama Part -->
                    <th>Target Jam Running</th>
                    <th>Shift</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select id="machine-number" class="dropdown">
                            <script>
                                for (let i = 1; i <= 59; i++) {
                                    document.write(`<option value="${i}">${i}</option>`);
                                }
                            </script>
                        </select>
                    </td>
                    <td>
                        <select id="machine-name" class="dropdown">
                            <option value="Mesin 1">Mesin 1</option>
                            <option value="Mesin 2">Mesin 2</option>
                            <option value="Mesin 3">Mesin 3</option>
                            <option value="Mesin 4">Mesin 4</option>
                            <option value="Mesin 5">Mesin 5</option>
                            <option value="Mesin 6">Mesin 6</option>
                            <option value="Mesin 7">Mesin 7</option>
                        </select>
                    </td>
                    <td>
                        <select id="part-name" class="dropdown"> <!-- Dropdown untuk Nama Part -->
                            <option value="Part A">Part A</option>
                            <option value="Part B">Part B</option>
                            <option value="Part C">Part C</option>
                            <option value="Part D">Part D</option>
                            <option value="Part E">Part E</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="target-running" class="input-field" placeholder="Masukkan jam running">
                    </td>
                    <td>
                        <select id="shift" class="dropdown">
                            <option value="1">Shift 1</option>
                            <option value="2">Shift 2</option>
                            <option value="3">Shift 3</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="button-container">
            <div class="button-row">
                <div class="button-wrapper">
                    <div id="ok-counter" class="counter">0</div>
                    <button id="ok-button" class="button yes-button" onclick="incrementCounter('ok')">OK</button>
                </div>
                <div class="button-wrapper">
                    <div id="timer" class="timer">00:00:00</div>
                    <button id="pause-button" class="button pause-button" onclick="togglePause()">
                        <i id="pause-icon" class="fas fa-play"></i>
                    </button>
                </div>
                <div class="button-wrapper">
                    <div id="ng-counter" class="counter">0</div>
                    <button id="ng-button" class="button no-button" onclick="showModal()">NG</button>
                </div>
            </div>
            <div class="button-wrapper">
                <button id="end-shift-button" class="button end-shift-button" onclick="showPasswordModal()">End Shift</button>
            </div>
            <div class="lose-time-box">
                <div class="lose-time-title">Lose Time</div>
                <div id="lose-time" class="lose-time">00:00:00</div> <!-- New Lose Time Display -->
            </div>
        </div>

        <div id="modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closeModal()">×</button>
                <h2>Pilih Jenis Masalah</h2>
                <div class="modal-button-container">
                    <button class="modal-button" onclick="handleNgClick('Short Shoot')">Short Shoot</button>
                    <button class="modal-button" onclick="handleNgClick('Silver')">Silver</button>
                    <button class="modal-button" onclick="handleNgClick('Scratch')">Scratch</button>
                    <button class="modal-button" onclick="handleNgClick('Weldline')">Weldline</button>
                    <button class="modal-button" onclick="handleNgClick('Flash')">Flash</button> <!-- New Button -->
                    <button class="modal-button" onclick="handleNgClick('Burn Mark')">Burn Mark</button> <!-- New Button -->
                    <button class="modal-button" onclick="handleNgClick('Flow Lines')">Flow Lines</button> <!-- New Button -->
                    <button class="modal-button" onclick="showOtherNgModal()">Lainnya</button>
                </div>
            </div>
        </div>

        <div id="other-ng-modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closeOtherNgModal()">×</button>
                <h2>Masukkan Jenis Masalah Lainnya</h2>
                <input type="text" id="other-ng-input" class="input-field" placeholder="Masukkan jenis masalah">
                <button class="modal-button" onclick="handleOtherNgClick()">Submit</button>
            </div>
        </div>

        <div id="stop-reason-modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closeStopReasonModal()">×</button>
                <h2>Pilih Alasan Mesin Berhenti</h2>
                <div class="modal-button-container">
                    <button class="modal-button" onclick="handleStopReason('Material Habis')">Material Habis</button>
                    <button class="modal-button" onclick="handleStopReason('Box Habis')">Box Habis</button>
                    <button class="modal-button" onclick="handleStopReason('BAB/BAK')">BAB/BAK</button>
                    <button class="modal-button" onclick="handleStopReason('Kebakaran')">Kebakaran</button>
                    <button class="modal-button" onclick="showOtherStopReasonModal()">Lainnya</button>
                </div>
            </div>
        </div>

        <div id="other-stop-reason-modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closeOtherStopReasonModal()">×</button>
                <h2>Masukkan Alasan Lainnya</h2>
                <input type="text" id="other-stop-reason-input" class="input-field" placeholder="Masukkan alasan">
                <button class="modal-button" onclick="handleOtherStopReasonClick()">Submit</button>
            </div>
        </div>

        <div id="password-modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closePasswordModal()">×</button>
                <h2>Masukkan Password</h2>
                <input type="password" id="password-input" class="password-input" placeholder="Masukkan password">
                <button class="button" onclick="checkPassword()">Submit</button>
            </div>
        </div>

        <script>
            let isPaused = true; 
            let timerInterval;
            let totalSeconds = 0;
            let loseTimeInterval;
            let totalLoseSeconds = 0; // New variable for lost time

            // Object to hold counts for each NG category
            let ngCounts = {
                'Short Shoot': 0,
                'Silver': 0,
                'Scratch': 0,
                'Weldline': 0,
                'Flash': 0, // New Category
                'Burn Mark': 0, // New Category
                'Flow Lines': 0, // New Category
                'Lainnya': 0
            };

            function togglePause() {
                isPaused = !isPaused;
    const pauseIcon = document.getElementById('pause-icon');
    const notification = document.getElementById('notification');

    if (isPaused) {
        clearInterval(timerInterval);
        pauseIcon.classList.remove('fa-pause');
        pauseIcon.classList.add('fa-play');
        notification.textContent = "Mesin berhenti.";
        notification.className = "notification stopped"; // Tambahkan kelas untuk mesin berhenti
        showStopReasonModal(); // Tampilkan modal alasan mesin berhenti
        startLoseTime(); // Start counting lost time when machine stops
    } else {
        pauseIcon.classList.remove('fa-play');
        pauseIcon.classList.add('fa-pause');
        startTimer();
        notification.textContent = "Mesin berjalan.";
        notification.className = "notification running"; // Tambahkan kelas untuk mesin berjalan
        stopLoseTime(); // Stop counting lost time when machine runs

        // Reset totalLoseSeconds and update the display
        totalLoseSeconds = 0; // Reset lost time
        document.getElementById('lose-time').textContent = "00:00:00"; // Update display
    }

    notification.style.display = 'block'; // Tampilkan notifikasi
    setTimeout(() => {
        notification.style.display = 'none'; // Sembunyikan notifikasi setelah 3 detik
    }, 3000);

                notification.style.display = 'block'; // Tampilkan notifikasi
                setTimeout(() => {
                    notification.style.display = 'none'; // Sembunyikan notifikasi setelah 3 detik
                }, 3000);
            }

            function startLoseTime() {
                // Start counting lost time if not already running
                if (!loseTimeInterval) {
                    loseTimeInterval = setInterval(() => {
                        totalLoseSeconds++;
                        const hours = String(Math.floor(totalLoseSeconds / 3600)).padStart(2, '0');
                        const minutes = String(Math.floor((totalLoseSeconds % 3600) / 60)).padStart(2, '0');
                        const seconds = String(totalLoseSeconds % 60).padStart(2, '0');
                        document.getElementById('lose-time').textContent = `${hours}:${minutes}:${seconds}`;
                    }, 1000);
                }
            }

            function stopLoseTime() {
                clearInterval(loseTimeInterval);
                loseTimeInterval = null; // Reset the interval variable
            }

            function startTimer() {
                timerInterval = setInterval(() => {
                    totalSeconds++;
                    const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                    const seconds = String(totalSeconds % 60).padStart(2, '0');
                    document.getElementById('timer').textContent = `${hours}:${minutes}:${seconds}`;
                }, 1000);
            }

            function incrementCounter(type) {
                if (!isPaused) {
                    const counterElement = document.getElementById(`${type}-counter`);
                    counterElement.textContent = parseInt(counterElement.textContent) + 1;
                }
            }

            function showModal() {
                if (!isPaused) {
                    document.getElementById('modal').classList.add('active');
                }
            }

            function closeModal() {
                document.getElementById('modal').classList.remove('active');
            }

            function handleNgClick(issue) {
                incrementCounter('ng');
                ngCounts[issue]++;
                const countElement = document.getElementById(`${issue.toLowerCase().replace(' ', '-')}-count`);
                countElement.textContent = ngCounts[issue];
                console.log(`Issue reported: ${issue}`);
                closeModal();
            }

            function showOtherNgModal() {
                document.getElementById('other-ng-modal').classList.add('active');
            }

            function closeOtherNgModal() {
                document.getElementById('other-ng-modal').classList.remove('active');
            }

            function handleOtherNgClick() {
                const otherNgInput = document.getElementById('other-ng-input').value;
                if (otherNgInput) {
                    incrementCounter('ng');
                    ngCounts['Lainnya']++;
                    const countElement = document.getElementById('lainnya-count');
                    countElement.textContent = ngCounts['Lainnya'];
                    console.log(`Issue reported: ${otherNgInput}`);
                    closeOtherNgModal();
                    document.getElementById('other-ng-input').value = ''; // Reset input field
                } else {
                    alert('Silakan masukkan jenis masalah.');
                }
            }

            function showStopReasonModal() {
                document.getElementById('stop-reason-modal').classList.add('active');
            }

            function closeStopReasonModal() {
                document.getElementById('stop-reason-modal').classList.remove('active');
            }

            function handleStopReason(reason) {
                incrementCounter('ng'); // Menghitung sebagai NG
                // Tidak menghitung alasan berhenti ke kategori "Lainnya" di bar orange
                console.log(`Stop reason reported: ${reason}`);
                closeStopReasonModal();
            }

            function showOtherStopReasonModal() {
                document.getElementById('other-stop-reason-modal').classList.add('active');
            }

            function closeOtherStopReasonModal() {
                document.getElementById('other-stop-reason-modal').classList.remove('active');
            }

            function handleOtherStopReasonClick() {
                const otherStopReasonInput = document.getElementById('other-stop-reason-input').value;
                if (otherStopReasonInput) {
                    incrementCounter('ng'); // Menghitung sebagai NG
                    console.log(`Stop reason reported: ${otherStopReasonInput}`);
                    closeOtherStopReasonModal();
                    document.getElementById('other-stop-reason-input').value = ''; // Reset input field
                } else {
                    alert('Silakan masukkan alasan.');
                }
            }

            function showPasswordModal() {
                document.getElementById('password-modal').classList.add('active');
            }

            function closePasswordModal() {
                document.getElementById('password-modal').classList.remove('active');
            }

            function checkPassword() {
                const password = document.getElementById('password-input').value;
                if (password === 'selesai') {
                    alert('Shift ended. Data saved successfully!');
                    clearInterval(timerInterval);
                    clearInterval(loseTimeInterval); // Hentikan Lose Time saat shift berakhir
                    document.getElementById('pause-icon').classList.remove('fa-pause');
                    document.getElementById('pause-icon').classList.add('fa-play');
                    isPaused = true;
                    closePasswordModal();
                } else {
                    alert('Password salah! Silakan coba lagi.');
                }
            }
        </script>
    </x-app-layout>
</body>
</html>