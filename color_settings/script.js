$(document).ready(function () {
  add_data();
  get_data();
  delete_data();
  getcolors();
  pagination_li();
});

// get pagination
function pagination(totalpages, currentpage) {
  var pagelist = "";
  if (totalpages > 1 || currentpage>1) {
    currentpage = parseInt(currentpage);
    pagelist += `<ul class="pagination justify-content-center">`;
    const prevClass = currentpage == 1 ? " disabled" : "";
    pagelist += `<li class="page-item${prevClass}"><a class="page-link" href="#" data-page="${
      currentpage - 1
    }">Previous</a></li>`;
    for (let p = 1; p <= totalpages; p++) {
      const activeClass = currentpage == p ? " active" : "";
      pagelist += `<li class="page-item${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
    }
    const nextClass = currentpage == totalpages ? " disabled" : "";
    pagelist += `<li class="page-item${nextClass}"><a class="page-link" href="#" data-page="${
      currentpage + 1
    }">Next</a></li>`;
    pagelist += `</ul>`;
  }

  $("#pagination").html(pagelist);
}


function add_data() {
  $(document).on("click", '#addcolorbtn', function (event) {
    event.preventDefault();

    var alertmsg =
      $("#colorid").val().length > 0
        ? "color has been updated Successfully!"
        : "New color has been added Successfully!";

    var name = $('#colorname').val();
    var code = $('#colorcode').val();
    var id = $('#colorid').val();

    console.log(id);

    if (name == "" || code == "") {
      $('#msggg').html("<p class='alert alert-danger'>Please fill all the fields</p>");
    } else {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        dataType: "json",
        data: { name: name, code: code, id: id, action: "addcolor" },
        success: function (response) {
          $('#msggg').html(response);
          console.log(response);
          if (response.success) {
            showdialog(false);
            getcolors();
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

function pagination_li(){
    // pagination
    $(document).on("click", "ul.pagination li a", function (e) {
      e.preventDefault();
      var $this = $(this);
      const pagenum = $this.data("page");
      $("#currentpage").val(pagenum);
      getcolors();
      $this.parent().siblings().removeClass("active");
      $this.parent().addClass("active");
    });
    // form reset on new button
    // $("#addnewbtn").on("click", function () {
    //   $("#addform")[0].reset();
    //   $("#colorid").val("");
    // });
    
    //  $("#addnewmessagebtn").on("click", function () {
     
    //   $("#addmessageform")[0].reset();
    //   $("#id").val("");
    // });

}

function get_data() {
  $(document).on("click", '#color_edit', function () {
    var id = $(this).data('id');
   
    $.ajax({
      url: "ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: id, action: "getcolorfields" },
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (color) {
        if (color) {
          $('#colorname').val(color.name);
          $('#colorcode').val(color.colorcode);
          $('#colorid').val(color.id);
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
  $(document).on("click", '#color_delete', function () {

    var a = confirm('Do you really want to delete this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "deletecolor" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.deleted == 1) {
            $(".message")
              .html("color has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getcolors();
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

function getcolors() {
  var pageno = $("#currentpage").val();

  console.log('inside');
  $.ajax({
    url: "ajax.php",
    type: "GET",
    dataType: "json",
    data: {  page: pageno, action: "getcolor" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      console.log('hiii');

      if (rows.color) {
        var colorlist = "";
        $.each(rows.color, function (index, color) {
          colorlist += getcolorsrow(index, color, pageno);

        });

        $("#colortable tbody").html(colorlist);



        let totalcolors = rows.count;
        let totalpages = Math.ceil(parseInt(totalcolors) / 15);

        console.log(totalcolors, totalpages);
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
function getcolorsrow(index, color, page) {
  var colorRow = "";
  if (color) {

    const sl= 15*(page-1)+index+1;

    // const userphoto = player.photo ? player.photo : "default.png";
    colorRow = `<tr>
         <td data-target="id">${sl}</td>
          <td class="align-middle text-center">${color.name}</td>
          <td class="align-middle text-center">${color.colorcode}</td>
          <td class="align-middle text-center pl-5"><div style="width: 50px; height: 50px; background-color: ${color.colorcode}; "></div></td>
          <td>
                    <button type="button" id="color_edit" class="btn btn-outline-warning mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${color.id}" title="Edit">
                        Edit
                    </button>
                    <button type="button" id="color_delete" class="btn btn-outline-danger mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${color.id}" title="delete">
                        Delete
                    </button>
                </td>
        </tr>`;
  }
  return colorRow;
}