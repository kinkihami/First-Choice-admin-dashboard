$(document).ready(function () {
    getorders();
    view_order();
    getcount();
});


function view_order() {
    $(document).on("click", '#view_order', function () {
        var id = $(this).data('id');

        sessionStorage.setItem("order_id", id);
        window.location.href = "../order_details/index.php";

    })
}

function getcount(){
    $.ajax({
        url: "ajax.php",
        type: "GET",
        dataType: "json",
        data: { action: "getcount" },
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function (rows) {
            console.log(rows);
            console.log('hiii');

                let orderscount = rows.order;
                let pendingcount = rows.pending;
                let deliveredcount = rows.delivered;
                let dealerscount = rows.dealer;

                console.log(orderscount, pendingcount, deliveredcount, dealerscount);

                $("#ordercount").html(orderscount);
                $("#pendingcount").html(pendingcount);
                $("#deliveredcount").html(deliveredcount);
                $("#dealercount").html(dealerscount);

                
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Error 124 : " + thrownError);
        },
    });
}


function getorders() {
    var pageno = $("#currentpage").val();

    console.log('inside');
    $.ajax({
        url: "../orders/ajax.php",
        type: "GET",
        dataType: "json",
        data: { page: pageno, action: "getorder" },
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function (rows) {
            console.log(rows);
            console.log('hiii');

            if (rows.order) {
                var orderlist = "";
                $.each(rows.order, function (index, order) {
                    orderlist += getordersrow(index, order);

                });

                $("#ordertable tbody").html(orderlist);


            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("Error 124 : " + thrownError);
        },
    });
}




// get player row
function getordersrow(index, order) {
    var orderRow = "";
    if (order) {

        const getstatus = (status) => {
            switch(status) {
                case 0:
                    return `<label class="badge badge-warning">Pending</label>`;
                case 1:
                    return `<label class="badge badge-success">Delivered</label>`;
                case 2:
                    return `<label class="badge badge-danger">Cancelled</label>`;
            }
        };
        orderRow = `<tr>
          <td data-target="id">${index+1}</td>
            <td data-target="colorname">${order.shopname}</td>
            <td data-target="colorcode">${order.area}</td>
            <td data-target="id">${order.ownername}</td>
            <td data-target="colorname">${order.mobile}</td>
            <td data-target="colorcode">${order.whatsappnumber}</td>
            <td data-target="colorcode">${order.orderdate}</td>
            <td class="text-center" data-target="colorcode">${order.totalamount}</td>
            <td data-target="colorname">${getstatus(order.status)}</td>
            <td>
                <button type="button" id="view_order" class="btn btn-outline-success mr-2" data-toggle="modal"
                    data-target="#userViewModal" data-id="${order.id}" title="Edit">
                    View Order
                </button>
                
            </td>
          </tr>`;
    }
    return orderRow;
}


