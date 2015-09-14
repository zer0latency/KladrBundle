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
    return 'дом ' + widget.house.val() 
           + (widget.corps.val() ? ",корп " + widget.corps.val() : ",")
           + (widget.flat.val() ? ",кв " + widget.flat.val() : ",") +
           ',' + widget.values.street;
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
      var setValues = {
        region: false,
        city:   false,
        street: false
      };
      widget.values = {};

      $('.zlkladr').parents('form').on("submit", function (e) {
        $.each(setValues, function (key, value) {
          if ( !value ) {
            widget[key].parent()
                    .attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', 'Значение поля должно быть выбрано из списка.')
                    .tooltip();
            widget[key].focus();
            e.preventDefault();
            return false;
          }
        });
      });

      $(obj).find('input').each(function (j, input) {
        var $input = $(input),
            runningCallback,
            inputType = $input.attr('id').split('_').pop();

        widget[inputType] = $input;

        if ( $input.attr('data-source') ) {
          $input.after('<ul class="dropdown-menu" aria-labelledby="'+$input.attr('id')+'"></ul>');

          $input.parent().find('ul').click('a', function (e) {
            e.preventDefault();
            var $t = $(e.target);
            if ( !$t.attr('data-code') ) {
              return;
            }
            widget.values[inputType] = $t.attr('data-code');
            setValues[inputType] = true;
            $input.val($t.html());
            $input.parent().next().find('input').focus();
            $("button[type=submit]").removeAttr('disabled');
          });
        }

        $input.change(function () {
            widget.address.val( buildAddrString(widget) );
        });
        
        $input.on("focusin", function () {
          setTimeout(function () {
            if ( !$input.parent().hasClass('open') ) {
              $input.parent().addClass('open');
            }
          }, 100);
        }); 
        
        $input.on("focusout", function () {
          setTimeout(function () {
            if ( $input.parent().hasClass('open') ) {
              $input.parent().removeClass('open');
            }
          }, 500);
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
        
        if ( inputType === 'address' && $input.val() ) {
          $.ajax({
            type: "POST",
            url: '/kladr/path/',
            data: {address: $input.val()},
            success: function (data) {
              $.each(data, function (key, value) {
                widget[key].val(value);
                if ( setValues[key] !== undefined ) { setValues[key] = true; }
              });
            },
            dataType: 'json'
          });
        }
      });
    });
  };
  
  $(document).one("ready", function () {
    bindEvents();
  }); 
})(jQuery, window);
