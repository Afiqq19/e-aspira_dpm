<?php

return [
    'required' => 'Kolom :attribute wajib diisi.',
    'mimes' => 'Kolom :attribute harus berupa file dengan format: :values.',
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'file' => 'Kolom :attribute tidak boleh lebih dari :max kilobytes.',
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :max anggota.',
    ],
    'attributes' => [
        'file' => 'berkas (file)',
        'judul' => 'judul',
        'password' => 'kata sandi',
    ],
    'custom' => [
        'file' => [
            'required' => 'File tidak berhasil diunggah (Server menolak). Pastikan ukuran di bawah batas!',
            'max' => 'Ukuran file PDF yang Anda unggah terlalu besar (maksimal :max KB).',
            'mimes' => 'Format file harus PDF.',
        ],
    ],
];
