<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.jpg" />

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="/assets/css/animate.css" />

    <link rel="stylesheet" href="/assets/plugins/owlcarousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="/assets/plugins/owlcarousel/owl.theme.default.min.css" />

    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css" />

    <link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="/assets/plugins/toastr/toatr.css" />


    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css" />

    <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body>
    @yield('content')

    <script src="/assets/js/jquery-3.6.0.min.js"></script>

    <script src="/assets/js/feather.min.js"></script>

    <script src="/assets/js/jquery.slimscroll.min.js"></script>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/plugins/select2/js/select2.min.js"></script>

    <script src="/assets/plugins/owlcarousel/owl.carousel.min.js"></script>

    <script src="/assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="/assets/plugins/sweetalert/sweetalerts.min.js"></script>


    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="/assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: '100%'
            });
        })
    </script>
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

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Kamu Tidak bisa Mengembalikan data ini!",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
