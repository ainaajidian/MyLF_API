
<script type="text/javascript">
$(function () 
{
    var datatable = $("#Refund").DataTable({
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Refund/getRefund",
         "aoColumns": 
            [
              { mData: 'refundId' } ,
              { mData: 'cartId' } ,
              { mData: 'tglPengajuan' } ,
              { mData: 'nominalRefund' } ,
              { mData: 'approveBy' } ,
              { mData: 'approveDate' } ,
              { mData: 'tglRefund' } ,
              { mData: 'bankName' } ,
              { mData: 'rekeningNo' }
            ]    
        });
});

</script>
