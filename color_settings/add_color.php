<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button"
        class="btn btn-primary px-4 pb-1 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<dialog id="addcolor">
    <div id="addcolorbox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Color</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST">
                <div class="modal-body">
                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Color Name:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="colorname" name="title" placeholder="Name"
                                required="required">
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="recipient-name" class="col-form-label-sm">Color Code:</label>
                        <div class="input-group mb-3">

                            <textarea name="message" style="overflow: hidden; resize: none" id="colorcode" placeholder="Code"
                                class="form-control" cols="40" rows="1"></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick=showdialog(false)>Close</button>
                    <button type="button" class="btn btn-success" id="addcolorbtn">Submit</button>
                    <input type="hidden" name="action" value="adduser">
                    <input type="hidden" name="colorid" id="colorid" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

    const dialog1 = document.getElementById('addcolor');
    const box1 = document.getElementById('addcolorbox');

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