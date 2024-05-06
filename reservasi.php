<?php
include 'config.php';

if ($_POST['function'] == 'reservasi') {
    echo json_encode(reservasi($conn));
} else if ($_GET['tanggal']) {
    echo json_encode(cekJadwalKosong($_GET['tanggal'], $conn));
} else {
    echo json_encode(riwayat($conn));
}

function cekJadwalKosong($tanggal = null, $conn)
{
    if ($tanggal == null) {
        $tanggal = date("Y-m-d");
    }
    $query = "SELECT * FROM `reservasi` WHERE `tanggal` = '$tanggal';";
    $result = $conn->query($query);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row['jam_penyewaan'];
        }
    }
    $response = $rows;
    if ($rows == null) {
        $response = [];
    }
    return $response;
}


// function cariJadwalTerdekat($tanggal)
// {
// }


// function reservasiLapanganFutsalBruteForce($tanggal)
// {
//     if (cekJadwalKosong($tanggal)) {

//         echo "Reservasi lapangan futsal berhasil!";
//     } else {
//         $jadwalTerdekat = cariJadwalTerdekat($tanggal);
//         $jumlahHari = 1;


//         while (!$jadwalTerdekat && $jumlahHari <= 7) {
//             $tanggalBerikutnya = date('Y-m-d', strtotime($tanggal . ' + ' . $jumlahHari . ' days'));
//             $jadwalTerdekat = cariJadwalTerdekat($tanggalBerikutnya);
//             $jumlahHari++;
//         }

//         if ($jadwalTerdekat) {

//             echo "Reservasi lapangan futsal berhasil untuk jadwal: " . $jadwalTerdekat;
//         } else {
//             // Tidak ada jadwal kosong yang tersedia dalam 7 hari ke depan
//             echo "Tidak ada jadwal kosong yang tersedia dalam 7 hari ke depan.";
//         }
//     }
// }

// // Contoh penggunaan
// $tanggalYangDiinginkan = "2023-05-30";
// reservasiLapanganFutsalBruteForce($tanggalYangDiinginkan);

function reservasi($conn)
{
    $query = "INSERT INTO `reservasi` (nama,lapangan,tanggal,jam_penyewaan,durasi) VALUES ('$_POST[nama]','$_POST[lapangan]', '$_POST[tanggal]', '$_POST[penyewaan]', '1');";
    if (mysqli_query($conn, $query)) {
        http_response_code(200);
        return "Berhasil Reservasi";
    } else {
        http_response_code(400);
        return "Reservasi gagal, cek data anda kembali atau lapangan tidak tersedia!";
    };
};

function riwayat($conn)
{
    $query = "SELECT * FROM `reservasi`;";
    $result = $conn->query($query);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $response = $rows;
    return $response;
};
