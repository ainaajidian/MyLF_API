
<script type="text/javascript">
$(function () 
{
    var datatable = $("#Cart").DataTable({
     dom: 'Bfrtip',
      buttons: 
        [
            {
                text: 'Add Cart',
                action: function ( e, dt, node, config ) 
                  { openAddmodal(); }
            }
        ],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Cart/getCart",
         "aoColumns": 
            [
              { mData: 'cartId' } ,
              { mData: 'userId' } ,
              { mData: 'productName' } ,
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full) 
                { return "<img width='90px' height='90px' src='<?php echo base_url().'assets/app_assets/product_image/'?>"+full.image1+ "'>" }
              }, 
              { mData: 'ccName' } ,
              { mData: 'sizeId' } ,
              { mData: 'storeId' } ,
              { mData: 'responseDescription' },
              {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full)
                { return  ' <a href="<?=base_url();?>Cart/detail/'+full.cartId+'" class="btn btn-success btn-sm"> Detail </a> ' }
              }
            ]    
        });

  var cartId = $("#cartId").text();
    var datatable2 = $("#Delivery").DataTable({
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Cart/getdeliveryStatus/"+cartId,
         "aoColumns": 
            [
              { mData: 'manifest_code' } ,
              { mData: 'manifest_description' } ,
              { mData: 'manifest_date' } ,
              { mData: 'manifest_time' } ,
              { mData: 'city_name' }
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
