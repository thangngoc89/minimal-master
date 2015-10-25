jQuery(document).ready(function() {

  jQuery(".toggle-search a").click(function() {

    jQuery(".search-wrap").slideToggle('slow', function() {
      jQuery(".toggle-search").toggleClass('active');
    });

  });
})
