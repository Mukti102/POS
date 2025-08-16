<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<script src="{{ asset('assets/js/feather.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script src="/assets/plugins/select2/js/custom-select.js"></script>

<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

<script src="/assets/js/feather.min.js"></script>



<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/plugins/toastr/toastr.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="/assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="/assets/plugins/sweetalert/sweetalerts.min.js"></script>


<script src="/assets/plugins/owlcarousel/owl.carousel.min.js"></script>



<script>
    

    $(".confirm-text").on("click", function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1,
        }).then(function(t) {
            t.value &&
                Swal.fire({
                    type: "success",
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    confirmButtonClass: "btn btn-success",
                });
        });
    }),
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



<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".delete-button");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest("form");

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
