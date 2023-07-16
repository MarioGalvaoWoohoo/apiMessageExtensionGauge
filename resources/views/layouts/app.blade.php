<!DOCTYPE html>
<html>
<head>
    <title>Gauge Dashboard Extension</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Inclua os links para os arquivos CSS do Bootstrap e do seu aplicativo -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" integrity="sha384-..." crossorigin="anonymous">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- DataTables Ajax JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.jqueryui.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</head>
<body>
    @yield('content')

    <!-- Inclua o link para o arquivo JavaScript do seu aplicativo -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
