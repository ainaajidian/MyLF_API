
<script type="text/javascript">
$(document).ready( function () {


      var datatable = $("#myTable").DataTable({
     dom: 'Bfrtip',
      buttons: 
        [
            {
                text: 'Add New Product',
                action: function ( e, dt, node, config ) 
                  {
                    window.location.href = "<?=base_url();?>Product/add";
                   }
            }
        ],
       "pageLength": 25,
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Product/getProduct/",
         "aoColumns": 
            [
              { mData: 'productId' } ,
              { mData: 'productName' } ,
              { mData: 'categoryName' } ,
              { mData: 'productPrice' } ,
              {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full) 
                { return (full.isHot === "1") ? 'Yes' :'No' ; }
              }, 
              {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full) 
                { return (full.isNew === "1") ? 'Yes' :'No' ; }
              }, 
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                  if(full.productFlag === "1")
                  {
                    return  '<a href="<?=base_url();?>Product/detail/'+full.productId+'" class="btn btn-success btn-sm"> Detail </a> ' +
                            '<a class="btn btn-danger btn-sm deactiveConfirmation"> Deactive </a>';
                  }
                  else
                  {
                    return  '<a href="<?=base_url();?>Product/detail/'+full.productId+'" class="btn btn-success btn-sm"> Detail </a> ' +
                           '<a class="btn btn-success btn-sm activeConfirmation"> Active </a> ' +
                           '<a class="btn btn-danger btn-sm deleteForever"> Delete </a>' ;
                  }
                }
              }
            ]    
        });
} );
</script>