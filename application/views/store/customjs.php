
<script type="text/javascript">
$(function () { 

    var datatable = $("#Store").DataTable({
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
         "sAjaxSource": "<?=base_url();?>Store/getStore",
         "aoColumns": 
            [
              { mData: 'storeId' } ,
              { mData: 'storeName' } ,
              { mData: 'storeMall' } ,
              { mData: 'storeAddress' } ,
              { mData: 'storeDetail' } ,
              { mData: 'storeLongitude' } ,
              { mData: 'storeLatitude' } , 
              { mData: 'storeProvinceId' } , 
              { mData: 'storeCityId' } ,  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.storeFlag === "1")
                  {
                    return  '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                            '<a class="btn btn-danger btn-sm deactiveConfirmation"> Deactive </a>';
                  }
                  else
                  {
                    return '<a  class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
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
      $("#storeForm")[0].reset();
      $("#exampleModal").modal("show");
    }

    // Edit //
    $(document).on("click",".showeditModal",function()
    {
        $("#editstoreForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_storeName      = data.storeName;
        var edit_storeMall      = data.storeMall;
        var edit_storeAddress   = data.storeAddress;
        var edit_storeDetail    = data.storeDetail;
        var edit_storeLongitude = data.storeLongitude;
        var edit_storeLatitude  = data.storeLatitude;
        var edit_storeCityId    = data.storeCityId;
        var edit_storeProvinceId= data.storeProvinceId;
        var edit_storeId        = data.storeId;

        $("#editstoreName").val(edit_storeName);
        $("#editstoreMall").val(edit_storeMall);
        $("#editstoreAddress").val(edit_storeAddress);
        $("#editstoreDetail").val(edit_storeDetail);
        $("#editstoreLongitude").val(edit_storeLongitude);
        $("#editstoreLatitude").val(edit_storeLatitude);
        $("#editCity").val(edit_storeCityId);
        $("#editProvince").val(edit_storeProvinceId);
        $("#editstoreId").val(edit_storeId);

    });

    // Deactive //
    $(document).on("click",".deactiveConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.storeName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Store/deactivate/'+data.storeId,
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
        $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.storeName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Store/restore/'+data.storeId,
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
        $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.storeName + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Store/deleteForever/'+data.storeId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });


});
</script>