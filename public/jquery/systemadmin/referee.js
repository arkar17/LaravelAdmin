$(document).ready(function(){


function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function(e) {
        var $img = $('<img id="blah">');
        $img.attr('src', e.target.result);
        
        $('.form-group>label').find('img').remove();
        $img.appendTo('.form-group>label');
        $img = $(document).find('#blah');
        if ( $img.width() >= $img.height() ) {
            $img.css({
              'width': '100%',
              'height': 'auto',
            });
        } else {
          $img.css({
              'width': 'auto',
              'height': '100%',
            });
        }
      }
  
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  $("#imgInp").change(function() {
    readURL(this);
  });

})