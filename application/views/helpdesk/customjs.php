
<script type="text/javascript">
$(function () {
    $('.my-colorpicker1').colorpicker()

var publicModuleIcon;
var publicModuleId;

$("#module_icon_1").hide();
$("#module_icon_2").hide();

$("#module_parent").hide();

    var datatable = $("#example1").DataTable();
    function openAddmodal(){
       $("#exampleModal").modal("show");
    }



    $(document).on("click",".showeditModal",function(){
      $("#editWarnaForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");

        var BantuanID    = data.BantuanID;
        var NamaBantuan   = data.NamaBantuan;

        $("#edit_jenis_bantuanID").val(BantuanID);
        $("#edit_jenis_bantuan").val(NamaBantuan);

        $("#editModal").modal("show");

    });

    $(document).on("click",".deleteConfirmation",function(){
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("Apakah anda yakin?");
        $("#confirm").modal("show");

        var str = data.BantuanID;

        console.log('<?=base_url();?>Bantuan/hapus/'+str);

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Bantuan/hapus/'+str,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });

    });
});


</script>