@if (session('success'))
    <script>
        swal("Success!", "{{ session('success') }}", "success");
    </script>
@endif

@if (session('error'))
    <script>
        swal("Oops!", "{{ session('error') }}", "error");
    </script>
@endif

@if (session('message'))
    <script>
        swal("Notice", "{{ session('message') }}", "info");
    </script>
@endif