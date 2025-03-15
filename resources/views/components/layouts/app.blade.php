<!DOCTYPE html>
<html>
<head>
    <title>DeepRent Developer Technical Assessment</title>
    @vite('resources/js/app.js')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    @livewireStyles
</head>
<body class="p-8">
    {{ $slot }}

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
