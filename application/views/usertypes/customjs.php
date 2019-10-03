
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
         "sAjaxSource": "<?=base_url();?>Usertype/getType",
         "aoColumns": [
              { mData: 'type_id' } ,
              { mData: 'type_description' } ,
              {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full) {
                  if(full.flag === "1"){
                   return '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                          '<a class="btn btn-success btn-sm manageModule"> Manage Module </a> '+
                          '<a class="btn btn-danger btn-sm deactive"> Deactive </a> ' ;
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

   var datatable2 = $("#example2").DataTable({
     dom: 'Bfrtip',
      buttons: [
            {
                text: 'Add new',
                action: function ( e, dt, node, config ) {
                    openAddaccess();
                }
            }
        ],
      });

function openAddmodal(){
  $("#exampleModal").modal("show");
}


   $('#example1 tbody').on('click', '.deactive', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactive <b>" + data.type_description + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Usertype/set_deactive/'+data.type_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });

   $('#example1 tbody').on('click', '.activeConfirmation', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to actived  <b>" + data.type_description + "</b> , are you sure?");
        $("#confirm").modal("show");
          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Usertype/set_active/'+data.type_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });

   $('#example1 tbody').on('click', '.deleteForever', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to delete  <b>" + data.type_description + "</b> , are you sure?");
        $("#confirm").modal("show");
          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Usertype/deleteForever/'+data.type_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });   

   $('#example1 tbody').on('click', '.manageModule', function() {
            var data  = datatable.row($(this).parents('tr')).data();
            window.location.href='<?=base_url();?>Usertype/manageModule/'+data.type_id ;
   });


   $('#example1 tbody').on('click', '.showeditModal', function() {
          $("#editForm")[0].reset();
          var data  = datatable.row($(this).parents('tr')).data();
          $("#editModal").modal("show");
          $("#usertype_id").val(data.type_id);
          $("#usertype_desc_edit").val(data.type_description);
   });


    function openAddaccess(){
        $("#addModal").modal("show");
    }


});
      </script>

      