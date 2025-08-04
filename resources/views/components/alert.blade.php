@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "Success", {
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
        });
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
        });
    </script>
@endif
