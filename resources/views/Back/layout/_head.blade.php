<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Back/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('Back/assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('Back/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('Back/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('Back/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('Back/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('Back/vendors/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Back/vendors/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Back/vendors/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
