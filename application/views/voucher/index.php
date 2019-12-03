<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

<body>
<!-- Main content -->
<section class="content">
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Voucher Table</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table width='100%' class="table" id="VoucherTable">
                <thead>
                  <tr> 
                    <th width="25">Voucher Id</th>
                    <th width="25">Kode Voucher</th>
                    <th width="20%">Nama Voucher</th>
                    <th width="15%">Tipe Diskon</th>
                    <th width="20%">Besar Diskon</th>
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
      <form enctype="multipart/form-data" id="voucherForm" action="<?= base_url(); ?>Voucher/saveVoucher" method="POST">
        <div class="modal-body">

          <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

          <div class="input-group mb-3">
            <input autocomplete="off"  required name="voucherName" type="text" class="form-control" placeholder="Nama Voucher">
          </div>

          <div class="input-group mb-3">
            <select class="form-control" id="discountType" name="discountType">
              <option value="" disabled selected>Pilih Tipe Voucher</option>
              <option value="Nominal">Nominal</option>
              <option value="Percent">Persen</option>
            </select>
          </div>

          <div class="input-group mb-3">
            <input autocomplete="off" min="1"
                  step="1"
                  onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="besarNominal" name="besarNominal" type="number" class="form-control" placeholder="Nominal Voucher">
          </div>

          <div class="input-group mb-3">
            <input autocomplete="off" maxlength='2' pattern='^[0-9]$' id="besarPersen" name="besarPersen" type="number" class="form-control" placeholder="Persen Voucher">
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
      <form enctype="multipart/form-data" id="editvoucherForm" action="#" method="POST">
        <div class="modal-body">
          <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

          <input type="hidden" name="voucherId" id="editVoucherId" />

          <div class="input-group mb-3">
              <input autocomplete="off" readonly="true" id="editdiscountType" name="discountType" type="text" class="form-control" placeholder="Discount Type">
          </div>   

          <div class="input-group mb-3">
              <input autocomplete="off" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="editbesarNominal" name="besarNominal" type="number" class="form-control" placeholder="Nominal Voucher">
          </div>
          
          <div class="input-group mb-3">
              <input autocomplete="off" maxlength='2' pattern='^[0-9]$' id="editbesarPersen" name="besarPersen" type="number" class="form-control" placeholder="Persen Voucher">
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
          <button type="submit"  class="btn btn-danger goDelete">Sure </button>
        </div>
    </div>
  </div>
</div>
</section>
<!-- /.content -->

<script type="text/javascript">
  $('#besarPersen').keyup(function(){
  if ($(this).val() > 100){
    alert("Angka persen tidak boleh lebih besar dari 100");
    $(this).val('100');
  }
});
</script>

<script type="text/javascript">
  $('#editbesarPersen').keyup(function(){
  if ($(this).val() > 100){
    alert("Angka persen tidak boleh lebih besar dari 100");
    $(this).val('100');
  }
});
</script>

</body>
</html>