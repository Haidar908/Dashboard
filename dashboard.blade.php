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
            justify-content: space-around;
            gap: 20px;
            color: white;
            background-color: orange;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .ng-summary div {
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
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
            justify-content: center;
            align-items: center;
        }

        .button-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .close-button {
            cursor: pointer;
            float: right;
        }

        .modal-button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-button {
            padding: 10px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal-button:hover {
            background-color: darkorange;
        }

        .notification {
            margin: 20px 0;
            padding: 10px;
            color: white;
            border-radius: 5px;
            display: none;
        }

        .notification.running {
            background-color: green;
        }

        .notification.stopped {
            background-color: red;
        }

        .input-field {
            margin-top: 10px;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

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

        td {
            background-color: #f9f9f9; /* Warna latar belakang untuk sel tabel */
            color: #333; /* Warna teks untuk sel tabel */
        }

        .lose-time-box {
            background-color: #fff;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            margin: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .lose-time-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .lose-time {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Operator Dashboard') }}
                </h2>
            </div>
        </x-slot>

        <div id="notification" class="notification"></div>

        <div class="ng-summary">
            <div>Short Shoot: <span id="short-shoot-count">0</span></div>
            <div>Silver: <span id="silver-count">0</span></div>
            <div>Scratch: <span id="scratch-count">0</span></div>
            <div>Weldline: <span id="weldline-count">0</span></div>
            <div>Flash: <span id="flash-count">0</span></div>
            <div>Burn Mark: <span id="burn-mark-count">0</span></div>
            <div>Flow Lines: <span id="flow-lines-count">0</span></div>
            <div>Bubble: <span id="bubble-count">0</span></div>
            <div>Lainnya: <span id="lainnya-count">0</span></div>
        </div>

        <div class="lose-time-box">
            <div class="lose-time-title">Lose Time</div>
            <div id="lose-time" class="lose-time">00:00:00</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No Mesin</th>
                    <th>Nama Mesin</th>
                    <th>Part Mesin</th>
                    <th>Target Running(Menit)</th>
                    <th>Shift</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ session('no_mesin') }}</td>
                    <td>{{ session('nama_mesin') }}</td>
                    <td>{{ session('part_mesin') }}</td>
                    <td>{{ session('target_jam_running') }}</td>
                    <td>{{ session('shift') }}</td>
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
                        <i id="pause-icon" class="fas fa-pause"></i>
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
        </div>

        <div id="modal" class="modal">
            <div class="modal-content">
                <h2>Pilih Jenis Masalah</h2>
                <div class="modal-button-container">
                    <button class="modal-button" onclick="handleNgClick('Short Shoot')">Short Shoot</button>
                    <button class="modal-button" onclick="handleNgClick('Silver')">Silver</button>
                    <button class="modal-button" onclick="handleNgClick('Scratch')">Scratch</button>
                    <button class="modal-button" onclick="handleNgClick('Weldline')">Weldline</button>
                    <button class="modal-button" onclick="handleNgClick('Flash')">Flash</button>
                    <button class="modal-button" onclick="handleNgClick('Burn Mark')">Burn Mark</button>
                    <button class="modal-button" onclick="handleNgClick('Flow Lines')">Flow Lines</button>
                    <button class="modal-button" onclick="handleNgClick('Bubble')">Bubble</button>
                    <button class="modal-button" onclick="handleNgClick('Lainnya')">Lainnya</button>
                </div>
            </div>
        </div>

        <div id="other-ng-modal" class="modal">
            <div class="modal-content">
                <button class="close-button" onclick="closeOtherNgModal ()">×</button>
                <h2>Masukkan Jenis Masalah Lainnya</h2>
                <input type="text" id="other-ng-input" class="input-field" placeholder="Masukkan jenis masalah">
                <button class="modal-button" onclick="handleOtherNgClick()">Submit</button>
            </div>
        </div>

        <div id="stop-reason-modal" class="modal">
            <div class="modal-content">
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
            let totalLoseSeconds = 0;

            let ngCounts = {
                'Short Shoot': 0,
                'Silver': 0,
                'Scratch': 0,
                'Weldline': 0,
                'Flash': 0,
                'Burn Mark': 0,
                'Flow Lines': 0,
                'Bubble': 0,
                'Lainnya': 0
            };

            function startTimer() {
                timerInterval = setInterval(() => {
                    totalSeconds++;
                    const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                    const seconds = String(totalSeconds % 60).padStart(2, '0');
                    document.getElementById('timer').textContent = `${hours}:${minutes}:${seconds}`;
                }, 1000);
            }

            function showNotification(message, type) {
                const notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = `notification ${type}`;
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            }

            function onLogin() {
                isPaused = false; 
                startTimer(); 
                document.getElementById('pause-icon').classList.remove('fa-play'); 
                document.getElementById('pause-icon').classList.add('fa-pause'); 
                showNotification("Mesin berjalan.", "running"); 
            }

            document.addEventListener('DOMContentLoaded', (event) => {
                onLogin(); 
            });

            function togglePause() {
            isPaused = !isPaused;
            const pauseIcon = document.getElementById('pause-icon');

            if (isPaused) {
            clearInterval(timerInterval);
            startLoseTime(); // Mulai lose time saat mesin berhenti
            pauseIcon.classList.remove('fa-pause');
            pauseIcon.classList.add('fa-play');
            showNotification("Mesin berhenti.", "stopped");
            showStopReasonModal();
            } else {
            stopLoseTime(); // HENTIKAN lose time saat mesin mulai berjalan lagi
            pauseIcon.classList.remove('fa-play');
            pauseIcon.classList.add('fa-pause');
            startTimer();
            showNotification("Mesin berjalan.", "running");
            }
            }

            function stopLoseTime() {
            if (loseTimeInterval) {
            clearInterval(loseTimeInterval);
            loseTimeInterval = null; // Pastikan loseTimeInterval di-reset
            }
            }

            function startLoseTime() {
                if (!loseTimeInterval) {
                    totalLoseSeconds =  0;
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
                loseTimeInterval = null;
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
                if (issue === 'Lainnya') {
                    ngCounts['Lainnya']++;
                    const countElement = document.getElementById('lainnya-count');
                    countElement.textContent = ngCounts['Lainnya'];
                } else {
                    ngCounts[issue]++;
                    const countElement = document.getElementById(`${issue.toLowerCase().replace(' ', '-')}-count`);
                    countElement.textContent = ngCounts[issue];
                }
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
                    closeOtherNgModal();
                    document.getElementById('other-ng-input').value = '';
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
                incrementCounter('ng');
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
                    closeOtherStopReasonModal();
                    closeStopReasonModal(); 
                    document.getElementById('other-stop-reason-input').value = '';
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
                    clearInterval(loseTimeInterval);
                    document.getElementById('pause-icon').classList.remove('fa-pause');
                    document.getElementById('pause-icon').classList.add('fa-play');
                    isPaused = true;
                    window.location.href = "{{ route('logout.combo') }}";
                    closePasswordModal();
                } else {
                    alert('Password salah! Silakan coba lagi.');
                }
            }
        </script>
    </x-app-layout>
</body>
</html>