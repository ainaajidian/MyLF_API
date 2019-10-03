
<script type="text/javascript">
$(document).ready( function () {

      var datatable = $("#members").DataTable({
       "pageLength": 10,
       "order": [[ 4, "desc" ]],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Members/datamember/",
         "aoColumns": 
            [
              { mData: 'userId' } ,
              { mData: 'userFullname' } ,
              { mData: 'userEmail' } ,
              { mData: 'userMobilephone' } ,
              { mData: 'userRegisterDate' } ,
              {
                "mData": null,
                "bSortable": false,
                "mRender": function(data, type, full) 
                { return (full.userActive === "1") ? 'Active' :'Non-Active' ; }
              },  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full)
                {
                
                    return  '<a href="<?=base_url();?>Members/detail/'+full.userId+'" class="btn btn-success btn-sm"> Detail </a> ';
                  
                }
              }
            ]    
        });

<?php
$last = $this->uri->total_segments();
$record_num = $this->uri->segment($last);
?>
      var datatable = $("#transaksi").DataTable({
       "pageLength": 25,
       "order": [[ 4, "desc" ]],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Members/datatransaksi/<?=$record_num;?>",
         "aoColumns": 
            [
              { mData: 'OutletLocation' } ,
              { mData: 'TransactionDate' } ,
              { mData: 'PointUsage' } ,
               { mData: 'RewardPoint' } ,
              { mData: 'TotalPayment' } ,
              { mData: 'TotalPoint' } ,
           
            ]    
        });

} );
</script>