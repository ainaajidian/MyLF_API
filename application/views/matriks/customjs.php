
<script type="text/javascript">
$(function () {



$("#provinsi").change(function(){
 $.ajax({
        type: 'POST',
        url: '<?=base_url();?>Matriks/loadKabupaten/'+$(this).val(),
        success: function (data) {
          data =  $.parseJSON(data);
            var $country = $('#kabupaten');
            $country.empty();
            for (var i = 0; i < data.length; i++) {
                $country.append('<option id=' + data[i].KODE_WILAYAH + ' value=' + data[i].KODE_WILAYAH + '>' + data[i].NAMA + '</option>');
            }
            $country.change();
        }
    });

});


$("#kabupaten").change(function(){
 $.ajax({
        type: 'POST',
        url: '<?=base_url();?>Matriks/loadKecamatan/'+$(this).val(),
        success: function (data) {
          data =  $.parseJSON(data);
            var $country = $('#kecamatan');
            $country.empty();
            for (var i = 0; i < data.length; i++) {
                $country.append('<option id=' + data[i].KODE_WILAYAH + ' value=' + data[i].KODE_WILAYAH + '>' + data[i].NAMA + '</option>');
            }
            $country.change();
        }
    });

});

$("#kecamatan").change(function(){
 $.ajax({
        type: 'POST',
        url: '<?=base_url();?>Matriks/loadDesa/'+$(this).val(),
        success: function (data) {
          data =  $.parseJSON(data);
            var $country = $('#desa');
            $country.empty();
            for (var i = 0; i < data.length; i++) {
                $country.append('<option id=' + data[i].KODE_WILAYAH + ' value=' + data[i].KODE_WILAYAH + '>' + data[i].NAMA + '</option>');
            }
            $country.change();
        }
    });
});







    $('.my-colorpicker1').colorpicker()

var publicModuleIcon;
var publicModuleId;

$("#module_icon_1").hide();
$("#module_icon_2").hide();

$("#module_parent").hide();

    $("#example1").DataTable();
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