$(document).ready(function () {
  add_data();
  get_data();
  delete_data();
  getareas();
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
  $(document).on("click", '#addareabtn', function (event) {
    event.preventDefault();

    var alertmsg =
      $("#areaid").val().length > 0
        ? "area has been updated Successfully!"
        : "New area has been added Successfully!";

        var areaname = $('#areaname').val();
        var day = $('#day').val();
        var message = $('#message').val();
        var id=$('#areaid').val();

    console.log(id);

    if (areaname == "" || day == "" || message == "") {
      $('#msggg').html("<p class='alert alert-danger'>Please fill all the fields</p>");
    } else {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        dataType: "json",
        data: { name: areaname, day: day, message: message, id: id, action: "addarea" },
        success: function (response) {
          $('#msggg').html(response);
          console.log(response);
          if (response.success) {
            showdialog(false);
            getareas();
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
    getareas();
    $this.parent().siblings().removeClass("active");
    $this.parent().addClass("active");
  });
  // form reset on new button
  // $("#addnewbtn").on("click", function () {
  //   $("#addform")[0].reset();
  //   $("#areaid").val("");
  // });
  
  //  $("#addnewmessagebtn").on("click", function () {
   
  //   $("#addmessageform")[0].reset();
  //   $("#id").val("");
  // });

}

function get_data() {
  $(document).on("click", '#area_edit', function () {
    var id = $(this).data('id');
   
    $.ajax({
      url: "ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: id, action: "getareafields" },
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (area) {
        if (area) {
          $('#areaname').val(area.name);
          $('#day').val(area.notificationday);
          $('#message').val(area.notificationmessage);
          $('#areaid').val(area.id);
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
  $(document).on("click", '#area_delete', function () {

    var a = confirm('Do you really want to delete this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "deletearea" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.deleted == 1) {
            $(".message")
              .html("area has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getareas();
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

function getareas() {
  var pageno = $("#currentpage").val();

  console.log('inside');
  $.ajax({
    url: "ajax.php",
    type: "GET",
    dataType: "json",
    data: {  page: pageno, action: "getarea" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      console.log('hiii');

      if (rows.area) {
        var arealist = "";
        $.each(rows.area, function (index, area) {
          arealist += getareasrow(index, area, pageno);

        });

        $("#areatable tbody").html(arealist);



        let totalareas = rows.count;
        let totalpages = Math.ceil(parseInt(totalareas) / 15);

        console.log(totalareas, totalpages);
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
function getareasrow(index, area, page) {
  var areaRow = "";
  if (area) {

    const getDayName = (dayNumber) => {
      switch(dayNumber) {
          case 0:
              return "Monday";
          case 1:
              return "Tuesday";
          case 2:
              return "Wednesday";
          case 3:
              return "Thursday";
          case 4:
              return "Friday";
          case 5:
              return "Saturday";
          case 6:
              return "Sunday";
          default:
              return "No Day";
      }
  };

  const sl= 15*(page-1)+index+1;
  

    // const userphoto = player.photo ? player.photo : "default.png";
    areaRow = `<tr>
         <td data-target="id">${sl}</td>
          <td class="text-center">${area.name}</td>
          <td class="text-center">${getDayName(area.notificationday)}</td>
          <td class="text-center">${area.notificationmessage}</td>
          <td>
                    <button type="button" id="area_edit" class="btn btn-outline-warning mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${area.id}" title="Edit">
                        Edit
                    </button>
                    <button type="button" id="area_delete" class="btn btn-outline-danger mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${area.id}" title="delete">
                        Delete
                    </button>
                </td>
        </tr>`;
  }
  return areaRow;
}


  