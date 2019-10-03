<div class="form-actions no-margin-bottom" style="padding-left: 15px">
  <a href="http://memberlf.rpgroup.co.id/Product"><button class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke List</button></a>
</div>

<br>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Product</h3>
                    </div>

                    <div id="coloraddForm" class="row">
                        <div class="card-body col-md">

                            <div class="table-responsive">
                                <form enctype="multipart/form-data" method="POST" action="<?=base_url();?>Product/savecolor/<?=$productId;?>">
                                    <table width='100%' class="table">
                                        <thead>
                                            <tr>
                                                <td>Color Name</td>
                                                <td>
                                                    <select class="form-control" name="color">
                                            <?php foreach ($colors as $color) { ?>
                                                <option value="<?=$color->ccId;?>"> <?=$color->ccName;?> ( <?=$color->ccPriName;?> <?=$color->ccPriHex;?> -  <?=$color->ccSecName;?> <?=$color->ccSecHex;?>) </option>
                                                <?php 	}	?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Image 1</td>
                                                <td>
                                                    <input type="file" name="userfile1" id="userfile1" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Image 2</td>
                                                <td>
                                                    <input type="file" name="userfile2" id="userfile2" class="form-control">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Image 3</td>
                                                <td>
                                                    <input type="file" name="userfile3" id="userfile3" class="form-control">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" align="right">
                                                    <button class="btn btn-info" type="submit"> Save </button>
                                                </td>
                                            </tr>

                                        </thead>

                                    </table>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>