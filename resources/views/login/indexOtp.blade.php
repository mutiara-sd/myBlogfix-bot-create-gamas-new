<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --telkom-red: #E30613;
            --telkom-red-dark: #C8161D;
            --telkom-red-light: #ffebee;
        }
        
        .btn-telkom {
            background-color: var(--telkom-red);
            border-color: var(--telkom-red);
            color: white;
        }
        
        .btn-telkom:hover {
            background-color: var(--telkom-red-dark);
            border-color: var(--telkom-red-dark);
            color: white;
        }
        
        .text-telkom {
            color: var(--telkom-red);
        }
        
        .form-control:focus {
            border-color: var(--telkom-red);
            box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.25);
        }
        
        .logo-txt {
            font-weight: bold;
            color: var(--telkom-red);
            margin-left: 0.5rem;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 24rem;">
        <div class="text-center mb-3">
            <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="" height="28">
            <span class="logo-txt">Telkom Infrastruktur</span>
        </div>
        
        <h2 class="text-center fw-bold mb-4">OTP Verification</h2>
        
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="post">
            @csrf
            <div class="mb-3">
                <label class="form-label">Enter Code:</label>
                <input type="text" name="otp" class="form-control" required>
                @error('otp')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-telkom w-100">Verify</button>
        </form>

        <form id="resendOtpForm" onsubmit="sendOtp(event)" class="mt-3">
            @csrf
            <button id="resendOtpButton" type="submit" class="btn btn-secondary w-100">
                Kirim Ulang OTP
            </button>
        </form>    
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            checkCooldown();
        });

        function sendOtp(event) {
            event.preventDefault(); 

            let button = document.getElementById('resendOtpButton');

            fetch("{{ route('otp.send') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                if (status === 429) { 
                    let remainingTime = body.remaining * 1000;
                    localStorage.setItem('otpCooldown', Date.now() + remainingTime);
                    startCooldown(remainingTime);
                } else if (body.expires_at) { 
                    let remainingTime = 5 * 60 * 1000;
                    localStorage.setItem('otpCooldown', Date.now() + remainingTime);
                    startCooldown(remainingTime);
                    alert(body.message);
                } else {
                    alert(body.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function checkCooldown() {
            let cooldownTimestamp = localStorage.getItem('otpCooldown');
            let button = document.getElementById('resendOtpButton');

            if (!cooldownTimestamp) {
                button.disabled = false;
                button.textContent = "Kirim Ulang OTP";
                return;
            }

            let remainingTime = cooldownTimestamp - Date.now();
            if (remainingTime > 0) {
                startCooldown(remainingTime);
            } else {
                localStorage.removeItem('otpCooldown');
                button.disabled = false;
                button.textContent = "Kirim Ulang OTP";
            }
        }

        function startCooldown(timeRemaining) {
            let button = document.getElementById('resendOtpButton');
            button.disabled = true;

            let interval = setInterval(() => {
                if (timeRemaining <= 0) {
                    clearInterval(interval);
                    localStorage.removeItem('otpCooldown');
                    button.disabled = false;
                    button.textContent = "Kirim Ulang OTP";
                    return;
                }

                timeRemaining -= 1000;
                let minutes = Math.floor(timeRemaining / 60000);
                let seconds = Math.floor((timeRemaining % 60000) / 1000);
                button.innerText = `Tunggu ${minutes}:${seconds < 10 ? "0" : ""}${seconds} menit`;
            }, 1000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>