
<script type="text/javascript">
$(function () 
{
    var datatable = $("#Transaction").DataTable({
     dom: 'Bfrtip',
      buttons: 
        [
            {
                text: 'Add Transaction',
                action: function ( e, dt, node, config ) 
                  { openAddmodal(); }
            }
        ],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Transaction/getTransaction",
         "aoColumns": 
            [
              { mData: 'UserId' } ,
              { mData: 'TransactionId' } ,
              { mData: 'OutletLocation' } ,
              { mData: 'TransactionDate' } ,
              { mData: 'Total' } ,
              { mData: 'RewardPoint' } ,
              { mData: 'TotalPoint' } 
            ]    
        });


    // Add //
    function openAddmodal()
    {
      $("#categoryForm")[0].reset();
      $("#exampleModal").modal("show");
    }    

});


</script>