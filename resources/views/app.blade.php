<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="mytheme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'KISS' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            daisyui: {
                themes: [{
                    mytheme: {
                        "primary": "#2563eb",
                        "secondary": "#7c3aed",
                        "accent": "#f59e0b",
                        "neutral": "#1f2937",
                        "base-100": "#ffffff",
                        "info": "#06b6d4",
                        "success": "#10b981",
                        "warning": "#f59e0b",
                        "error": "#ef4444",
                    }
                }]
            }
        }
    </script>
</head>
<body>
    @yield('content')
</body>
</html>
