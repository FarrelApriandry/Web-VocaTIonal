<!-- @/Views/Components/Header.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $title ?? 'VocaTIonal' ?> | Wadah Aspirasi Mahasiswa TI Untidar</title>
    <meta name="title" content="<?= $title ?? 'VocaTIonal' ?> - Suara Mahasiswa TI">
    <meta name="description" content="Platform resmi aspirasi mahasiswa Teknik Informatika UNTIDAR. Sampaikan keluhan, saran, dan ide lo untuk prodi yang lebih baik.">
    <meta name="keywords" content="VocaTIonal, Himatif Untidar, Aspirasi Mahasiswa, Teknik Informatika, Tidar University">
    <meta name="author" content="Tim VocaTIonal">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://vocational.info/">
    <meta property="og:title" content="<?= $title ?? 'VocaTIonal' ?> - Suara Mahasiswa TI">
    <meta property="og:description" content="Punya keluhan soal fasilitas atau kurikulum? Sampaikan lewat VocaTIonal. Dari mahasiswa, untuk prodi.">
    <meta property="og:image" content="https://vocational.info/assets/img/og-preview.png"> <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://vocational.info/">
    <meta property="twitter:title" content="<?= $title ?? 'VocaTIonal' ?> - Suara Mahasiswa TI">
    <meta property="twitter:description" content="Wadah aspirasi terintegrasi mahasiswa Teknik Informatika. Aman, transparan, dan Zero Trust.">
    <meta property="twitter:image" content="https://vocational.info/assets/img/og-preview.png">

    <link rel="icon" type="image/svg+xml" href="./assets/img/logo-himatif.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
        .glass-card { background: white; border-radius: 24px; border: 1px solid #E5E7EB; }
        .btn-category { border: 1px solid #9CA3AF; border-radius: 12px; transition: all 0.3s; }
        .btn-category.active { background-color: #1E3A8A; color: white; border-color: #1E3A8A; }
        .info-card { background-color: #1E3A8A; border-radius: 16px; color: white; }
        input:checked ~ .dot { transform: translateX(1.5rem); background-color: #DBEAFE; }
        input:checked ~ .block { background-color: #1E3A8A; }
        .fade-out { opacity: 0; transition: opacity 0.5s ease-out; pointer-events: none; }
        .fade-in { opacity: 1 !important; transform: translateY(0) !important; transition: all 0.6s ease-out; }
        #main-content { opacity: 0; transform: translateY(10px); }
    </style>
</head>
<body class="min-h-screen">