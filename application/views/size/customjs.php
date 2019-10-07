
<script type="text/javascript">
$(function () 
{
  var publicPanjang;
  var publicLebar;
  var publicTinggi;
  var publicBerat;
  var publicUkuran;

  $("#panjang").hide();
  $("#lebar").hide();
  $("#tinggi").hide();
  $("#berat").hide();
  $("#ukuran").hide();


    var datatable = $("#SizeTable").DataTable({
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
         "sAjaxSource": "<?=base_url();?>Size/getSize",
         "aoColumns": 
            [
              { mData: 'SizeID' } ,
              { mData: 'SizeDescription' } ,
              { mData: 'TipeProduct' } ,  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.SizeFlag === "1")
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

    // Deactive //
    $(document).on("click",".deactiveConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.SizeID + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Size/deactivate/'+data.SizeID,
                type: 'DELETE',
                success: function(result) 
                { location.reload(); }
              });
          });

    });

    // Active //
    $(document).on("click",".activeConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.SizeID + "</b>, are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Size/restore/'+data.SizeID,
                type: 'DELETE',
                success: function(result) 
                { location.reload(); }
              });
          });

    });

    //Delete
    $(document).on("click",".deleteForever",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.SizeID + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Size/deleteForever/'+data.SizeID,
                type: 'DELETE',
                success: function(result) 
                { location.reload(); }
              });
          });

    });



    $("#exampleModal").on("change","#TipeProduct",function()
    {
        var TipeProduct = $(this).val();
        if(TipeProduct == 'C_00001')
        {
          $("#panjang").show();
          $("#lebar").show();
          $("#tinggi").show();
          $("#berat").show();
          $("#ukuran").hide();
        }
        else if (TipeProduct == 'C_00007')
        {
          $("#panjang").hide();
          $("#lebar").hide();
          $("#tinggi").hide();
          $("#berat").show();
          $("#ukuran").show();
        }
        else
        {
          $("#module_icon").hide();
          $("#module_icon_1").hide();
          $("#module_icon_2").hide();
           ("#module_parent").hide();
        }
    });

    function openAddmodal()
    { $("#exampleModal").modal("show"); }




    $('#SizeTable tbody').on('click', '.showeditModal', function() 
    {
        $("#editsizeForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");
        var edit_tipe_product   = data.module_type;
        var edit_panjang        = data.module_name;
        var edit_lebar          = data.module_parent;
        var edit_tinggi         = data.module_path;
        var edit_berat          = data.module_icon;
        var edit_ukuran         = data.module_icon;
        publicSizeID          = data.SizeID;
        publicModuleIcon        = edit_module_icon
        $("#edit_module_name").val(edit_module_name);
        $("#edit_module_type").val(edit_module_type);
        $("#edit_module_parent").val(edit_module_parent);
        $("#edit_module_icon_2").val(edit_module_icon);
        $("#edit_module_path").val(edit_module_path);
        
        if(edit_module_type === "1")
        {
            $("#edit_module_icon_2").hide();
            $("#edit_module_icon_1").show();          
            $("#edit_module_parent").hide();
            $("#edit_module_icon_2").val("");
            publicModuleIcon = ""
        }
        else if(edit_module_type === "2")
        {
            $("#edit_module_parent").show();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").show();
            $("#edit_module_icon_2").val(publicModuleIcon);
        }
    });

    $("#editModal").on("change","#edit_module_type",function(){
        var module_type = $(this).val();
        if(module_type == 1){
            $("#edit_module_icon_2").hide();
            $("#edit_module_icon_1").show();          
            $("#edit_module_parent").hide();
            $("#edit_module_icon_2").val("");
        }else if (module_type == 2){
            $("#edit_module_parent").show();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").show();
            $("#edit_module_icon_2").val(publicModuleIcon);
        }else{
            $("#edit_module_parent").hide();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").hide();
        }
    });

    $("#editmoduleForm").submit(function(e){
            $(this).attr('action', '<?=base_url();?>module/updatemodule/'+publicModuleId);
    })

    

});


</script>