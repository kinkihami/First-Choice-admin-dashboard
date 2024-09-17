$(document).ready(function () {
  add_data();
  get_data();
  delete_data();
  getsizes();
  pagination_li();
});

// get pagination
function pagination(totalpages, currentpage) {
  var pagelist = "";
  if (totalpages > 1 || currentpage > 1) {
    currentpage = parseInt(currentpage);
    pagelist += `<ul class="pagination justify-content-center">`;
    const prevClass = currentpage == 1 ? " disabled" : "";
    pagelist += `<li class="page-item${prevClass}"><a class="page-link" href="#" data-page="${currentpage - 1
      }">Previous</a></li>`;
    for (let p = 1; p <= totalpages; p++) {
      const activeClass = currentpage == p ? " active" : "";
      pagelist += `<li class="page-item${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
    }
    const nextClass = currentpage == totalpages ? " disabled" : "";
    pagelist += `<li class="page-item${nextClass}"><a class="page-link" href="#" data-page="${currentpage + 1
      }">Next</a></li>`;
    pagelist += `</ul>`;
  }

  $("#pagination").html(pagelist);
}


function add_data() {
  $(document).on("click", '#addsizebtn', function (event) {
    event.preventDefault();

    var alertmsg =
      $("#sizeid").val().length > 0
        ? "size has been updated Successfully!"
        : "New size has been added Successfully!";

    var size = $('#size').val();
    var id = $('#sizeid').val();

    console.log(id);

    if (size == "") {
      $('#msggg').html("<p class='alert alert-danger'>Please fill all the fields</p>");
    } else {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        dataType: "json",
        data: { size: size, id: id, action: "addsize" },
        success: function (response) {
          $('#msggg').html(response);
          console.log(response);
          if (response.success) {
            showdialog(false);
            getsizes();
            $("#overlay").fadeOut();
          }
          console.log('success');
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert("Error : " + thrownError);
          console.log('error');
        },
      })
    }
  })
}

function pagination_li() {
  // pagination
  $(document).on("click", "ul.pagination li a", function (e) {
    e.preventDefault();
    var $this = $(this);
    const pagenum = $this.data("page");
    $("#currentpage").val(pagenum);
    getsizes();
    $this.parent().siblings().removeClass("active");
    $this.parent().addClass("active");
  });
  // form reset on new button
  // $("#addnewbtn").on("click", function () {
  //   $("#addform")[0].reset();
  //   $("#sizeid").val("");
  // });

  //  $("#addnewmessagebtn").on("click", function () {

  //   $("#addmessageform")[0].reset();
  //   $("#id").val("");
  // });

}

function get_data() {
  $(document).on("click", '#size_edit', function () {
    var id = $(this).data('id');

    $.ajax({
      url: "ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: id, action: "getsizefields" },
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (size) {
        if (size) {
          $('#size').val(size.size);
          $('#sizeid').val(size.id);
          showdialog(true);
        }
        $("#overlay").fadeOut();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert("Error : " + thrownError);
      },
    });
  })
}


function delete_data() {
  $(document).on("click", '#size_delete', function () {

    var a = confirm('Do you really want to delete this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "deletesize" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.deleted == 1) {
            $(".message")
              .html("size has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getsizes();
            $("#overlay").fadeOut();
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert("Error : " + thrownError);
        },
      });
    }
  })
}

function getsizes() {
  var pageno = $("#currentpage").val();

  console.log('inside');
  $.ajax({
    url: "ajax.php",
    type: "GET",
    dataType: "json",
    data: { page: pageno, action: "getsize" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      console.log('hiii');

      if (rows.size) {
        var sizelist = "";
        $.each(rows.size, function (index, size) {
          sizelist += getsizesrow(index, size, pageno);

        });

        $("#sizetable tbody").html(sizelist);



        let totalsizes = rows.count;
        let totalpages = Math.ceil(parseInt(totalsizes) / 15);

        console.log(totalsizes, totalpages);
        const currentpage = $("#currentpage").val();
        console.log(currentpage);
        pagination(totalpages, currentpage);
        $("#overlay").fadeOut();
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert("Error 124 : " + thrownError);
    },
  });
}


// get player row
function getsizesrow(index, size, page) {
  var sizeRow = "";
  if (size) {

    const sl= 15*(page-1)+index+1;

    // const userphoto = player.photo ? player.photo : "default.png";
    sizeRow = `<tr>
           <td data-target="id">${sl}</td>
            <td class="text-center">${size.size}</td>
            <td>
                      <button type="button" id="size_edit" class="btn btn-outline-warning mr-2"
                          data-toggle="modal" data-target="#userViewModal" data-id="${size.id}" title="Edit">
                          Edit
                      </button>
                      <button type="button" id="size_delete" class="btn btn-outline-danger mr-2"
                          data-toggle="modal" data-target="#userViewModal" data-id="${size.id}" title="delete">
                          Delete
                      </button>
                  </td>
          </tr>`;
  }
  return sizeRow;
}