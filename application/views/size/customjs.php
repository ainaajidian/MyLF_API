
<script type="text/javascript">
$(function () 
{
  var publicSizeID;

  $("#Lebar").hide();
  $("#Tinggi").hide();
  $("#Size").hide();
  $("#Ukuran").hide();
  $("#Berat").hide();

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
              { mData: 'categoryName' } ,
              { mData: 'SizeDescription' } ,
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
          $("#Lebar").hide();
          $("#Tinggi").hide();
          $("#Ukuran").show();
          $("#Size").hide();
          $("#Berat").show();
        }
        else if (TipeProduct == 'C_00007')
        {
          $("#Lebar").hide();
          $("#Tinggi").hide();
          $("#Ukuran").hide();
          $("#Size").show();
          $("#Berat").show();
        }
        else
        {
          $("#Lebar").hide();
          $("#Tinggi").hide();
          $("#Ukuran").hide();
          $("#Size").hide();
          $("#Berat").hide();
        }
    });

    function openAddmodal()
    { $("#exampleModal").modal("show"); }


    $('#SizeTable tbody').on('click', '.showeditModal', function() 
    {
        $("#editsizeForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_SizeID           = data.SizeID;
        var edit_tipe_product     = data.TipeProduct;
        var lebar                 = data.lebar;
        var tinggi                = data.tinggi;
        var ukuran                = data.ukuran;
        var size                  = data.size;
        var berat                 = data.berat; 

        publicSizeID = data.SizeID;
        if(edit_tipe_product === "C_00001")
        {
            $("#editSizeID").val(edit_SizeID);
            $("#editTipeProduct").val(edit_tipe_product);
            $("#DivLebar").hide();          
            $("#DivTinggi").hide();
            $("#DivUkuran").show();
            $("#DivSize").hide();
            $("#DivBerat").show();
            $("#editUkuran").val(ukuran);
            $("#editBerat").val(berat);
        }
        else if(edit_tipe_product === "C_00007")
        {
            $("#editSizeID").val(edit_SizeID);
            $("#editTipeProduct").val(edit_tipe_product);
            $("#DivLebar").hide();          
            $("#DivTinggi").hide();
            $("#DivUkuran").hide();
            $("#DivSize").show();
            $("#DivBerat").show();
            $("#editSize").val(size);
            $("#editBerat").val(berat);
        }
    });

    $("#editsizeForm").submit(function(e)
      { $(this).attr('action', '<?=base_url();?>Size/updateSize/'+publicSizeID); })

});


</script>