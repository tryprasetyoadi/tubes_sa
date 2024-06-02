<?php
include 'config.php';
header('Content-Type: application/json');

if (isset($_POST['function']) && $_POST['function'] == "reservasi") {
    echo json_encode(reservasi($conn));
} elseif (isset($_GET['tanggal'])) {
    echo json_encode(cekJadwalKosong($_GET['tanggal'], $conn));
} else {
    echo json_encode(riwayat($conn));
}

function cekJadwalKosong($tanggal, $conn)
{
    if ($tanggal == null) {
        $tanggal = date("Y-m-d");
    }
    $tanggal = $conn->real_escape_string($tanggal);
    $query = "SELECT jam_penyewaan FROM `reservasi` WHERE `tanggal` = '$tanggal';";
    $result = $conn->query($query);
    $rows = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row['jam_penyewaan'];
        }
    }
    return $rows;
}

function reservasi($conn)
{
    $nama = $conn->real_escape_string($_POST['nama']);
    $kereta = $conn->real_escape_string($_POST['kereta']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $kursi = $conn->real_escape_string($_POST['kursi']);

    $query = "INSERT INTO `reservasi` (nama, kereta, tanggal, kursi, confirm) VALUES ('$nama', '$kereta', '$tanggal', '$kursi', '1');";

    if (mysqli_query($conn, $query)) {
        http_response_code(200);
        return ["message" => "Berhasil Reservasi"];
    } else {
        http_response_code(400);
        return ["message" => "Reservasi gagal, cek data anda kembali atau kereta api tidak tersedia!"];
    }
}

function riwayat($conn)
{
    $query = "SELECT * FROM `reservasi`;";
    $result = $conn->query($query);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}
