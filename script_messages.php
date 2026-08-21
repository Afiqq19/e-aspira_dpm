<?php
$file = 'd:\antigravity\e-Aspira\app\Livewire\Admin\KelolaUuKema.php';
$content = file_get_contents($file);

$search = '    public function simpan()';
$replace = '    public function messages()
    {
        $fileSize = $this->file ? round($this->file->getSize() / 1024 / 1024, 2) : 0;
        return [
            ''file.max'' => "Ukuran file PDF yang Anda unggah terlalu besar ($fileSize MB). Maksimal ukuran yang diizinkan adalah 3 MB.",
            ''file.required'' => "File wajib dipilih atau gagal diunggah (Server Nginx/Apache menolak). Pastikan ukuran di bawah 3 MB!",
        ];
    }

    public function simpan()';

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);
echo "Added messages to KelolaUuKema";
