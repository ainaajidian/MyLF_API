
<script type="text/javascript">
$(document).ready( function () {

$("#addSize").click(function(){
  $("#addSizeModal").modal("show");
});

$("#productColorId").change(function(){
   $.ajax({
      url: "<?=base_url();?>Product/getImage/"+$(this).val(),
       beforeSend: function() {
         
      },
      success:function(result){
          var result = jQuery.parseJSON(result);
          console.log(result.productColorId);
          $("#imageexample1").attr('src', '../../../assets/app_assets/product_image/'+result.image1);
          $("#imageexample2").attr('src', '../../../assets/app_assets/product_image/'+result.image2);
          $("#imageexample3").attr('src', '../../../assets/app_assets/product_image/'+result.image3);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
       
      }
  });
});

$(".productImage").click(function(){
  var image = $(this).data("id");
  var productId = $(this).data("value");
  isGood=confirm('Set sebagai gambar default ?');
    if (isGood) {
      $.ajax({
        url: "<?=base_url();?>Product/saveDefaultImage/"+image+"/"+productId,
        beforeSend: function() {
          
        },
        success:function(result){
            var result = jQuery.parseJSON(result);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        
        }
    });
    } else { return;    }
});


var selOpts = "";
var niplogin = '<?=$username;?>';
$.ajax({
      url: "https://eproc.rpgroup.co.id/mylfapi/userOutlet/"+niplogin,
       beforeSend: function() {
         
      },
      success:function(result){
          var result = jQuery.parseJSON(result);
          $("#storeId").val(result.OutletCode);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
       
      }
  });


$("#submitBtn").attr("disabled", true);

  $("#findItem").click(function(){
      var erpCode = $("#erpCode").val();
      if(erpCode < 4){
          return;
      }
      $.ajax({
        url: "https://eproc.rpgroup.co.id/mylfapi/index/"+erpCode,
         beforeSend: function() {
            $("#findItem").text("Please Wait...");
        },
        success:function(result){
            var result = jQuery.parseJSON(result);
            $("#submitBtn").attr("disabled", false);
            $("#productName").val(result.data.ItemName);
            $("#uomCode").val(result.data.MainUOMCode);
            $("#productPrice").val(result.data.price);
            $("#findItem").text(" Check Item ");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#findItem").text("Harap cek ulang item");
        }
    });
  });

  $("#productCategory").change(function(){
  
     $.ajax({
          url: "<?=base_url();?>Product/getChildCategory/"+$(this).val(),
           beforeSend: function() {
             // $("#findItem").text("Please Wait...");
          },
          success:function(result){
              $('#childproductCategory').find('option').remove();
              var result = jQuery.parseJSON(result);
              $.each(result, function(k, v)
              {
                  $('#childproductCategory').append("<option value='"+result[k].categoryId+"'>"+ result[k].categoryName+"</option>");
              });
           
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
           // $("#findItem").text("Harap cek ulang item");
          }
      });
  });


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
                    '<a href="<?=base_url();?>Product/deactive/'+full.productId+'" class="btn btn-danger btn-sm"> Deactive </a>';
          }
          else
          {
            return  '<a href="<?=base_url();?>Product/detail/'+full.productId+'" class="btn btn-success btn-sm"> Detail </a> ' +
                   '<a href="<?=base_url();?>Product/active/'+full.productId+'" class="btn btn-success btn-sm"> Active </a> ' +
                   '<a href="<?=base_url();?>Product/deleteProduct/'+full.productId+'" class="btn btn-danger btn-sm"> Delete </a>' ;
          }
        }
      }
    ]    
});


//ADDSTOK//


//  

} );
</script>