<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Size Table</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table width='100%' class="table" id="SizeTable">
                <thead>
                  <tr>
                    <th width="15">ID Size</th>
                    <th width="20%">Tipe Product</th>
                    <th width="45%">Descripton Size</th>
                    <th width="20%">Action</th>
                  </tr>
                </thead>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Size</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" id="sizeForm" action="<?= base_url(); ?>Size/saveSize" method="POST">
        <div class="modal-body">

          <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

          <div class="input-group mb-3">
            <div class="col-md-12">
              <select class="form-control" id="TipeProduct" name="TipeProduct">
                <option value="" disabled selected>Select Product Type</option>
                <?php foreach ($parent_module as $key) {
                  echo "<option value='" . $key->categoryId . "'> " . $key->categoryId . " - " . $key->categoryName . " </option>";
                } ?>
              </select>
            </div>
          </div>

          <!-- <div id="Lebar" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="Lebar" name="Lebar" type="number" class="form-control" placeholder="Lebar">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="CM" class="form-control">
            </div>
          </div>

          <div id="Tinggi" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="Tinggi" name="Tinggi" type="number" class="form-control" placeholder="Tinggi">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="CM" class="form-control">
            </div>
          </div> -->

          <div id="Ukuran" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="Ukuran" name="Ukuran" type="text" class="form-control" placeholder="Ukuran">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="Size" class="form-control">
            </div>
          </div>

          <div id="Size" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="Size" name="Size" type="number" class="form-control" placeholder="Size">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="Size" class="form-control">
            </div>
          </div>

          <div id="Berat" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="Berat" name="Berat" type="number" class="form-control" placeholder="Berat">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="KG" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="editModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" id="editsizeForm" action="#" method="POST">
        <div class="modal-body">
          <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

          <input type="hidden" name="SizeID" id="editSizeID" />

          <div id="DivTipeProduct" class="input-group mb-3">
            <div class="col-md-12">
              <input readonly="true" autocomplete="off" id="editTipeProduct" name="TipeProduct" type="text" class="form-control" placeholder="Tipe Product">
            </div>
          </div>

          <!-- <div id="DivLebar" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="editLebar" name="Lebar" type="number" class="form-control" placeholder="Lebar">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="CM" class="form-control">
            </div>
          </div>

          <div id="DivTinggi" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="editTinggi" name="Tinggi" type="number" class="form-control" placeholder="Tinggi">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="CM" class="form-control">
            </div>
          </div> -->

          <div id="DivUkuran" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="editUkuran" name="Ukuran" type="text" class="form-control" placeholder="Ukuran">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="Size" class="form-control">
            </div>
          </div>

          <div id="DivSize" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="editSize" name="Size" type="number" class="form-control" placeholder="Size">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="Size" class="form-control">
            </div>
          </div>

          <div id="DivBerat" class="input-group mb-3">
            <div class="col-md-8">
              <input autocomplete="off" id="editBerat" name="Berat" type="number" class="form-control" placeholder="Berat">
            </div>
            <div class="col-md-4">
              <input disabled type="text" value="KG" class="form-control">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="confirm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="deleteConfirmationmessage"> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Nope</button>
        <button type="submit" class="btn btn-danger goDelete">Sure </button>
      </div>
    </div>
  </div>
</div>