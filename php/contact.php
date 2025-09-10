<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // === KONFIGURASI ===
    $recipient_email    = "davara.advertisement@gmail.com"; // Ganti dengan email tujuan Anda
    $subject            = "Pesan Baru dari Website Davara";
    // ===================

    // Ambil data dari formulir
    $name    = filter_var(trim($_POST["your-name"]), FILTER_SANITIZE_STRING);
    $phone   = filter_var(trim($_POST["your-phone"]), FILTER_SANITIZE_STRING);
    $email   = filter_var(trim($_POST["your-email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["your-text"]), FILTER_SANITIZE_STRING);

    // Validasi sederhana
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Mohon isi semua kolom dengan benar.";
        exit;
    }

    // Buat konten email
    $email_content = "Nama: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Telepon: $phone\n\n";
    $email_content .= "Pesan:\n$message\n";

    // Buat headers email
    $email_headers = "From: $name <$email>";

    // Kirim email
    if (mail($recipient_email, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Terima kasih! Pesan Anda telah terkirim.";
    } else {
        http_response_code(500);
        echo "Oops! Terjadi kesalahan dan kami tidak bisa mengirim pesan Anda.";
    }

} else {
    http_response_code(403);
    echo "Terjadi masalah dengan pengiriman, mohon coba lagi.";
}
?>