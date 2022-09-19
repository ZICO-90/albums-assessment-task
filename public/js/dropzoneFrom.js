Dropzone.prototype.defaultOptions.dictRemoveFile = "حذف الملف";
let album_alert = $('#album')
let files_alert  = $('#files')
let nPhotos_alert = $('#name_photos')
let alert_message = $('#alert')

Dropzone.options.dropzoneFrom = {
    maxFilesize: 500,
    addRemoveLinks:true,
    autoProcessQueue: false,
    uploadMultiple:true,
    parallelUploads: 10,
    maxFiles: 10,
    acceptedFiles:".png,.jpg,.jpeg",
    init: function(){
      var  myDropzone = this;
     var submitButton = document.querySelector('#submit-all');
     submitButton.addEventListener("click", function(e){
        $('.dz-progress').show()
        myDropzone.processQueue();
     });
     this.on("sending", function(data, xhr, formData) {
     
        formData.append("album", $('input[name=album]').val());
        $('input[name="name_photos[]"]').map(function(index , input)
        {
            formData.append(`name_photos[${index}]`, input.value);
        });
       
        
    });

    this.on("error", function(file, errormessage, xhr){
      
        $.each( errormessage.errors, function( key, value ) {
        
            $('#'+key.replace(/.\d+/ , '') ).text(value);
          });
        
    });

    this.on("success", function(file, responseText) {

        let response = responseText ;
        if(response.success)
        {
            clearAll();
            $(alert_message).append(`
            <div class="alert alert-primary" role="alert">
                  تم اضافة البوم (${response.data.name}) بنجاح
             </div>
            `)

        }else{
            $(alert_message).append(`
            <div class="alert alert-danger" role="alert">
                حاول في وقت لاحق
            </div>
            `) 
        }
        return false;
    });

     this.on("addedfiles", function(files) {
        var  addfile = myDropzone.files ;
        $('#preview').append(`
        <div class="form-group" id="${files[0].upload.uuid}">
        <label>اسم الملف ${files[0].upload.filename}</label>
        <input type="text" class="form-control" name="name_photos[]"  form="dropzoneFrom">
       </div>
        `)

        let if_count = 0 ;
        for (let index = 0; index < addfile.length ; index++) {

           if(addfile[index].name === files[0].name)  if_count++ ;
           
           if(if_count > 1) this.removeFile(files[0]) ;
           
        }
      });

      this.on("removedfile", function(files) {
        $('#' + files.upload.uuid).remove();
      });

     this.on("complete", function(){
        
      if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
      {
          this.removeAllFiles();
      }

     });
  
    },

   };



   function clearAll()
   {
    $(album_alert).text('')
    $(files_alert).text('')
    $(nPhotos_alert).text('')
    $('input[name=album]').val("")
   }



