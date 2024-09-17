<div class="float-right mr-2 mb-3" onclick=showdialog(true)><button type="button"
        class="btn btn-primary px-4 pb-1 pt-2"><i class="fa-regular fa-square-plus mr-2"></i> Add</button></div>

<dialog id="addarea">
    <div id="addareabox">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Add/Edit Area</h5>

            </div>
            <span id="msggg" class="text-center"></span>
            <form id="addform" method="POST">
                <div class="modal-body">
                    <div class="form-group">

                        <label for="areaname" class="col-form-label-sm">Area Name:</label>
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" id="areaname" name="title" placeholder="Name"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <label for="day" class="col-form-label-sm">Notification Day:</label>
                            <select class="form-control" name="notificationday" id="day" aria-placeholder="Select Day">

                                <option value="" disabled selected hidden>
                                    Select a day </option>
                                <option value="0">
                                    Monday </option>

                                <option value="1">
                                    Tuesday </option>

                                <option value="2">
                                    Wednesday </option>

                                <option value="3">
                                    Thursday </option>

                                <option value="4">
                                    Friday </option>

                                <option value="5">
                                    Saturday </option>

                                <option value="6">
                                    Sunday </option>


                            </select>
                        </div>
                    </div>

                    <div class="form-group">

                        <label for="message" class="col-form-label-sm">Notification Message:</label>
                        <div class="input-group mb-3">

                            <textarea name="message" id="message" style="overflow: hidden; resize: none"
                                placeholder="Message" class="form-control" cols="40" rows="1"></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick=showdialog(false)>Close</button>
                    <button type="button" class="btn btn-success" id="addareabtn">Submit</button>
                    <input type="hidden" name="action" value="adduser">
                    <input type="hidden" name="id" id="areaid" value="">
                </div>
            </form>
        </div>

    </div>
</dialog>

<script>

    const dialog1 = document.getElementById('addarea');
    const box1 = document.getElementById('addareabox');
    const textarea = document.querySelector('textarea');

    const showdialog = (show) => {
        $('#msggg').html('');
        if (show) {

            dialog1.showModal();


        } else {

            dialog1.close();
            $('form').trigger('reset');
            textarea.style.height = 'auto';
            $('#areaid').val("");
        }
    };

    dialog1.addEventListener('click', (e) => !box1.contains(e.target) && dialog1.close());



    textarea.addEventListener('input', function () {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });

</script>
<script src="script.js"></script>