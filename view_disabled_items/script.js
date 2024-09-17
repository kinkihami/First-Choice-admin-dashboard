$(document).ready(function () {
  delete_data();
  getdisableitems();
  pagination_li();
  enable_data();
  searching();
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


function pagination_li() {
  // pagination
  $(document).on("click", "ul.pagination li a", function (e) {
    e.preventDefault();
    var $this = $(this);
    const pagenum = $this.data("page");
    $("#currentpage").val(pagenum);
    getdisableitems();
    $this.parent().siblings().removeClass("active");
    $this.parent().addClass("active");
  });
  // form reset on new button
  // $("#addnewbtn").on("click", function () {
  //   $("#addform")[0].reset();
  //   $("#disableitemid").val("");
  // });

  //  $("#addnewmessagebtn").on("click", function () {

  //   $("#addmessageform")[0].reset();
  //   $("#id").val("");
  // });

}

// function get_data() {
//   $(document).on("click", '#disableitem_edit', function () {
//     var id = $(this).data('id');

//     $.ajax({
//       url: "ajax.php",
//       type: "GET",
//       dataType: "json",
//       data: { id: id, action: "getdisableitemfields" },
//       beforeSend: function () {
//         $("#overlay").fadeIn();
//       },
//       success: function (disableitem) {
//         if (disableitem) {
//           $('#disableitem').val(disableitem.disableitem);
//           $('#disableitemid').val(disableitem.id);
//           showdialog(true);
//         }
//         $("#overlay").fadeOut();
//       },
//       error: function (xhr, ajaxOptions, thrownError) {
//         alert("Error : " + thrownError);
//       },
//     });
//   })
// }


function delete_data() {
  $(document).on("click", '#disableitem_delete', function () {

    var a = confirm('Do you really want to delete this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "deletedisableitem" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.deleted == 1) {
            $(".message")
              .html("disableitem has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getdisableitems();
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

function enable_data() {
  $(document).on("click", '#disableitem_enable', function () {


    var a = confirm('Are you sure you want to enable this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "enabledisableitem" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.success) {
            $(".message")
              .html("disableitem has been enabled successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getdisableitems();
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


function searching() {
    $("#search").on("keyup", function () {

    const searchText = $(this).val();
    console.log(searchText);
 
    if (searchText.length >= 1) {
      $.ajax({
        url: "ajax.php",
        type: "GET",
        dataType: "json",
        data: { searchQuery: searchText, action: "search" },
        success: function (rows) {
          $('#pagination').hide();
          console.log(rows);
          if (rows.searchlist) {
            var searchlist = "";
            $.each(rows.searchlist, function (index, search) {
              searchlist += getdisableitemsrow(index, search,1);
    
            });
    
            $("#disableitemtable tbody").html(searchlist);
    
          }
        },
        error: function (xhr, ajaxOptions, thrownError){
          alert("Error : "+thrownError);
          console.error('AJAX Error:', xhr.status, thrownError);
          console.error('Response Text:', xhr.responseText);
      }    
      });
    } else {
      getdisableitems();
       $("#pagination").show();
     }
  })
}


  


function getdisableitems() {
  var pageno = $("#currentpage").val();

  console.log('inside');
  $.ajax({
    url: "ajax.php",
    type: "GET",
    dataType: "json",
    data: { page: pageno, action: "getdisableitem" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      console.log('hiii');

      if (rows.disableitem) {
        var disableitemlist = "";
        $.each(rows.disableitem, function (index, disableitem) {
          disableitemlist += getdisableitemsrow(index, disableitem, pageno);

        });

        $("#disableitemtable tbody").html(disableitemlist);



        let totaldisableitems = rows.count;
        let totalpages = Math.ceil(parseInt(totaldisableitems) / 15);

        console.log(totaldisableitems, totalpages);
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
function getdisableitemsrow(index, disableitem, page) {
  var disableitemRow = "";
  if (disableitem) {

    const sl= 15*(page-1)+index+1;

    // const userphoto = player.photo ? player.photo : "default.png";
    disableitemRow = `<tr>
            <td data-target="id">${sl}</td>
                <td class="text-center" data-target="colorname">${disableitem.itemcode}</td>
                <td data-target="colorcode">${disableitem.name}</td>
                <td data-target="parent_category_id"><img width="100" height="100" src="../itemimages/${disableitem.mainimage}" ></td>
                <td class="text-center" data-target="colorname">${disableitem.normalprice}</td>
                <td data-target="colorcode">${disableitem.description}</td>
                <td data-target="colorcode">${disableitem.isfresharrival}</td>
               
                <td id="top">
                    
                    <button type="button" id="disableitem_enable" class="btn btn-outline-success mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${disableitem.id}" title="Edit">
                        Enable
                    </button>
                    <button type="button" id="disableitem_delete" class="btn btn-outline-danger mr-2"
                        data-toggle="modal" data-target="#userViewModal" data-id="${disableitem.id}" title="Edit">
                        Delete
                    </button>
                    
                </td>
          </tr>`;
  }
  return disableitemRow;
}