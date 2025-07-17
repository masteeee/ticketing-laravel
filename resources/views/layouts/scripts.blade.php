<script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const refreshBtn = document.getElementById('refresh-department');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                if (!confirm("Yakin ingin refresh department?")) return;
    
                fetch("{{ route('admin.departments.refresh') }}", {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Gagal: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat melakukan refresh.');
                });
            });
        }
    });
    </script>
    