
const form_move_album = $('#formMovetNameAlbum');
let filter_selected = $('#selected');

$(".moveLink").click(function() {	  
     $(".album-input").attr("value" , $(this).data('name-modal'));
     $(form_move_album).attr('action',$(this).data('url')).attr('method' ,"post")
     let isFilter =  $(this).data('filter');
     $(filter_selected).find('option').each(function()
     {
        if(this.value == isFilter) 
           $(this).prop('disabled', true);  
        else 
          $(this).prop('disabled', false);  
     });
});



$(form_move_album).submit(function(event) {
    let default_value = filter_selected.find(":selected").val();
    if(default_value == 0)
    {
        event.preventDefault();
        alert('Please select move album')
    }
});
       
$("#moveAlbumModal").on('hide.bs.modal', function () {
    $(form_move_album).removeAttr('action').removeAttr('method')
});




let _method_input = document.createElement('input');
_method_input.setAttribute('type' , 'hidden');
_method_input.setAttribute('name' , '_method');
_method_input.setAttribute('value' , 'delete');

let _token_input = document.createElement('input');
let _token_value = $('meta[name="csrf-token"]').attr('content')

_token_input.setAttribute('type' , 'hidden');
_token_input.setAttribute('name' , '_token');
_token_input.setAttribute('value' , _token_value);

const delete_album_form = $('#delete-album-form');
$(".Delete").click(function() {	  
   
    $(delete_album_form).attr('action',$(this).data('url')).attr('method' ,"POST")
    delete_album_form.prepend(_token_input)
    delete_album_form.prepend(_method_input)
});


$("#delete-album-modal").on('hide.bs.modal', function () {
    $(delete_album_form).removeAttr('action').removeAttr('method')
    $(_method_input).remove();
    $(_token_input).remove();
});
