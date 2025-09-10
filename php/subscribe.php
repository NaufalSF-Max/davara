<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // === KONFIGURASI ===
    $recipient_email    = "davara.advertisement@gmail.com"; // Email Anda untuk menerima notifikasi
    $subject            = "Langganan Newsletter Baru dari Davara";
    $file_to_save_email = "subscribers.txt"; // File untuk menyimpan daftar email
    // ===================

    // Ambil data dari formulir
    $email = filter_var(trim($_POST["subscribe"]), FILTER_SANITIZE_EMAIL);

    // Validasi email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Bisa dikirim sebagai error atau diabaikan
        http_response_code(400);
        echo "Email tidak valid.";
        exit;
    }

    // Simpan email ke file teks
    $file_content = $email . "\n";
    file_put_contents($file_to_save_email, $file_content, FILE_APPEND | LOCK_EX);

    // Buat konten notifikasi email (opsional)
    $email_content = "Email baru telah berlangganan: $email";
    $email_headers = "From: Website Davara <no-reply@davara.com>";

    // Kirim notifikasi (opsional)
    mail($recipient_email, $subject, $email_content, $email_headers);

    // Respon sukses (tanpa pesan agar tidak mengganggu)
    http_response_code(200);
    // Anda bisa menambahkan pesan sukses jika mau, contoh: echo "Terima kasih telah berlangganan!";

} else {
    http_response_code(403);
    echo "Akses ditolak.";
}
?>