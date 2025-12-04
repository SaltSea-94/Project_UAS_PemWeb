<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Maribaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root, [data-bs-theme="light"] {
            --bg-color: #f8f9fa; 
            --text-color: #212529; 
            --navbar-bg: #ffffff;
            --card-bg: #ffffff; 
            --border-color: #dee2e6; 
            --hover-bg: #f0f0f0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('https://images.pexels.com/photos/694740/pexels-photo-694740.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            z-index: -1;
        }

        [data-bs-theme="dark"] body::before {
            background-color: rgba(0, 0, 0, 0.5);
        }
        [data-bs-theme="dark"] {
            --bg-color: #212529; 
            --text-color: #dee2e6; 
            --navbar-bg: #343a40;
            --card-bg: #343a40; 
            --border-color: #495057; 
            --hover-bg: #495057;
        }

        .theme-switch-wrapper { 
            display: flex; 
            align-items: center; 
        }
        .theme-switch-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .theme-switch-container .nav-link {
            color: var(--text-color);
        }
        .theme-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }
        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 26px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #ff6600;
        }
        input:checked + .slider:before {
            transform: translateX(24px);
        }
        .theme-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #ffc107;;
            transition: color 0.4s;
        }
        .sun-icon {
            right: 6px;
            opacity: 0;
            color: #000000;
            display: none;
        }
        .moon-icon {
            left: 6px;
            opacity: 0;
            color: #fff;
            display: none;
        }
        .theme-switch-container input:checked ~ .sun-icon {
            right: 6px;
            opacity: 1;
            color: #000000;
            display: none;
        }
        .theme-switch-container input:checked ~ .moon-icon {
            left: 6px;
            opacity: 1;
            color: #fff;
            display: none;
        }
        input:checked ~ .sun-icon {
            opacity: 0;
        }
        input:checked ~ .moon-icon {
            opacity: 0;
        }
        .slider.round { 
            border-radius: 34px; 
        }
        .slider.round:before { 
            border-radius: 50%; 
        }
        
        [data-bs-theme="dark"] .list-group-item a,
        [data-bs-theme="dark"] .genre-tags a,
        [data-bs-theme="dark"] .card-title a,
        [data-bs-theme="dark"] .card-body a:not(.btn) {
            color: #f8f9fa !important;
        }
        
        [data-bs-theme="dark"] a:hover { 
            color: #adb5bd !important; 
        }
        
        [data-bs-theme="dark"] .list-group-item a:hover,
        
        [data-bs-theme="dark"] .genre-tags a:hover,
        
        [data-bs-theme="dark"] .card-title a:hover 
        
        {
            color: #adb5bd !important;
        }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-color); 
            color: var(--text-color); 
        }
        
        .navbar { 
            background-color: var(--navbar-bg); 
            border-bottom: 1px solid var(--border-color); 
        }
        
        .card { 
            background-color: var(--card-bg); 
            border-color: var(--border-color); 
        }
        
        .navbar-brand { 
            font-weight: 700; 
            color: #ff6600 !important; 
        }

        .theme-switch-wrapper { 
            display: flex; 
            align-items: center; 
        }
        .theme-switch { 
            display: inline-block; 
            height: 24px; 
            position: relative; 
            width: 48px; 
        }
        .theme-switch input { 
            display: none; 
        }
        .slider { 
            background-color: #ccc; 
            bottom: 0; 
            cursor: pointer; 
            left: 0; 
            position: absolute; 
            right: 0; 
            top: 0; 
            transition: .4s; 
        }
        .slider:before { 
            background-color: #fff; 
            bottom: 4px; 
            content: ""; 
            height: 16px; 
            left: 4px; 
            position: absolute; 
            transition: .4s; 
            width: 16px; 
        }
        input:checked + .slider { 
            background-color: #ff6600; 
        }
        input:checked + .slider:before { 
            transform: translateX(24px); 
        }
        .slider.round { 
            border-radius: 34px; 
        }
        .slider.round:before { 
            border-radius: 50%; 
        }
        
        .auth-container { 
            min-height: calc(100vh - 56px); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .theme-switch-container { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        
        .theme-switch { 
            position: relative; 
            display: inline-block; 
            width: 50px; 
            height: 26px; 
        }
        
        .theme-switch input { 
            opacity: 0; 
            width: 0; 
            height: 0; 
        }
        
        .slider { 
            position: absolute; 
            cursor: pointer; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0; 
            background-color: #ccc; 
            transition: .4s; 
            border-radius: 26px; 
        }
        
        .slider:before { 
            position: absolute; 
            content: ""; 
            height: 18px; 
            width: 18px; 
            left: 4px; 
            bottom: 4px; 
            background-color: white; 
            transition: .4s; 
            border-radius: 50%; 
        }
        
        input:checked + .slider { 
            background-color: #ff6600; 
        }
        
        input:checked + .slider:before { 
            transform: translateX(24px); 
        }

        .slider.round { 
            border-radius: 34px; 
        }
        
        .slider.round:before { 
            border-radius: 50%; 
        }
        
        .theme-icon { 
            font-size: 1rem; 
            color: var(--text-color); 
            transition: color 0.4s; 
        }
        
        .sun-icon { 
            display: none; 
        }
        
        .moon-icon { 
            display: none; 
        }
        
        .theme-switch-container input:checked ~ .sun-icon { 
            display: none; 
        }
        
        .theme-switch-container input:checked ~ .moon-icon { 
            display: none; 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand fs-4">Maribaca</span>
            <div class="theme-switch-container">
                <input type="checkbox" id="themeSwitch" hidden>
                <i class="bi bi-sun-fill theme-icon sun-icon"></i>
                <label class="theme-switch" for="themeSwitch"><span class="slider"></span></label>
                <i class="bi bi-moon-fill theme-icon moon-icon"></i>
    </div>
    </nav>

    <div class="auth-container">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        const themeSwitch = document.getElementById('themeSwitch');
        const htmlEl = document.documentElement;
        function setTheme(theme) {
            htmlEl.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }
        
        themeSwitch.addEventListener('change', function() {
            if (this.checked) { setTheme('dark'); } else { setTheme('light'); }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);
            if (savedTheme === 'dark') { themeSwitch.checked = true; }
        });
    </script>
</body>
</html>