
<script type="text/javascript">
$(function () 
{
    var datatable = $("#Cart").DataTable({
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>ReportStock/getReportStock",
         "aoColumns": 
            [
              { mData: 'storeID' } ,
              { mData: 'productErpCode' } ,
              { mData: 'productName' } ,
              { mData: 'ccName' } ,
              { mData: 'StockQty' } ,
              { mData: 'SizeDescription' } 
            ]    
        });
});

</script>
