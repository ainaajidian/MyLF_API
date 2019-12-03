
<script type="text/javascript">
$(function () 
{
  var publicVoucherId;

  $("#besarNominal").hide();
  $("#besarPersen").hide();

    var datatable = $("#VoucherTable").DataTable({
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
         "sAjaxSource": "<?=base_url();?>Voucher/getVoucher",
         "aoColumns": 
            [
              { mData: 'voucherId' } ,
              { mData: 'voucherCode' } ,
              { mData: 'voucherName' } ,
              { mData: 'discountType' } ,
              { mData: 'discountVal' } ,
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.voucherFlag === "1")
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
        //$("#deleteConfirmationmessage").html();
        // $("#deleteConfirmationmessage").html("You are about to deactivitaing  <b>" + data.voucherId + "</b>, are you sure?");
        // $("#confirm").modal("show");

          
                $.ajax({
                url: '<?=base_url();?>Voucher/deactivate/'+data.voucherId,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          
    });

    // Active //
    $(document).on("click",".activeConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        // $("#deleteConfirmationmessage").html();
        // $("#deleteConfirmationmessage").html("You are about to activating  <b>" + data.voucherId + "</b>, are you sure?");
        // $("#confirm").modal("show");

          //$(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Voucher/restore/'+data.voucherId,
                type: 'DELETE',
                success: function(result) 
                { location.reload(); }
              });
          //});

    });

    //Delete
    $(document).on("click",".deleteForever",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        // $("#deleteConfirmationmessage").html();
        // $("#deleteConfirmationmessage").html("You are about to deleting  <b>" + data.voucherId + "</b> , are you sure?");
        // $("#confirm").modal("show");

          //$(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Voucher/deleteForever/'+data.voucherId,
                type: 'DELETE',
                success: function(result) 
                { location.reload(); }
              });
          //});

    });

    $("#exampleModal").on("change","#discountType",function()
    {
        var discountType = $(this).val();
        if(discountType == 'Nominal')
        {
          $("#besarNominal").show();
          $("#besarPersen").hide();
        }
        else if (discountType == 'Percent')
        {
          $("#besarNominal").hide();
          $("#besarPersen").show();
        }
    });

    function openAddmodal()
    { $("#exampleModal").modal("show"); }


    $('#VoucherTable tbody').on('click', '.showeditModal', function() 
    {
        $("#editvoucherForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var edit_voucherId        = data.voucherId;
        var edit_discountType     = data.discountType;
        var discountVal           = data.discountVal;
        var discountVal           = data.discountVal;

        publicVoucherId = data.voucherId;

        if(edit_discountType === "Nominal")
        {
            $("#editVoucherId").val(edit_voucherId);
            $("#editdiscountType").val(edit_discountType);
            $("#editbesarPersen").hide();
            $("#editbesarNominal").show();
            $("#editbesarNominal").val(discountVal)
        }
        else if(edit_discountType === "Percent")
        {
            $("#editVoucherId").val(edit_voucherId);
            $("#editdiscountType").val(edit_discountType);
            $("#editbesarPersen").show();
            $("#editbesarNominal").hide();     
            $("#editbesarPersen").val(discountVal);
        }
    });

    $("#editvoucherForm").submit(function(e)
      { $(this).attr('action', '<?=base_url();?>Voucher/updateVoucher/'+publicVoucherId); })

});


</script>