<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MindLink</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-image: url('{{ asset('images/batstateu-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 48px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 12px;
            color: #1f2937;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 32px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.2s;
            background: #f9fafb;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #374151;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #ff8b94;
            background: white;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 4px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #ff8b94;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #ff7580;
            transform: translateY(-2px);
        }

        .info-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fef3c7;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 24px;
            font-size: 13px;
            color: #92400e;
        }

        .link-text {
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .link-text a {
            color: #ff8b94;
            text-decoration: none;
            font-weight: 600;
        }

        .link-text a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeSelect = document.getElementById('user_type');
            const collegeField = document.getElementById('college_field');
            const collegeSelect = document.getElementById('college');

            function toggleCollegeField() {
                if (userTypeSelect.value === 'Student') {
                    collegeField.style.display = 'block';
                    collegeSelect.setAttribute('required', 'required');
                } else {
                    collegeField.style.display = 'none';
                    collegeSelect.removeAttribute('required');
                    collegeSelect.value = '';
                }
            }

            // Initial check on page load
            toggleCollegeField();

            // Listen for changes
            userTypeSelect.addEventListener('change', toggleCollegeField);
        });

        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleButton = event.target.closest('button');
            const eyeIcon = toggleButton.querySelector('.eye-icon');
            const eyeSlashIcon = toggleButton.querySelector('.eye-slash-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';
            } else {
                passwordField.type = 'password';
                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU Logo">
        </div>
        <h1>Welcome to MindLink</h1>
        <p class="subtitle">Your safe space for mental health support and well-being</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="e.g., 21-12345g.batstate-u.edu.ph">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_type">I am a...</label>
                <select id="user_type" name="user_type" required>
                    <option value="">Select your role</option>
                    <option value="Student" {{ old('user_type', '') == 'Student' ? 'selected' : '' }}>Student</option>
                    <option value="Administrator" {{ old('user_type', '') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('user_type')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" id="college_field" style="display: none;">
                <label for="college">College</label>
                <select id="college" name="college">
                    <option value="">Select your college</option>
                    <option value="College of Engineering" {{ old('college', '') == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                    <option value="College of Engineering Technology" {{ old('college', '') == 'College of Engineering Technology' ? 'selected' : '' }}>College of Engineering Technology</option>
                    <option value="College of Informatics and Computing Sciences" {{ old('college', '') == 'College of Informatics and Computing Sciences' ? 'selected' : '' }}>College of Informatics and Computing Sciences</option>
                    <option value="College of Architecture Fine Arts and Design" {{ old('college', '') == 'College of Architecture Fine Arts and Design' ? 'selected' : '' }}>College of Architecture Fine Arts and Design</option>
                </select>
                @error('college')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Continue to MindLink</button>

            <div class="info-box">
                🔒 All conversations are confidential and anonymous
            </div>
        </form>

        <div class="link-text">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
        </div>
    </div>
</body>
</html>