
<script type="text/javascript">
$(function () 
{
  loadChat() ;
  window.setInterval(function(){
    loadChat() ;
}, 10000);
//Load Chat

function loadChat() {
  $.ajax({
        url: "<?=base_url();?>Chat/loadChat/"+$("#roomId").text(),
        type: "GET",
        success: function (response) {
          var data = jQuery.parseJSON(response);
          $(".direct-chat-msg").remove();
            $.each(data, function(index) {

              if(data[index].from == "<?=$username;?>"){
                    $(".direct-chat-messages").append('<div class="direct-chat-msg right">'+
                        '<div class="direct-chat-infos clearfix">'+
                        ' <span class="direct-chat-name float-left"> Anda </span>'+
                        ' <span class="direct-chat-timestamp float-right">'+data[index].createdDate+'</span>'+
                        '</div>'+
                        '<div class="direct-chat-text">'+data[index].messageContent+'</div>'+
                      '</div>');
                }else{
                  $(".direct-chat-messages").append('<div class="direct-chat-msg">'+
                        '<div class="direct-chat-infos clearfix">'+
                        ' <span class="direct-chat-name float-left">'+data[index].userFullname+'</span>'+
                        ' <span class="direct-chat-timestamp float-right">'+data[index].createdDate+'</span>'+
                        '</div>'+
                        '<div class="direct-chat-text">'+data[index].messageContent+'</div>'+
                      '</div>');
                }
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}




    $("#addMessage").click(function(){
      var roomId = $("#roomId").text();
      var from   = "<?=$username;?>";
      var messageContent = $("#message").val();
      $.ajax({
        url: "<?=base_url();?>Chat/saveChat/",
        type: "POST",
        data:{
          roomId: roomId, //
          from : from,
          messageContent : messageContent
        },
        success: function (response) {
          loadChat();
          $("#message").val("");
          $(".direct-chat-messages").animate({ scrollTop: $(document).height() }, 1000);

       }

    });
  });


});

</script>
