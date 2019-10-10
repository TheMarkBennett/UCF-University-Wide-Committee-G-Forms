jQuery( document ).ready( function( $ ) {
    // $() will work as an alias for jQuery() inside of this function

$(".CE-committee-to-edit").change(function(){
    var post_id = $( this ).find(":selected").val();

    if(!post_id){

         $(".CE-edit-name input[type='text']:eq(1), .CE-edit-name input[type='text']:eq(0), .CE-edit-cm-name input[type='text'], .CE-edit-charge textarea, .CE-edit-url input[type='url'], .CE-edit-email input[type='email'], .CE-edit-unit select ").val('');
         return;
    }

    $.ajax({
        url : my_ajax_object.ajax_url,
        method: "POST",
        dataType: "json",
          data:{
            action: 'load_post_content',
            postID: post_id,
          },
          beforeSend: function() {
                 $(".CE-edit-name input[type='text']:eq(1), .CE-edit-name input[type='text']:eq(0), .CE-edit-cm-name input[type='text'], .CE-edit-charge textarea, .CE-edit-url input[type='url'], .CE-edit-email input[type='email'], .CE-edit-unit select ").val('');

                },
               success: function(data){

                 $(".CE-edit-name input[type='text']").first().val(data.first_name[0]);

                 $(".CE-edit-name input[type='text']:eq(1)").val(data.last_name[0]);

                 $(".CE-edit-cm-name input[type='text']").val(data.title[0]);

                 $(".CE-edit-charge textarea").val(data.charge[0]);

                 $(".CE-edit-url input[type='url']").val(data.url[0]);

                 $(".CE-edit-email input[type='email']").val(data.email[0]);

                 $(".CE-edit-unit select").val(data.tax[0][0].term_id);



               },
               error: function () {


        }

    });


});


} ); //closing jquery
