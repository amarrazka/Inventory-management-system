<?php
// Sanitasi + validasi input barang. Mengembalikan [data_bersih, errors]
function proses_input_barang(array $post): array {
    $data = [
        'kode_barang' => trim(strip_tags($post['kode_barang'] ?? '')),
        'nama_barang' => trim(strip_tags($post['nama_barang'] ?? '')),
        'kategori'    => trim(strip_tags($post['kategori'] ?? '')),
        'jumlah'      => trim($post['jumlah'] ?? ''),
        'harga'       => trim($post['harga'] ?? ''),
        'lokasi'      => trim(strip_tags($post['lokasi'] ?? '')),
    ];
    $errors = [];

    // Percabangan if-else: kelengkapan data
    if ($data['kode_barang'] === '' || $data['nama_barang'] === '' || $data['kategori'] === ''
        || $data['jumlah'] === '' || $data['harga'] === '' || $data['lokasi'] === '') {
        $errors[] = t('err_required');
    } else {
        if (!preg_match('/^[A-Za-z0-9-]{1,20}$/', $data['kode_barang'])) {
            $errors[] = t('err_code_format');
        }
        // filter_var untuk memastikan tipe data
        $qty = filter_var($data['jumlah'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        if ($qty === false) { $errors[] = t('err_qty'); } else { $data['jumlah'] = $qty; }

        $harga = filter_var($data['harga'], FILTER_VALIDATE_FLOAT);
        if ($harga === false || $harga < 0) { $errors[] = t('err_price'); } else { $data['harga'] = $harga; }
    }
    return [$data, $errors];
}
