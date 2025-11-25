document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('orderForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Ambil nilai
        const name = form.name.value.trim();
        const email = form.email.value.trim();
        const service = form.service.value;
        const description = form.description.value.trim();

        if (!name || !email || !service || !description) {
            alert('Mohon lengkapi semua kolom dengan benar.');
            return;
        }

        // Validasi email sederhana
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Mohon masukkan email yang valid.');
            form.email.focus();
            return;
        }

        if (confirm(`Apakah Anda yakin ingin mengirim pesanan untuk layanan "${service}"?`)) {
            // Lewatkan submit agar PHP proses
            form.submit();
        }
    });
});