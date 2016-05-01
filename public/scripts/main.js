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

  $('form').submit(function(e) {
    e.preventDefault();
    return false;
  });

  $('input[name="search"]').keydown(function(e) {
    var results;

    if (e.which == 13) {
      $.get({
        url: '/search/' + $(this).val(),
        success: function(data) {
          displaySearchResults(data);
        }
      });
    }
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

  function displaySearchResults(results) {
    if ( ! results ) { return false; } // Return early is empty
    var resultContainer = $('ul.results');
    resultContainer.empty();

    results.forEach(function(result) {
      var output = '';

      output += '<li class="'+result.result_type+'"><a href="'+result.url+'">';
      output += '<h3>'+result.result_term+'</h3>';
      output += '<small>'+result.url+'</small>';
      // output += '<p>'+result.description+"</p>"; // Needs to be implemented first
      output += '</a></li>';

      resultContainer.append(output);
    });
  }
});
