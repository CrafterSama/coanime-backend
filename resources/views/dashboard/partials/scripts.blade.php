@if(Request::segment(1) == 'dashboard')

<script src="https://www.gstatic.com/firebasejs/5.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.0/firebase-storage.js"></script>
<script defer type="text/javascript">
/* GEO */
$(document).ready( function(){
    $('.select').selectize({
        plugins: ['remove_button', 'restore_on_backspace'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
        onChange: function (value) {
            console.log(value);
        }
    });
    $('.select-genres').selectize({
        plugins: ['remove_button', 'restore_on_backspace'],
        delimiter: ',',
        persist: false
    });

    var $countries = $('#countries');
    var $cities = $('#cities');

    $.get('/dashboard/geo/countries', function(data, textStatus, xhr) {
        $.each(data, function(index, val) {
            var option = '<option value="' + val.code +'">' + val.name +'</option>';
            $countries.append(option);
        });
    },'json');

    $countries.on('change', function(){
        var code = $(this).val();
        resetCities();
        $.get('/dashboard/geo/cities/' + code, function(data, textStatus, xhr) {
            $.each(data, function(index, val) {
                var option = '<option value="' + val.id +'">' + val.name +', '+ val.district +'</option>';
                $cities.append(option);
            });
        },'json');
    });

    function resetCities(){
        $cities.empty();
        var option = '<option> -- Seleccione --</option>';
        $cities.append(option);
    }
});
$(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).ready( function() {
    $(':file').on('fileselect', function(event, numFiles, label) {

		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}

    });
    $('#title').on('keyup',function(){
      var title = $(this).val();
      if(title.length > 60) {
        $(this).css({
          'border':'2px solid red',
          'box-shadow':'0px 0px 3px red'
        })
      }else{
        $(this).css({
          'border':'2px solid #dce4ec',
          'box-shadow':'none'
        })
      }
    });
})

function mostrarImagen(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#image').attr('src', e.target.result);
  		}
  		reader.readAsDataURL(input.files[0]);
  		$('.thumbnail').show();
 	}
    saveData();
}

$(".image-client").change(function(){
	mostrarImagen(this);
});
/*$('#form').validator();*/

$('#search-title').keyup(function() {
    //Obtenemos el value del input
    var title = $(this).val();

    fetch(`/dashboard/search/titles/${title}`)
    .then((response) => {
        response.json()
    })
    .then((response) => {
        console.log(response)
    })

    //Le pasamos el valor del input al ajax
    $.get(`/dashboard/search/titles/${title}`, function(data, textStatus, xhr) {
        var item = [];
        $.each(data, function(index, val, data) {
            if(val.images !== null) {
                var image = `/images/encyclopedia/titles/thumbnails/thumb-${val.images.name}`;
            } else {
                var image = '/images/no_image.jpg';
            }
            item.push('<div id="' + val.id + '" class="suggest-element clearfix" data="' + val.id + '"><img class="suggest-img" src="' + image + '" /><div class="suggest-details"><h4 class="suggest-name">' + val.name + '</h4><div class="suggest-type">' + val.type.name + '</div></div></div>');
        });
        $('#titles-response').fadeIn(100).html(item);
        //Al hacer click en algua de las sugerencias
        $('.suggest-element').on('click', function(){
            //Obtenemos la id unica de la sugerencia pulsada
            var id = $(this).attr('id');
            var name = $(this).children('.suggest-details').children('h4').text();
            //console.log(name);
            //Editamos el valor del input con data de la sugerencia pulsada
            $('#search-title').val(name);
            $('#title-id').val($('#'+id).attr('data'));
            //Hacemos desaparecer el resto de sugerencias
            $('#titles-response').fadeOut(200);
        });
        $('#search-title').on('blur', function (e) {
            e.preventDefault();
            $('#titles-response').fadeOut(100);
        });
    },'json');
});
</script>
@if(Request::segment(3) == 'create' || Request::segment(4) == 'edit')
<script>
// Save data
function saveData() {
    console.log('saving...');
    var post = $('#form').serializeArray();
    var id = $('#form').data('id');
    console.log(post);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        //the route pointing to the post function
        url: '/dashboard/posts/' + id,
        type: 'POST',
        // send the csrf-token and the input to the controller
        data: post,
        dataType: 'JSON',
        // remind that 'data' is the response of the AjaxController
        success: function (data) {
            swal(
                'Borrador Guardado',
                'El post se guardo como borrador',
                'success'
            );
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            swal(
                'Error',
                'La Información no pudo ser guardada porque hay algunos campos vacios <br>(<span style="color: red;">' + xhr.responseJSON.content + '</span>)' ,
                'error'
            );
        }
    });
}
</script>
@endif
<script>
$(function () {
    $('#input-foundation-date').datetimepicker();
    $('#input-broad-time').datetimepicker();
    $('#posponed-date').datetimepicker();
    $('#input-broad-finish').datetimepicker({
        useCurrent: false //Important! See issue #1075
    });
    $('#input-broad-time').on("dp.change", function (e) {
        $('#input-broad-finish').data("DateTimePicker").minDate(e.date);
    });
    $('#input-broad-finish').on("dp.change", function (e) {
        $('#input-broad-time').data("DateTimePicker").maxDate(e.date);
    });
});

$(function () {
  $('#falldown').change(function () {
    if($('#falldown').val() == 'si' ) {
      $('#falldown_date').show('400');
    }
    else if ($('#falldown').val() == 'no' ) {
      $('#falldown_date').hide('400');
    }
    else {

    }
  });
});
</script>
@endif
@if(Request::segment(1) == 'register')
<script defer type="text/javascript">
  $('input[name="captcha"]').focus(function () {
      $('.input-captcha').addClass('input-captcha-focus');
  });
  $('input[name="captcha"]').blur(function () {
      $('.input-captcha').removeClass('input-captcha-focus');
  });
</script>
@endif
@if(Request::path() == 'dashboard/posts' || Request::path() == 'dashboard/titles' || Request::path() == 'dashboard/events' || Request::path() == 'dashboard/magazine' || Request::path() == 'dashboard/people' || Request::path() == 'dashboard/companies' || Request::path() == 'dashboard')
<script defer>
function proceed(id) {
	swal({
		title: '¿Estas Seguro(a)?',
		text: '¡No podras reveritr esta acción!',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Borralo'
	}).then(function() {
		$('#delete-data-'+id).submit();
	}, function(dismiss) {
  		// dismiss can be 'cancel', 'overlay', 'close', 'timer'
		if (dismiss === 'cancel') {
    		swal(
      			'Cancelado',
      			'Tu Data esta a salvo',
      			'info'
    		);
  		};
	});
};
</script>
@endif
