<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button" class="btn btn-primary px-4 pb-1 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<dialog id="addsize">
    <div id="addsizebox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Area</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                    
                        <label for="recipient-name" class="col-form-label-sm">Size:</label>
                        <div class="input-group mb-3">
                            
                            <input type="text" class="form-control" id="size" name="title" placeholder="Size" required="required">
                        </div>
                    </div>
                
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick=showdialog(false)>Close</button>
                    <button type="button" class="btn btn-success" id="addsizebtn">Submit</button>
                    <input type="hidden" name="action" value="adduser">
                    <input type="hidden" name="id" id="sizeid" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

    const dialog1 = document.getElementById('addsize');
    const box1 = document.getElementById('addsizebox');
    

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