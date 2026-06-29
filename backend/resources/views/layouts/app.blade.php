<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo de Productos</title>
    <script>
        (function(){
            if(localStorage.getItem('theme')==='dark')
                document.documentElement.setAttribute('data-bs-theme','dark');
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-label.required::after { content: " *"; color: #dc3545; }
        .form-control,
        .form-select,
        .input-group-text {
            background-color: #f8f9fa;
        }
        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff;
        }
        [data-bs-theme="dark"] {
            --bs-body-bg: #0f172a;
            --bs-body-bg-rgb: 15, 23, 42;
        }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #243247;
            border-color: #366ced;
            color: #f1f5f9;
            box-shadow: 0 0 0 0.25rem rgba(54, 108, 237, 0.25);
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #64748b;
        }
        [data-bs-theme="dark"] .form-control:disabled,
        [data-bs-theme="dark"] .form-control[readonly] {
            background-color: #0f172a;
            color: #64748b;
        }
        [data-bs-theme="dark"] .btn-primary {
            --bs-btn-bg: #1a5fd4;
            --bs-btn-border-color: #1a5fd4;
            --bs-btn-hover-bg: #1450b5;
            --bs-btn-hover-border-color: #1450b5;
            --bs-btn-active-bg: #1450b5;
        }
        [data-bs-theme="dark"] .btn-secondary {
            --bs-btn-bg: #495057;
            --bs-btn-border-color: #495057;
            --bs-btn-hover-bg: #3d4349;
            --bs-btn-hover-border-color: #3d4349;
        }
        [data-bs-theme="dark"] .btn-warning {
            --bs-btn-bg: #c9960a;
            --bs-btn-border-color: #c9960a;
            --bs-btn-hover-bg: #b08308;
            --bs-btn-hover-border-color: #b08308;
        }
        [data-bs-theme="dark"] .btn-danger {
            --bs-btn-bg: #b02a37;
            --bs-btn-border-color: #b02a37;
            --bs-btn-hover-bg: #9c2530;
            --bs-btn-hover-border-color: #9c2530;
        }
        [data-bs-theme="dark"] .btn-outline-secondary {
            --bs-btn-color: #adb5bd;
            --bs-btn-border-color: #adb5bd;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #6c757d;
            --bs-btn-hover-border-color: #6c757d;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #6c757d;
        }
        [data-bs-theme="dark"] .table {
            --bs-table-bg: #243247;
            --bs-table-border-color: #334155;
            --bs-table-hover-bg: #2e4060;
        }
        [data-bs-theme="dark"] thead.table-dark {
            --bs-table-bg: #212529;
            --bs-table-color: #f1f5f9;
            --bs-table-border-color: #334155;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Catálogo</a>
            <div class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
                <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                <a class="nav-link" href="{{ route('brands.index') }}">Marcas</a>
                <button id="theme-btn" type="button" class="btn btn-sm btn-outline-light" onclick="toggleAdminTheme()">🌙 Oscuro</button>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleAdminTheme() {
            var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            var btn = document.getElementById('theme-btn');
            if (isDark) {
                document.documentElement.removeAttribute('data-bs-theme');
                localStorage.setItem('theme', 'light');
                btn.textContent = '🌙 Oscuro';
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                btn.textContent = '☀️ Claro';
            }
        }

        (function(){
            if(localStorage.getItem('theme')==='dark')
                document.getElementById('theme-btn').textContent = '☀️ Claro';
        })();

        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                var btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.textContent = 'Guardando...';
                }
            });
        });
    </script>
</body>
</html>
