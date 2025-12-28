<?php
//logika pemrosesan form penilaian mahasiswa
//Deklarasi variabel
$nama = $nim = "";
$absen = $tugas = $uts = $uas = "";
$hasil_html = ""; 
$pesan_error = ""; 
$header_class = "bg-primary"; 
$btn_class = "btn-primary";   

//Pemicu proses saat tombol submit ditekan
if (isset($_POST['proses'])) {
    //Mengambil data dari form
    //trim digunakan untuk menghilangkan spasi berlebih
    $nama = trim($_POST['nama']); 
    $nim = trim($_POST['nim']);
    $absen = $_POST['kehadiran']; 
    $tugas = $_POST['tugas'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
    //202431188_Muhamad Ihsan Julianto//

    //Validasi input
    if ($nama === "" || $nim === "" || $absen === "" || $tugas === "" || $uts === "" || $uas === "") {
        $pesan_error = "Semua kolom harus diisi!";
    } 
    else {  //202431188_Muhamad Ihsan Julianto//
        
        $absen_val = floatval($absen);
        $tugas_val = floatval($tugas);
        $uts_val = floatval($uts);
        $uas_val = floatval($uas);

        $nilai_akhir = ($absen_val * 0.1) + ($tugas_val * 0.2) + ($uts_val * 0.3) + ($uas_val * 0.4);//100% = nilai_akhir

        //menentukan grade berdasarkan nilai akhir
        if ($nilai_akhir >= 85) $grade = 'A';
        elseif ($nilai_akhir >= 70) $grade = 'B';
        elseif ($nilai_akhir >= 55) $grade = 'C';
        elseif ($nilai_akhir >= 40) $grade = 'D';
        else $grade = 'E';

        //menentukan status lulus atau tidak
        $lulus = true;
        if ($absen_val < 70 || $nilai_akhir < 60 || $tugas_val < 40 || $uts_val < 40 || $uas_val < 40) {
            $lulus = false;
        }

        //menyiapkan teks dan warna berdasarkan status kelulusan
        if ($lulus) {
            $status_text = "LULUS";
            $alert_color = "alert-success"; 
        } else {
            $status_text = "TIDAK LULUS";
            $alert_color = "alert-danger";  
            $header_class = "bg-danger"; 
            $btn_class = "btn-danger";
        }

        //Membuat output hasil penilaian dalam format HTML
        $hasil_html = "
        <div class='alert $alert_color mt-4 shadow-sm' role='alert'>
            <h4 class='alert-heading'>Hasil Penilaian</h4>
            <hr>
            <p class='mb-1'><strong>Nama:</strong> $nama</p>
            <p class='mb-1'><strong>NIM:</strong> $nim</p>
            <p class='mb-1'><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>
            <p class='mb-1'><strong>Grade:</strong> $grade</p>
            <p class='mb-0'><strong>Status:</strong> <span class='fw-bold'>$status_text</span></p>
        </div>
        "; ///202431188_Muhamad Ihsan Julianto///
    }
}
?>

//Bagian tampilan form penilaian mahasiswa dalam HTML
<!DOCTYPE html>
<html lang="id">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; } 
    </style> 
</head>

<body>
    <div class="container mt-5 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header <?php echo $header_class; ?> text-white text-center py-3">
                <h2 class="h4 mb-0">Form Penilaian Mahasiswa</h2>
            </div> 
            
            <div class="card-body p-4">
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" value="<?php echo $nama; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIM</label>
                        <input type="number" class="form-control" name="nim" placeholder="Masukkan NIM" value="<?php echo $nim; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" name="kehadiran" placeholder="0 - 100" value="<?php echo $absen; ?>">
                        <div class="form-text text-muted">Wajib di atas 70% untuk lulus.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" name="tugas" placeholder="0 - 100" value="<?php echo $tugas; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" name="uts" placeholder="0 - 100" value="<?php echo $uts; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" name="uas" placeholder="0 - 100" value="<?php echo $uas; ?>">
                    </div>


                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="proses" class="btn <?php echo $btn_class; ?> btn-lg">Proses</button>
                    </div>

                    <?php if (!empty($pesan_error)) : ?>
                        <div class="alert alert-danger mt-3 mb-0 text-center" role="alert">
                            <strong><?php echo $pesan_error; ?></strong>
                        </div>
                    <?php endif; ?>

                </form>

                <?php echo $hasil_html; ?>

            </div>
        </div>
        <div class="text-center mt-3 text-muted">
            <small>&copy; 2025 Sistem Penilaian Akademik</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
