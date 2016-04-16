$(function() {
  correctCode();

  $('.tabheading>li').click(function() {
    var index = $(this).attr('example-index');
    var tabs = $('.tabheading>li');
    var section = $(this).closest('section');
    var examples = $('.example');
    var selected = $('.example[index="'+index+'"]');
    var selectedTab = $('li[example-index="'+index+'"]');

    console.log(section);

    section.find(examples).hide();
    selected.show();
    section.find(tabs).removeClass('selected');
    selectedTab.addClass('selected');
  });

  $('.search-toggle').click(function(e) {
    e.preventDefault();
    $('#search').toggleClass('active');
    $('#search input').focus();
  });

  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 600);
          return false;
        }
      }
    });
  });


  // Close search on esc
  $(document).keyup(function(e) {
   if ( e.keyCode == 27 ) {
      $('#search').removeClass('active');
      $('#search').blur();
    }
  });

  // Open search with 's'
  $(document).keyup(function(e) {
   if ( e.keyCode == 83 ) {
      $('#search').addClass('active');
      $('#search input').focus();
    }
  });

  // Correctly format code tabs
  function correctCode() {
    var container = $('.examples');
    var section = $('section.api section');
    var examples = container.children('.example');

    examples.hide();
    section.each(function() {
      $(this).find('.example').first().show();
    });
  }
});
