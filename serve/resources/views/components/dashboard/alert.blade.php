@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Erro",
                text: "{{ session('error') }}",
                showConfirmButton: true,
            });
        });
    </script>
@endif

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Sucesso",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif