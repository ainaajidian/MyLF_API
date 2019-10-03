
<script type="text/javascript">
$(function () {

var publicModuleIcon;
var publicModuleId;

$("#module_icon_1").hide();
$("#module_icon_2").hide();

$("#module_parent").hide();

    var datatable = $("#example1").DataTable({
     dom: 'Bfrtip',
      buttons: [
            {
                text: 'Add New Module',
                action: function ( e, dt, node, config ) {
                    openAddmodal();
                }
            }
        ],
         "bProcessing": true,
         "sAjaxSource": "<?=base_url();?>Module/getModule",
         "aoColumns": [
              { mData: 'module_name' } ,
              { mData: 'parent_name' } ,
              { mData: 'module_path' } ,
              { mData: 'module_icon' } , 
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full) {
                return (full.module_flag === "1") ? 'Active' :'Non-active' ;
              }},  
              {
              "mData": null,
              "bSortable": false,
              "mRender": function(data, type, full) {
                if(full.module_flag === "1"){
                return '<a class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                       '<a class="btn btn-danger btn-sm deleteConfirmation"> Deactive </a>';
                }else{
                  return '<a  class="btn btn-info btn-sm showeditModal"> Edit </a> ' +
                         '<a class="btn btn-success btn-sm activeConfirmation"> Active </a> ' +
                         '<a class="btn btn-danger btn-sm deleteForever"> Delete </a>'
                       ;
                }
              }}

            ]    
        });



   $('#example1 tbody').on('click', '.deleteConfirmation', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to Deactive <b>" + data.module_name + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Module/delete/'+data.module_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });


   $('#example1 tbody').on('click', '.activeConfirmation', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to actived  <b>" + data.module_name + "</b> , are you sure?");
        $("#confirm").modal("show");

          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Module/delete/'+data.module_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });


   $('#example1 tbody').on('click', '.deleteForever', function() {
        var data  = datatable.row($(this).parents('tr')).data();
        var module_data = JSON.stringify(data);
        $("#deleteConfirmationmessage").html();
        $("#deleteConfirmationmessage").html("You are about to delete  <b>" + data.module_name + "</b> , are you sure?");
        $("#confirm").modal("show");
          $(".goDelete").click(function(){
                $.ajax({
                url: '<?=base_url();?>Module/deleteForever/'+data.module_id,
                type: 'DELETE',
                success: function(result) {
                   location.reload();
                }
              });
          });
    });   



    $("#exampleModal").on("change","#module_type",function()
    {
        var module_type = $(this).val();
        if(module_type == 1)
        {
          $("#module_icon_2").hide();
          $("#module_icon_1").show();          
          $("#module_parent").hide();
        }
        else if (module_type == 2)
        {
          $("#module_parent").show();
          $("#module_icon_1").hide();
          $("#module_icon_2").show();
        }else{
          $("#module_icon").hide();
          $("#module_icon_1").hide();
          $("#module_icon_2").hide();
           ("#module_parent").hide();
        }
    });

    function openAddmodal()
    { $("#exampleModal").modal("show"); }




    $('#example1 tbody').on('click', '.showeditModal', function() 
    {

        $("#editmoduleForm")[0].reset();
        var data  = datatable.row($(this).parents('tr')).data();
        var modal = $("#editModal").modal("show");
        var edit_module_type    = data.module_type;
        var edit_module_name    = data.module_name;
        var edit_module_parent  = data.module_parent;
        var edit_module_path    = data.module_path;
        var edit_module_icon    = data.module_icon;
        publicModuleId = data.module_id;
        publicModuleIcon        = edit_module_icon
        $("#edit_module_name").val(edit_module_name);
        $("#edit_module_type").val(edit_module_type);
        $("#edit_module_parent").val(edit_module_parent);
        $("#edit_module_icon_2").val(edit_module_icon);
        $("#edit_module_path").val(edit_module_path);
        if(edit_module_type === "1"){
            $("#edit_module_icon_2").hide();
            $("#edit_module_icon_1").show();          
            $("#edit_module_parent").hide();
            $("#edit_module_icon_2").val("");
            publicModuleIcon = ""
        }else if(edit_module_type === "2"){
            $("#edit_module_parent").show();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").show();
            $("#edit_module_icon_2").val(publicModuleIcon);
        }
    });

    $("#editModal").on("change","#edit_module_type",function(){
        var module_type = $(this).val();
        if(module_type == 1){
            $("#edit_module_icon_2").hide();
            $("#edit_module_icon_1").show();          
            $("#edit_module_parent").hide();
            $("#edit_module_icon_2").val("");
        }else if (module_type == 2){
            $("#edit_module_parent").show();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").show();
            $("#edit_module_icon_2").val(publicModuleIcon);
        }else{
            $("#edit_module_parent").hide();
            $("#edit_module_icon_1").hide();
            $("#edit_module_icon_2").hide();
        }
    });

    $("#editmoduleForm").submit(function(e){
            $(this).attr('action', '<?=base_url();?>module/updatemodule/'+publicModuleId);
    })



});


</script>