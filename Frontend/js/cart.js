$(document).ready(function() {
    console.info("read cookies");
    if (getCookie(cartHandler.CART_COOKIE_NAME)) {
        try {
            cartHandler.currentCartItems = JSON.parse(getCookie(cartHandler.CART_COOKIE_NAME));

            if (Object.keys(cartHandler.currentCartItems).length == 0) {
                return;
            }
            cartHandler.addTableToDom();
            for (const [eventId, value] of Object.entries(cartHandler.currentCartItems)) {
                for (const [seatPosition, seatDetails] of Object.entries(value)) {
                    let total = 0;
                    for (let index = 0; index < seatDetails.length; index++) {
                        total += Number(seatDetails[index].price);
                    }
                    for (const [seat, details] of Object.entries(seatDetails)) {
                        $(`[data-seat-id=${details.seatId}]`)[0].setAttribute("disabled", "true");
                    }
                    let item = {
                        "eventId": eventId,
                        eventName: seatDetails[0].eventName,
                        quantity: seatDetails.length,
                        price: seatDetails[0].price,
                        seatLocation: seatDetails[0].seatLocation,
                        "total": total
                    };
                    cartHandler.addItemToTableCart(item);
                }
            }

        } catch (error) {
            console.error("unable to parse json" + error);
            cartHandler.currentCartItems = {};
        }
    }
});

let cartHandler = {
    CART_COOKIE_NAME: "CART",
    currentCartItems: {},
    addTableToDom: () => {
        $("#cart-details").html(`<h1>Order Details</h1>
                            <a href="#" onclick = "cartHandler.clearItemsFromCart()"><b>Clear Cart</b></a>
                            <table id = "cart-items" class="table table-bordered">
                                <thead>
                                    <th width="40%">Ticket Details</th>
                                    <th width="10%">Quantity</th>
                                    <th width="20%">Price</th>
                                    <th width="15%">Total</th>
                                    <th width="5%">Action</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>`);
    },
    addItemToTableCart: (item) => {
        if (!$("#cart-items").length) {
            cartHandler.addTableToDom();
        }
        let row = `<tr id= "${item.eventId}__${item.seatLocation.replace(" ", "")}">
                  <td>${item.eventName}</td>
                  <td>${item.quantity}</td>
                  <td>${item.price}</td>
                  <td>${item.total}</td>
                  <td><a href= "#" onclick= "cartHandler.removeSingleItemFromCart('${item.eventId}__${item.seatLocation.replace(" ", "")}')">Remove</a></td>
              </tr>`;
        if ($(`#${item.eventId}__${item.seatLocation.replace(" ", "")}`).length > 0) {
            $(`#${item.eventId}__${item.seatLocation.replace(" ", "")}`).replaceWith(row);
        } else {
            $("#cart-items tbody").append(row);
        }
    },

    clearItemsFromCart: () => {
        setCookie(cartHandler.CART_COOKIE_NAME, JSON.stringify(cartHandler.currentCartItems), 0);
        cartHandler.currentCartItems = {};
        $("#cart-details").html("");
        $(".addtocart").removeAttr("disabled");
    },

    removeSingleItemFromCart: (elementId) => {
        if (!elementId && elementId.split("__").length > 1) {
            console.log("invalid element id");
            return;
        }
        const [eventId, seatPosition] = elementId.split("__");
        let eventObj = cartHandler.currentCartItems[eventId]
        for (const [seat, details] of Object.entries(eventObj[seatPosition])) {
            $(`[data-seat-id=${details.seatId}]`)[0].removeAttribute("disabled");
        }
        delete eventObj[seatPosition];
        $(`#${elementId}`).remove();
        if (Object.keys(eventObj).length == 0) {
            delete cartHandler.currentCartItems[eventId];
        }

        setCookie(cartHandler.CART_COOKIE_NAME, JSON.stringify(cartHandler.currentCartItems), 1);
    },
    checkoutCart(that) {
        let eventSeatIds = {};
        for (const [eventId, value] of Object.entries(cartHandler.currentCartItems)) {
            eventSeatIds[eventId] = { seats: [], price: [] };
            for (const [seatPosition, seatDetails] of Object.entries(value)) {
                for (const [seat, details] of Object.entries(seatDetails)) {
                    eventSeatIds[eventId]["seats"].push(details.seatId);
                    eventSeatIds[eventId]["price"].push(details.price)
                }
            }
        }
        let nameCust = $("#name").val();
        $.ajax({
            type: "POST",
            url: "./checkoutTickets.php",
            dataType: "JSON",
            data: { ticketsData: JSON.stringify(eventSeatIds), "name": nameCust },
            success: function(result) {
                if (result.statusCode == 0) {
                    cartHandler.clearItemsFromCart();
                    location.href = "./ticketDetails.php?ticketIds=" + result.data.ticketIds.join("_");
                } else {
                    console.log("something went wrong");
                }
            },
            error: function(err) {
                console.log(err.responseText)
            },
            TIMEOUT: 10000
        });
    }

};

function addToCart(that) {
    //console.log(that);
    let eventId = that.getAttribute("data-event-id");
    let item = {
        eventName: that.getAttribute("data-event-name"),
        seatNo: that.getAttribute("data-event-seatNo"),
        seatId: that.getAttribute("data-seat-id"),
        price: that.getAttribute("data-price"),
        seatLocation: that.getAttribute("data-seat-location")
    };

    if (!cartHandler.currentCartItems[eventId]) {
        cartHandler.currentCartItems[eventId] = {};
        cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")] = [item];
    } else {
        if (!cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")]) {
            cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")] = [];
            cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")].push(item);
        } else {
            cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")].push(item);
        }
    }

    let total = 0;
    for (let index = 0; index < cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")].length; index++) {
        total += Number(cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")][index].price);
    }
    cartHandler.addItemToTableCart({
        "eventId": eventId,
        "quantity": cartHandler.currentCartItems[eventId][item.seatLocation.replace(" ", "")].length,
        eventName: item.eventName,
        price: item.price,
        seatLocation: item.seatLocation,
        "total": total
    });
    that.setAttribute("disabled", true);
    setCookie(cartHandler.CART_COOKIE_NAME, JSON.stringify(cartHandler.currentCartItems), 1);
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}