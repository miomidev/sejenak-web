@if ($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops, Gagal!',
                text: '{!! str_replace("'", "\'", $errors->first()) !!}',
                confirmButtonColor: '#080330',
                confirmButtonText: 'Tutup',
                background: '#f7f7f7',
                customClass: {
                    popup: 'border-4 border-dark rounded-[24px] shadow-[3px_4px_0_#080330]',
                    confirmButton: 'bg-[#94B704] text-dark font-bold px-6 py-2 border-2 border-dark shadow-[3px_4px_0_#080330] hover:bg-[#a9d1a9] transition-all'
                }
            });
        });
    </script>
@endif
