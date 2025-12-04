<!DOCTYPE html>
<html lang="en" data-bs-theme="light"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MariBaca</title>
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
        [data-bs-theme="dark"] {
            --bg-color: #212529; 
            --text-color: #dee2e6; 
            --navbar-bg: #343a40;
            --card-bg: #343a40; 
            --border-color: #495057; 
            --hover-bg: #495057;
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
        .card, .list-group-item { 
            background-color: var(--card-bg) !important; 
            border-color: var(--border-color) !important; 
        }
        .navbar-brand { 
            font-weight: 700; color: #ff6600 !important; 
        }
        .navbar-profile-pic { 
            width: 40px; 
            height: 40px; 
            object-fit: cover; 
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
            display: inline-block;
        }
        .theme-switch-container input:checked ~ .sun-icon {
            right: 6px;
            opacity: 1;
            color: #000000;
            display: inline-block;
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
        .navbar-profile-pic { 
            width: 40px; 
            height: 40px; 
            object-fit: cover; 
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
        .search-container { 
            position: relative; 
        }
        #searchResults {
            position: absolute; 
            top: 100%; 
            left: 0; 
            right: 0; 
            z-index: 1000;
            background-color: var(--card-bg); 
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 .375rem .375rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
            overflow: hidden;
        }
        #searchResults a {
            display: block; 
            padding: .75rem 1rem;
            color: var(--text-color);
            text-decoration: none;
        }
        #searchResults a:hover {
            background-color: var(--hover-bg); 
        }
        .btn-contrast {
            background-color: var(--text-color);
            color: var(--bg-color);
            border: 1px solid var(--text-color);
        }
        .btn-contrast:hover {
            background-color: var(--bg-color);
            color: var(--text-color);
            border: 1px solid var(--text-color);
        }
        .dot {
            height: 10px;
            width: 10px;
            background-color: #198754;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="/">MariBaca</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="mx-auto search-container" style="width: 50%;">
                    <form class="d-flex" role="search" autocomplete="off">
                        <input class="form-control" type="search" id="searchInput" placeholder="Cari Cerita" aria-label="Search">
                    </form>
                    <div id="searchResults"></div>
                </div>

                <div class="navbar-nav ms-auto align-items-center">
                    <div class="theme-switch-container ms-3 me-2">
                        <label class="theme-switch" for="themeSwitch">
                            <input type="checkbox" id="themeSwitch">
                            <span class="slider">
                                <i class="bi bi-moon-fill theme-icon moon-icon"></i>
                                <i class="bi bi-sun-fill theme-icon sun-icon"></i>
                            </span>
                        </label>
                        <span id="theme-label" class="nav-link p-0">Dark Mode</span>
                    </div>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://pbs.twimg.com/media/FdChU06XwAQrVCJ.jpg" class="rounded-circle navbar-profile-pic" alt="Profil">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profil">Profil Saya</a></li>
                            <li><a class="dropdown-item" href="/">Beranda</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">@yield('content')</main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const stories = [
            { title: 'The Unkindled Of The Broken Soil', url: '/story/the-unkindled' },
            { title: 'Broken World', url: '#' },
            { title: 'Asteria', url: '#' }
        ];
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            searchResults.innerHTML = '';
            if (query.length > 0) {
                const filteredStories = stories.filter(story => story.title.toLowerCase().includes(query));
                filteredStories.forEach(story => {
                    const link = document.createElement('a');
                    link.href = story.url;
                    link.textContent = story.title;
                    searchResults.appendChild(link);
                });
            }
        });
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target)) { searchResults.innerHTML = ''; }
        });

        const themeSwitch = document.getElementById('themeSwitch');
        const htmlEl = document.documentElement;
        const themeLabel = document.getElementById('theme-label');

        function setTheme(theme) {
            htmlEl.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);

            if (theme === 'dark') {
                themeLabel.textContent = 'Dark Mode';
            } else {
                themeLabel.textContent = 'Light Mode';
            }
        }

        themeSwitch.addEventListener('change', function() {
            if (this.checked) {
                setTheme('dark');
            } else {
                setTheme('light');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
                setTheme(savedTheme);
            if (savedTheme === 'dark') {
                themeSwitch.checked = true;
            }
        });
    </script>
</body>
</html>