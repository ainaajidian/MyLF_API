
<script type="text/javascript">
$(function () { 

    var datatable = $("#CombinationColor").DataTable({
     dom: 'Bfrtip',
      buttons: 
        [
            {
                text: 'Add New',
                action: function ( e, dt, node, config ) 
                  { openAddmodal(); }
            }
        ],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>CombinationColor/getColor",
         "aoColumns": 
            [
              { mData: 'ccId' } ,
              { mData: 'ccName' } ,
              { mData: 'ccPriName' } ,
              { mData: 'ccPriHex' } ,
              { mData: 'ccSecName' } ,
              { mData: 'ccSecHex' } ,  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.ccFlag === "1")
                  {
                    return  '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                            '<a class="btn btn-danger btn-sm deactiveConfirmation"> Deactive </a>';
                  }
                  else
                  {
                    return '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                           '<a class="btn btn-success btn-sm activeConfirmation"> Active </a> ' +
                           '<a class="btn btn-danger btn-sm deleteForever"> Delete </a>' ;
                  }
                }
              }
            ]    
        });

    //Add Color
    function openAddmodal()
    {
      $("#ccForm")[0].reset();
      $("#exampleModal").modal("show");
    }

    // Edit //
    $(document).on("click",".showeditModal",function()
    {
        $("#editccForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_ccName    = data.ccName;
        var edit_ccPriName = data.ccPriName;
        var edit_ccPriHex  = data.ccPriHex;
        var edit_ccSecName = data.ccSecName;
        var edit_ccSecHex  = data.ccSecHex;
        var edit_ccId      = data.ccId;

        $("#editccName").val(edit_ccName);
        $("#editccPriName").val(edit_ccPriName);
        $("#editccPriHex").val(edit_ccPriHex);
        $("#editccSecName").val(edit_ccSecName);
        $("#editccSecHex").val(edit_ccSecHex);
        $("#editccId").val(edit_ccId);

    });

    // Deactive //
    $(document).on("click",".deactiveConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.ccName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>CombinationColor/deactivate/'+data.ccId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });

    // Active //
    $(document).on("click",".activeConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.ccName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>CombinationColor/restore/'+data.ccId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });

    //Delete
    $(document).on("click",".deleteForever",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.ccName + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>CombinationColor/deleteForever/'+data.ccId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });


});
</script>