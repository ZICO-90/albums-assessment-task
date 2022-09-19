
const form_edit_gallery= $('#editFormGallery');
var preview = $('#imagePreview');
var form_file = $('#formFile');

$(".editGallery").click(function() {
	$(".inputTitle").attr("value" , $(this).data('name'));
    $(form_edit_gallery).attr('action',$(this).data('url')).attr('method' ,"post")
});

function previewFile(filse) {
   let image = preview.find('img')[0];
   var file  = filse.files[0];
   if(file === undefined)
   {
       preview.hide();
       image.src  = '';
   }
  
   var reader  = new FileReader();
   reader.addEventListener("load", function () {
     image.src = reader.result;
     preview.show()
   }, false);
 
   if (file) {
     reader.readAsDataURL(file);
   }
}

$("#editImage").on('hide.bs.modal', function () {
    $(form_edit_gallery).removeAttr('action').removeAttr('method')
    $(form_edit_gallery).trigger("reset");
    crear_file_modal();
    crear_img_modal();
});

$('.icon-trash').click(function(){
    crear_file_modal();
    crear_img_modal();
});


function crear_file_modal(){
    $(form_file).val(null) ;
}

function crear_img_modal(){
    let image = preview.find('img')[0];
    preview.hide()
    image.src ='';
}

$(form_edit_gallery).submit(function(event) {
    event.preventDefault();
    var target = event.target ;

    let inputText = $(target).find('input[name=name]').val();
    let inputFile = $(target).find('input[type=file]')[0];
   if(inputText.trim().length == 0 && inputFile.files.length == 0)
   {
    alert('No data !!  Please enter the data')
    return false ;
   }

   let url = target.getAttribute('action');
   let method = target.getAttribute('method');
   let _token = $(target).find('input[name=_token]').val()
   let _method = $(target).find('input[name=_method]').val()
   const formData = new FormData(); 
   formData.append('name', inputText);
   if(inputFile.files.length > 0) formData.append('file', inputFile.files[0]); 

   $.ajax({  
    url: url,  
    type: method, 
    dataType: 'json',
    data: formData,
    enctype: 'multipart/form-data',
    cache : false,
    processData: false,
    contentType: false,
    headers: {
        'X-CSRF-TOKEN': _token,
        "X-HTTP-Method-Override" :_method
    },

      success: function(data) {  
        console.log(data)    
      let find =   $('#' + `thumb-${data.success.id}`)
      let image =   $(find).find('img')[0]
      let label_name =   $(find).find('label')[0]
      image.src = data.success.url
      label_name.textContent = data.success.name
      $('#editImage').modal('hide');
      }
    });  
  

   });