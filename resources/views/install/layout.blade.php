<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Instalasi E-Pilketos</title>
    <link href="{{ asset('Assets/vendor/inter.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/vendor/font-awesome.min.css') }}">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981;
            --danger: #ef4444;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .installer-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
        }

        .installer-header {
            background: var(--primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .installer-header h1 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .installer-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .steps-indicator {
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.1);
            padding: 1rem;
            gap: 1rem;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            opacity: 0.5;
            font-weight: 500;
        }

        .step.active {
            opacity: 1;
            font-weight: 700;
        }

        .step.completed {
            opacity: 0.8;
        }

        .step-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }
        
        .step.active .step-icon {
            background: white;
            color: var(--primary);
        }

        .step.completed .step-icon {
            background: var(--success);
            color: white;
        }

        .installer-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background-color: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }
        
        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .list-group-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }
        
        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="installer-container">
        <div class="installer-header">
            <h1>Setup E-Pilketos</h1>
            <p>Konfigurasi awal aplikasi pemilihan cerdas Anda.</p>
        </div>
        
        <div class="steps-indicator">
            <div class="step {{ request()->routeIs('install.index') ? 'active' : (request()->routeIs('install.*') && !request()->routeIs('install.index') ? 'completed' : '') }}">
                <div class="step-icon"><i class="fa-solid {{ request()->routeIs('install.index') ? 'fa-1' : 'fa-check' }}"></i></div>
                <span>Server</span>
            </div>
            <div class="step {{ request()->routeIs('install.database') ? 'active' : (request()->routeIs('install.setup') || request()->routeIs('install.complete') ? 'completed' : '') }}">
                <div class="step-icon"><i class="fa-solid {{ request()->routeIs('install.database') ? 'fa-2' : (request()->routeIs('install.setup') || request()->routeIs('install.complete') ? 'fa-check' : 'fa-2') }}"></i></div>
                <span>Database</span>
            </div>
            <div class="step {{ request()->routeIs('install.setup') ? 'active' : (request()->routeIs('install.complete') ? 'completed' : '') }}">
                <div class="step-icon"><i class="fa-solid {{ request()->routeIs('install.setup') ? 'fa-3' : (request()->routeIs('install.complete') ? 'fa-check' : 'fa-3') }}"></i></div>
                <span>Sistem</span>
            </div>
        </div>

        <div class="installer-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 0.5rem;"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
