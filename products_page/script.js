$(document).ready(function () {
  add_data();
  get_data();
  getproducts();
  pagination_li();
  disable_product();
  variant_btn();
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
  $(document).on("click", '#addproductbtn', function () {
    var catid = sessionStorage.getItem('product_id');
    var code = $('#product_code').val();
    var name = $('#product_name').val();
    var price = $('#product_price').val();
    var desc = $('#product_desc').val();
    var color = $('#product_color_text').val();
    var image = $('#product_image').val();
    $('#catid').val(catid);

    var product_id = $('#product_id').val();

    if(product_id == ""){
      if (name == "" || image == "" || price == "" || desc == "" || color == "" || code == "") {
        $('#msggg').html("<p class='alert alert-danger'>Please fill all the fields</p>");
      } else {
        var form_data = new FormData(document.getElementById("addform"));
        $.ajax({
          url: "ajax.php",
          method: "POST",
          data: form_data,
          processData: false, // Tell jQuery not to process the data
          contentType: false,
          success: function (response) {
            $('#msggg').html(response);
            console.log(response);
            if (response) {
              showdialog(false);
              getproducts();
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
    }else {
      var form_data = new FormData(document.getElementById("addform"));
      $.ajax({
        url: "ajax.php",
        method: "POST",
        data: form_data,
        processData: false, // Tell jQuery not to process the data
        contentType: false,
        success: function (response) {
          $('#msggg').html(response);
          console.log(response);
          if (response) {
            showdialog(false);
            getproducts();
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


function disable_product() {
  $(document).on("click", '#disable_product', function () {


    var a = confirm('Are you sure you want to disable this?');

    if (a) {
      var id = $(this).data('id');
      $.ajax({
        url: "ajax.php",
        type: "POST",
        dataType: "json",
        data: { id: id, action: "disableproduct" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          console.log(res);
          if (res.success) {
            $(".message")
              .html("Product has been disabled successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
              getproducts();
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

function variant_btn() {
  $(document).on("click", '#variant_btn', function () {

      var id = $(this).data('id');
      sessionStorage.setItem('variant_id', id);
      window.location.href = "../variants_page/index.php";
  })
}



function pagination_li() {
  // pagination
  $(document).on("click", "ul.pagination li a", function (e) {
    e.preventDefault();
    var $this = $(this);
    const pagenum = $this.data("page");
    $("#currentpage").val(pagenum);
    getproducts();
    $this.parent().siblings().removeClass("active");
    $this.parent().addClass("active");
  });
  // form reset on new button
  // $("#addnewbtn").on("click", function () {
  //   $("#addform")[0].reset();
  //   $("#productid").val("");
  // });

  //  $("#addnewmessagebtn").on("click", function () {

  //   $("#addmessageform")[0].reset();
  //   $("#id").val("");
  // });

}

function get_data() {
  $(document).on("click", '#product_edit', function () {
    var id = $(this).data('id');

    $.ajax({
      url: "ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: id, action: "getproductfields" },
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (product) {
        if (product) {
          $('#product_code').val(product.itemcode);
          $('#product_name').val(product.name);
          $('#product_price').val(product.normalprice);
          $('#product_desc').val(product.description);
          $('#product_color_text').val(product.colortext);
          $('#fresh_arrival').prop('checked', product.isfresharrival == 1);
          $('#product_id').val(product.id);

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



function getproducts() {
  var pageno = $("#currentpage").val();
  var id = sessionStorage.getItem('product_id');
  console.log('id=', id);
  $.ajax({
    url: "ajax.php",
    type: "GET",
    dataType: "json",
    data: { page: pageno, id: id, action: "getproduct" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      console.log('hiii');

      if (rows.product) {
        var productlist = "";
        $.each(rows.product, function (index, product) {
          productlist += getproductsrow(index, product, pageno);

        });

        $("#producttable tbody").html(productlist);



        let totalproducts = rows.count;
        let totalpages = Math.ceil(parseInt(totalproducts) / 15);

        console.log(totalproducts, totalpages);
        const currentpage = $("#currentpage").val();
        console.log(currentpage);
        pagination(totalpages, currentpage);
        $("#overlay").fadeOut();
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert("Error 124 : " + thrownError);
      console.log("Haii Error has happened");
    },
  });
}


// get player row
function getproductsrow(index, product, page) {
  var productRow = "";
  if (product) {


    const fresharrival = (fresh) => {
      switch(fresh) {
          case 0:
              return `No`;
          case 1:
              return `Yes`;
      }
  };

  const sl= 15*(page-1)+index+1;


    // const userphoto = player.photo ? player.photo : "default.png";
    productRow = `<tr>
            <td data-target="id">${sl}</td>
                <td class="text-center" data-target="cat_name">${product.itemcode}</td>
                <td class='text-center' data-target="cat_image">${product.name}</td>
                <td data-target="parent_category_id"><img width="100" height="100" src="../itemimages/${product.mainimage}" ></td>
                
                <td class="text-center" data-target="cat_name">${product.normalprice}</td>-
                <td class='text-center' data-target="cat_image">${product.description}</td>
                <td class="pl-4" data-target="parent_product_id">${fresharrival(product.isfresharrival)}</td>
                  <td id="top">
                      <button type="button" id="product_edit" class="btn btn-outline-warning mr-2"
                          data-toggle="modal" data-target="#userViewModal" data-id="${product.id}" title="Edit">
                          Edit
                      </button>
                      <button type="button" id="disable_product" class="btn btn-outline-danger mr-2"
                          data-toggle="modal" data-target="#userViewModal" data-id="${product.id}" title="Edit">
                          Disable
                      </button>
                      <button type="button" id="variant_btn" class="btn btn-outline-info mr-2"
                          data-toggle="modal" data-target="#userViewModal" data-id="${product.id}" title="Edit">
                          Add Variant
                      </button>
                    
                  </td>
          </tr>`;
  }
  return productRow;
}