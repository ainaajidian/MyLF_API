
<script type="text/javascript">
$(function () 
{
  var publicSizeID;

  $("#Panjang").hide();
  $("#Lebar").hide();
  $("#Tinggi").hide();
  $("#Berat").hide();
  $("#Ukuran").hide();


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
              { mData: 'TipeProduct' } ,
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
          $("#Panjang").show();
          $("#Lebar").show();
          $("#Tinggi").show();
          $("#Berat").show();
          $("#Ukuran").hide();
        }
        else if (TipeProduct == 'C_00007')
        {
          $("#Panjang").hide();
          $("#Lebar").hide();
          $("#Tinggi").hide();
          $("#Berat").show();
          $("#Ukuran").show();
        }
        else
        {
          $("#Panjang").hide();
          $("#Lebar").hide();
          $("#Tinggi").hide();
          $("#Berat").hide();
          $("#Ukuran").hide();
        }
    });

    function openAddmodal()
    { $("#exampleModal").modal("show"); }


    $('#SizeTable tbody').on('click', '.showeditModal', function() 
    {
        $("#editsizeForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_SizeID              = data.SizeID;
        var edit_tipe_product     = data.TipeProduct;
        var panjang   = data.panjang;
        var lebar  = data.lebar;
        var tinggi = data.tinggi;
        var berat = data.berat;
        var ukuran = data.ukuran; 

        publicSizeID = data.SizeID;
        if(edit_tipe_product === "C_00001")
        {
            $("#editSizeID").val(edit_SizeID);
            $("#editTipeProduct").val(edit_tipe_product);
            $("#DivPanjang").show();
            $("#DivLebar").show();          
            $("#DivTinggi").show();
            $("#editPanjang").val(panjang);
            $("#editLebar").val(lebar);          
            $("#editTinggi").val(tinggi);
            $("#DivUkuran").hide();
            $("#editBerat").val(berat);
        }
        else if(edit_tipe_product === "C_00007")
        {
            $("#editSizeID").val(edit_SizeID);
            $("#editTipeProduct").val(edit_tipe_product);
            $("#DivPanjang").hide();
            $("#DivLebar").hide();          
            $("#DivTinggi").hide();
            $("#DivUkuran").show();
            $("#editUkuran").val(ukuran);
            $("#editBerat").val(berat);
        }
    });


    $("#editsizeForm").submit(function(e){
            $(this).attr('action', '<?=base_url();?>size/updateSize/'+publicSizeID);
    })

    

});


</script>