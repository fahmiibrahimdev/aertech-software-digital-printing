<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <title>{{ $title }} &mdash; Aplikasi Point Of Sales</title>

        <!-- General CSS Files -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
            integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap"
            rel="stylesheet"
        />
        <link href="{{ asset('/select2/select2.min.css') }}" rel="stylesheet" />
        <link
            rel="stylesheet"
            href="{{ asset('/css/app.css') }}?_={{ rand(1000, 2000) }}"
        />

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('/fpro/css/all.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/style.css') }}" />
        @livewireStyles

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}" />
        <link
            rel="stylesheet"
            href="{{ asset('/assets/css/components.css') }}"
        />
    </head>

    <body class="layout-3" style="font-family: Inter">
        @yield('content')

        <!-- General JS Scripts -->
        <script src="{{ asset('/select2/jquery.min.js') }}"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"
        ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="{{ asset('/assets/js/stisla.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- JS Libraies -->
        <script src="{{ asset('/js/app.js') }}?_={{
                rand(1000, 2000)
            }}"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('/select2/select2.full.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="{{ asset('/assets/js/scripts.js') }}"></script>

        @yield('js') @livewireScripts {{--
        <script src="{{ asset('/assets/livewire.js') }}"></script>
        --}} @stack('scripts')

        <!-- Template JS File -->
        <script src="{{ asset('/assets/js/custom.js') }}"></script>

        <!-- Page Specific JS File -->
    </body>
</html>
