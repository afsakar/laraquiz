<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).data('url');
        Swal.fire({
            title: '{{ __('general.deleteAlertTitle') }}',
            text: '{{ __('general.deleteAlertText') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __('general.yes') }}',
            cancelButtonText: '{{ __('general.cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
</script>
