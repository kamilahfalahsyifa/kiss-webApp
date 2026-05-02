<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
            theme: {
                extend: {
                    colors: {
                        maroon: '#8B0A50',
                        'maroon-dark': '#6B0840',
                        'pink-bg': '#FDF4F5',
                        'pink-soft': '#FCE4EC',
                    }
                }
            },
            daisyui: {
                themes: [{
                    mytheme: {
                        "primary": "#8B0A50",
                        "secondary": "#AD3F73",
                        "accent": "#F06292",
                        "neutral": "#1f2937",
                        "base-100": "#ffffff",
                        "base-200": "#FDF4F5",
                        "base-300": "#f3f4f6",
                        "info": "#06b6d4",
                        "success": "#10b981",
                        "warning": "#f59e0b",
                        "error": "#ef4444",
                    }
                }]
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased">
    @yield('content')
</body>
</html>