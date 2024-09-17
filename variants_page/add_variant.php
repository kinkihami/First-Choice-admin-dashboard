<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button"
        class="btn btn-primary px-4 pb-1 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<dialog id="addvariant">
    <div id="addvariantbox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Variants</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="day" class="col-form-label-sm">Item Color:</label>
                        <div class="input-group mb-3">
                            <select class="form-control p_input" id="colorselect" name="color">
                                <option value="" disabled selected hidden>
                                    Select a Color </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label-sm">Item Size:</label>
                        <div class="input-group mb-3">
                            <select class="form-control p_input" id="sizeselect" name="size">
                                <option value="" disabled selected hidden>
                                    Select a Size </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Price:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="price" name="price" placeholder="Price"
                                required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label-sm">variant Image:</label>
                        <input type="file" id="variant_image" class="form-control p_input"
                            placeholder="Notification Message" name="image" required="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label-sm">Is Fresh Arrival:

                        </label>
                        <input type="checkbox" id="fresh_arrival" name="fresh" placeholder="Has Subcategory"
                            value="1">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick=showdialog(false)>Close</button>
                    <button type="button" class="btn btn-success" id="addvariantbtn">Submit</button>
                    <input type="hidden" name="action" value="addvariant">
                    <input type="hidden" name="item" id="productid">
                    <input type="hidden" name="id" id="variant_id" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

const dialog1 = document.getElementById('addvariant');
    const box1 = document.getElementById('addvariantbox');
    const showdialog = (show) => {
        $('#msggg').html('');
        if (show) {

            dialog1.showModal();


        } else {

            dialog1.close();
            $('form').trigger('reset');
            $('#productid').val('');
            $('#variant_id').val('');

        }

    };

    dialog1.addEventListener('click', (e) => !box1.contains(e.target) && showdialog(false));




</script>