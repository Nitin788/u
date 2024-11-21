<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>UNO-Hotels</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{asset('assets/img/favicon.jpg')}}" type="image/x-icon" />
    <style>
        strong.form-text.text-muted {
            align-items: center;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            /* Ensure it spans the full width of the form control */
            padding: 0.5rem;
            /* Padding to match other input fields */
            border: 1px solid #ced4da;
            /* Default border for form controls */
            border-radius: 0.25rem;
            /* Rounded corners like other inputs */
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
            background-color: #007bff;
            /* Set a default blue color for tags */
            padding: 2px 8px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput input {
            width: auto !important;
            /* Ensure new tags input fits properly */
        }

        .form-group label {
            font-weight: bold;
        }
    </style>

    <!-- Fonts and icons -->
    <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/kaiadmin.min.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">     

<body>
    <div class="wrapper">
        @include('admin.inc.sidebar')
        <div class="main-panel">
            @include('admin.inc.header')
            @yield('content')
            @include('admin.inc.footer')
        </div>
    </div>
    @stack('addCard')
    @stack('EditaddCard')
</body>

</html>