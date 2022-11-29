<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel Management System</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Sidemenu Css -->
    <link href="{{ asset('/assets/css/sidemenu.css')}}" rel="stylesheet" />

    <!-- Dashboard Css -->
    <link href="{{ asset('/assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/admin-custom.css')}}" rel="stylesheet" />

    <!-- c3.js Charts Plugin -->
    <link href="{{ asset('/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet" />

    <!-- p-scroll bar css-->
    <link href="{{ asset('/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

    <!---Font icons-->
    <link href="{{ asset('/assets/css/icons.css')}}" rel="stylesheet" />

    <!---P-scroll Bar css -->
    <link href="{{ asset('/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

    <!-- Color Skin css -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/color-skins/color6.css')}}" />

    <link rel="icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" />

    <!-- Data table css -->
    <link href="{{ asset('/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css')}}" rel='stylesheet' />
    <link href="{{ asset('/assets/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />

    <!-- floara editotr -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <style>
        tr th {
            background-color: #a7947a;
            color: white !important;
        }

        div.r_detail {
            background-color: white;
            width: 600px;
            height: 110px;
            overflow: scroll;
            padding: 10px;
        }

        /* tr td{
			background-color: #a29b91;
			color: white;
		} */
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Data tables -->
    <script src="{{ asset('/assets/js/jquery-3.2.1.min.js')}}"></script>

    <!-- Bootstrap js -->
    <script src="{{ asset('/assets/plugins/bootstrap-4.3.1/js/popper.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('/assets/js/wizard.js')}}"></script>
    <!-- <script src="{{ asset('/assets/js/myscript.js')}}"></script> -->
    <script src="{{ asset('/assets/js/datatable.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
    <script src="{{ asset('/assets/js/myscript.js') }}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/moment.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{ asset('/assets/js/fullcalendar.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js">
    </script>


</body>

</html>