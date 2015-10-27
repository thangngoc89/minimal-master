<?php

//* [Dashboard] Add Archive Settings option to Books CPT
add_post_type_support( 'books', 'genesis-cpt-archives-settings' );

/**
 * [Dashboard] Add Genre Taxonomy to columns at http://example.com/wp-admin/edit.php?post_type=books
 * URL: http://make.wordpress.org/core/2012/12/11/wordpress-3-5-admin-columns-for-custom-taxonomies/
 */
add_filter( 'manage_taxonomies_for_books_columns', 'books_columns' );
function books_columns( $taxonomies ) {

	$taxonomies[] = 'genre';
	return $taxonomies;

}

//* [All Book pages] Function to display values of custom fields (if not empty)
function sk_display_custom_fields() {

	$book_price = get_field( 'book_price' );
	$book_author = get_field( 'book_author' );
	$book_published_year = get_field( 'book_published_year' );
	$book_purchase_link = get_field( 'book_purchase_link' );
  $book_download_link = get_field( 'book_download_link' );
  $book_language = get_field( 'book_language' );

	if ( $book_price || $book_author || $book_published_year || $book_purchase_link || $book_download_link ) {

		echo '<div class="book-meta">';

			if ( $book_price ) {
				echo '<p><strong>Price</strong>: $' . $book_price . '</p>';
			}

			if ( $book_author ) {
				echo '<p><strong>Author</strong>: ' . $book_author . '</p>';
			}

			if ( $book_published_year ) {
				echo '<p><strong>Year Published</strong>: ' . $book_published_year . '</p>';
			}

      if ( $book_language ) {
        switch ($book_language) {
          case 'english':
              $book_language_print = 'English';
            break;

          case 'vietnamese':
              $book_language_print = 'Tiếng Việt';
            break;

          default:
              $book_language_print = 'unknown';
            break;
        }
        echo '<p><strong>Language:</strong> ' . $book_language_print . '</p>';
      }

			if ( $book_purchase_link ) {
				echo '<p><a href="' . $book_purchase_link . '" target="_blank" rel="nofollow">Buy this book</a></p>';
			}

			$exploded_book_download_link = explode(PHP_EOL, $book_download_link);

			if (count($exploded_book_download_link) > 1) {

				foreach ($exploded_book_download_link as $i => $single_link) {
					if ($i == 0) {
						echo <<<EOD
							<div class="download">
								<a href="http://ouo.io/s/0G4vYlK2?s=$single_link" class="button main-button" target="_blank" rel="nofollow">Download</a>
								<a href="#" class="button dropdown-toggle" title="Mirror download link"></a>
							</div>
							<div class="dropdown-menu">
EOD;

					} elseif ($single_link != '') {
						echo '<a href="http://ouo.io/s/0G4vYlK2?s=' . $single_link . '" target="_blank" rel="nofollow">Mirror ' . $i . '</a>';
					}
				}
				echo '</div>';
			} else {
				// If this link has no mirror
				echo '<div class="download"><a href="http://ouo.io/s/0G4vYlK2?s=' . $book_download_link . '" class="button main-button no-dropdown-toggle" target="_blank" rel="nofollow">Download</a></div>';
			}


      //TODO: Add admin options for this
      echo '<p><a href="/huong-dan-tai-sach">(how to download this book)</a></p>';

		echo '</div>';

	}
}

//* [All Book pages] Show Genre custom taxonomy terms for Books CPT single pages, archive page and Genre taxonomy term pages
add_filter( 'genesis_post_meta', 'custom_post_meta' );
function custom_post_meta( $post_meta ) {

	if ( is_singular( 'books' ) || is_post_type_archive( 'books' ) || is_tax( 'genre' ) ) {
		$post_meta = '[post_terms taxonomy="genre" before="Genre: "]';
	}
	return $post_meta;

}

/**
 * [All Book pages] Display Post meta only if the entry has been assigned to any Genre term
 * Removes empty markup, '<p class="entry-meta"></p>' for entries that have not been assigned to any Genre
 */
function sk_custom_post_meta() {

	if ( has_term( '', 'genre' ) ) {
		genesis_post_meta();
	}

}

/**
 * [WordPress] Template Redirect
 * Use archive-books.php for Genre taxonomy archives.
 */
add_filter( 'template_include', 'sk_template_redirect' );
function sk_template_redirect( $template ) {

	if ( is_tax( 'genre' ) )
		$template = get_query_template( 'archive-books' );
	return $template;

}

/**
 * Only querry books on homepage
 */
add_action( 'pre_get_posts', 'include_books_in_home' );

function include_books_in_home( $query ) {

  if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
    $query->set( 'post_type', array( 'books' ) ); // Can add more to books array like page, post
  }
}

// Add books to feed
function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'books');
	return $qv;
}
add_filter('request', 'myfeed_request');

// yarpp_related(array( 'post_type' => array('books')));
// add_filter( 'kn_books_post_type', 'kn_books_post_type');
// function kn_books_post_type( $args ) {
// 	$arg['yarpp_support'] = true;
// 	return $args;
// }

//* Adding search form
add_action('genesis_before_content', 'parallax_toggle_search');
function parallax_toggle_search(){
  echo '<div class="search-wrap" id="toggle-search">' . "\n";

  echo get_search_form();

  echo '</div>' . "\n";
}
//* Rename search form text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Search books...' );
}
