<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button"
        class="btn btn-primary px-4 pb-2 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<div class="float-left mr-2 mb-3"><button type="button" id="back"
        class="btn btn-primary px-4 pb-2 pt-2"><i class="fa-solid fa-arrow-left mr-2"></i> Back</button></div>

<dialog id="addcat">
    <div id="addcatbox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Category</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Catalog Name:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="cat_name" name="name" placeholder="Name"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control p_input" placeholder="Notification Message" id="cat_image" name="image"
                            required="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label-sm">Has Subcategory:

                        </label>
                        <input type="checkbox" id="hassubcategory" name="hassubcategory" placeholder="Has Subcategory"
                            value="1">
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick=showdialog(false)>Close</button>
                    <button type="button" class="btn btn-success" id="addcategorybtn">Submit</button>
                    <input type="hidden" name="action" value="addcategory">
                    <input type="hidden" id="parentid" name="parentid" value="">
                    <input type="hidden" name="id" id="cat_id" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

    const dialog1 = document.getElementById('addcat');
    const box1 = document.getElementById('addcatbox');

    const showdialog = (show) => {
        $('#msggg').html('');
        if (show) {

            dialog1.showModal();


        } else {
            dialog1.close();
            $('form').trigger('reset')
            $('#cat_id').val('');
        }
    };

    dialog1.addEventListener('click', (e) => !box1.contains(e.target) && showdialog(false));


</script>