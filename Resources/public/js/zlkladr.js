(function ($, window) {
  
  window.zlkladr = this;
  
  /**
   * Create a popup with suggestions
   * @returns {object}
   */
  var renderSuggestions  = function ($input, data) {
    var $ddown = $input.parent().find('ul.dropdown-menu');
    $ddown.find('li').remove();
    
    $.each(data, function (code, name) {
      $ddown.append('<li><a href="#" data-code="'+code+'">'+name+'</a></li>');
    });
  };
  
  var buildAddrString = function (widget) {
    return widget.region.val() + 
           ',' + widget.city.val() +
           ',' + widget.street.val() +
           ',дом ' + widget.house.val() + 
           (widget.corps.val() ? ",корп " + widget.corps.val() : "") +
           (widget.flat.val() ? ",кв " + widget.flat.val() : "") +
           '^^'+widget.values.street;
  };
  
  /**
   * Fetch suggestions from server
   * @returns {object}
   */
  var fetchSuggestions = function (input, widget) {
    var dataSource = input.attr('data-source');
    
    if (!dataSource) {
      return;
    }
    
    $.ajax({
      type: "POST",
      url: dataSource,
      data: widget.values,
      timeout: 3000,
      success: function (data) { renderSuggestions(input, data); },
      dataType: 'json'
    });
  };
  
  var bindEvents = function () {
    $('.zlkladr').each(function (i, obj) {
      var widget = {};
      widget.values = {};

      $(obj).find('input').each(function (j, input) {
        var $input = $(input),
            runningCallback,
            inputType = $input.attr('id').split('_').pop();

        widget[inputType] = $input;

        if ( $input.attr('data-source') ) {
          $input.attr('data-toggle', 'dropdown')
            .after('<ul class="dropdown-menu" aria-labelledby="'+$input.attr('id')+'"></ul>');

          $input.parent().find('ul').click('a', function (e) {
            e.preventDefault();
            var $t = $(e.target);
            if ( !$t.attr('data-code') ) {
              return;
            }
            widget.values[inputType] = $t.attr('data-code');
            $input.val($t.html());
          });
        }

        $input.change(function () {
            widget.address.val( buildAddrString(widget) );
        });

        $input.keyup(function () {
          clearTimeout(runningCallback);
          runningCallback = setTimeout(function () {
            if (widget.values[inputType] !== $input.val()) {
              widget.values[inputType] = $input.val();
              fetchSuggestions($input, widget);
            }
          }, 500);
        });
      });
    });
  };
  
  $(document).one("ready", function () {
    bindEvents();
  }); 
})(jQuery, window);