function set_book_download_link_value(fieldValue, nonce) {
        // refresh the quick menu properly
        inlineEditPost.revert();
        console.log(fieldValue);
        decode_string = atob(fieldValue);
        jQuery('#book_download_link').html(decode_string);
}
