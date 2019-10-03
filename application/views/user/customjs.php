
<script type="text/javascript">
$(function () { 

    var datatable = $("#example1").DataTable({
     dom: 'Bfrtip',
      buttons: [
            {
                text: 'Add new',
                action: function ( e, dt, node, config ) {
                    openAddmodal();
                }
            }
        ],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>user/getUser",
         "aoColumns": [
              { mData: 'userid' } ,
              { mData: 'username' } ,
              { mData: 'usertype' } ,

              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full) {
                if(full.user_flag === "1"){
                return 'Active';
                }else{
                  return 'Not active'
                }
              }
            },

              { mData: 'email' } ,
               {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full) {
                  if(full.user_flag === "1"){
                    return '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                           '<a class="btn btn-danger btn-sm deleteConfirmation"> Deactive </a>';
                    }else{
                      return '<a  class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                             '<a class="btn btn-success btn-sm activeConfirmation"> Avtive </a> ' +
                             '<a class="btn btn-danger btn-sm deleteForever"> Delete </a>'
                           ;
                    }
                  
                }
              }

            ]    
        });

    function openAddmodal(){
      $("#userForm")[0].reset();
    	$("#exampleModal").modal("show");
    }

    $(document).on("click",".showeditModal",function(){
        $("#edituserForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_username    = data.username;
        var edit_useremail   = data.email;
        var edit_usertype    = data.usertype;
        var edit_userid      = data.userid;

        $("#editUsername").val(edit_username);
        $("#editUseremail").val(edit_useremail);
        $("#editUsertype").val(edit_usertype);
        $("#editUserid").val(edit_userid);

    });


    $(document).on("click",".deleteConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.username + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>user/deactivate/'+data.userid,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });

    $(document).on("click",".activeConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.username + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>user/restore/'+data.userid,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });


    $(document).on("click",".deleteForever",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.username + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>user/delete/'+data.userid,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });


});
</script>