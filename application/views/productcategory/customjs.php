
<script type="text/javascript">
$(function () {

var publiccategoryImage;
var publicCategoryId;

    var datatable = $("#ProductCategory").DataTable({
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
         "sAjaxSource": "<?=base_url();?>ProductCategory/getCategories",
         "aoColumns": 
            [
              { mData: 'categoryId' } ,
              { mData: 'categoryName' } ,
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full) 
                { return "<img width='90px' height='90px' src='<?php echo base_url().'assets/app_assets/'?>"+full.categoryImage+ "'>" }
              }, 
              { mData: 'categoryDescription' } ,  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.categoryFlag === "1")
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


    // Add //
    function openAddmodal()
    {
      $("#categoryForm")[0].reset();
      $("#exampleModal").modal("show");
    }

    // Edit //
    $(document).on("click",".showeditModal",function()
    {
      $("#editcategoryForm")[0].reset();
      var data  = datatable.row($(this).parents('tr')).data();
      var modal = $("#editModal").modal("show");

      var edit_categoryName         = data.categoryName;
      var edit_categoryDescription  = data.categoryDescription;
      var edit_parentCategoryId     = data.parentCategoryId;
      var edit_categoryId           = data.categoryId;

      $("#editcategoryName").val(edit_categoryName);
      $("#editcategoryDescription").val(edit_categoryDescription);
      $("#editparentCategoryId").val(edit_parentCategoryId);
      $("#editcategoryId").val(edit_categoryId);
    });

    // Deactive //
    $(document).on("click",".deactiveConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.categoryName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>ProductCategory/deactivate/'+data.categoryId,
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
        $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.categoryName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>ProductCategory/restore/'+data.categoryId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });

    // Delete Forever//
    $(document).on("click",".deleteForever",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.categoryName + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>ProductCategory/deleteForever/'+data.categoryId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });

    

});


</script>