<!DOCTYPE html>
<html lang="en">

<head>
    <x-blocks.meta />

    <title> {{ $pageTitle }} | </title>
    {{-- style links --}}
    <x-blocks.stylesheet />
</head>

<body class="nav-md">
    @if (session('success'))
        <div class="alert alert-success" style="margin: 15px 20px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="margin: 15px 20px 0;">
            {{ session('error') }}
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-warning" style="margin: 15px 20px 0;">
            <ul style="margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot }}

    <x-blocks.script />

    <script>
        var options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    @if (session()->has('success'))
    <script>
        toastr.success("{{ session()->get('success') }}", 'Success', options);
    </script>
    @endif


    @if (session()->has('error'))
    <script>
        toastr.error("{{ session()->get('error') }}", 'Error', options);
    </script>
    @endif


</body>

</html>
