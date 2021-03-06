<?php

function generate_download_area($book_download_link) {

  $exploded_book_download_link = explode(PHP_EOL, $book_download_link);
  // Remove all empty value
  $exploded_book_download_link = array_filter($exploded_book_download_link);

  // If this is a single download link
  if (count($exploded_book_download_link) <= 1) {
    $result = '<div class="download"><a href="'. generate_link($book_download_link) . '" class="button main-button no-dropdown-toggle" target="_blank" rel="nofollow" '. add_gg_tracking($single_link) . '>Download</a></div>';
    return $result;
  }

  // Let's move on the process mirror download link
  foreach ($exploded_book_download_link as $i => $single_link) {
    // First element - main download link
    if ($i == 0) {
      $result .= '
        <div class="download">
          <a href="'. generate_link($single_link) . '" class="button main-button" target="_blank" rel="nofollow" '. add_gg_tracking($single_link) . '>Download</a>
          <a href="#" class="button dropdown-toggle" title="Mirror download link"></a>
        </div>
        <div class="dropdown-menu">';
    } else {
    // Mirror link
      $result .= '<a href="'. generate_link($single_link) . '" target="_blank" rel="nofollow" '. add_gg_tracking($single_link) . '>Mirror ' . $i . '</a>';
    }
  }
  $result .= '</div>';

  return $result;
}

// Prefix link with shortener url
function generate_link($link, $url_prefix = null) {
  return get_shorten_url($link);
}

function add_gg_tracking($link) {
  return "onclick=\"ga('send', 'event', 'Books', 'clicked_download_button', '{$link}', 10, {nonInteraction: true})\"";
}
