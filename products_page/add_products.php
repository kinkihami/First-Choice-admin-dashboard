<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button"
        class="btn btn-primary px-4 pb-1 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<dialog id="addproduct">
    <div id="addproductbox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Products</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Item Code:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="product_code" name="code" placeholder="Code"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Item Name:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="product_name" name="name" placeholder="Name"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Price:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="product_price" name="price" placeholder="Price"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Description:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="product_desc" name="desc" placeholder="Description"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Color Text:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="product_color_text" name="color" placeholder="Price"
                                required="required">
                        </div>
                    </div>

                    <div class="form-group">
                    <label for="recipient-name" class="col-form-label-sm">Product Image:</label>
                        <input type="file" id="product_image" class="form-control p_input" placeholder="Notification Message" name="image"
                            required="">
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
                    <button type="button" class="btn btn-success" id="addproductbtn">Submit</button>
                    <input type="hidden" name="catid" id="catid" value="adduser">
                    <input type="hidden" name="action" value="addproduct">
                    <input type="hidden" name="id" id="product_id" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

    const dialog1 = document.getElementById('addproduct');
    const box1 = document.getElementById('addproductbox');
    const showdialog = (show) => {
        $('#msggg').html('');
        if (show) {

            dialog1.showModal();


        } else {

            dialog1.close();
            $('form').trigger('reset');

        }
    };

    dialog1.addEventListener('click', (e) => !box1.contains(e.target) && dialog1.close());




</script>