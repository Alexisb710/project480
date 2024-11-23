// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// owl carousel

$(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 3,
        },
        1000: {
            items: 6,
        },
    },
});

// Update the cart header count dynamically
function updateCartHeaderCount(newCount) {
    // Find the cart count badge in the header
    const cartCountBadge = document.getElementById("header-cart-count");
    if (cartCountBadge) {
        cartCountBadge.textContent = newCount; // Update the text content
    }
}

// Format number with commas
function formatNumberWithCommas(number) {
    return number.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

// Update cart item quantity dynamically
function updateCartItem(cartId, quantity) {
    // Ensure the quantity is at least 0
    if (quantity < 1) {
        alert(
            "Quantity must be at least 1. If you wish to remove the item, click the 'Remove' button."
        );
        return;
    }

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/update_cart_ajax/${cartId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken, // Use dynamic CSRF token
        },
        body: JSON.stringify({ quantity }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Update cart total and count dynamically
                const cartTotalElement = document.getElementById("cart-total");
                if (cartTotalElement) {
                    cartTotalElement.innerText = formatNumberWithCommas(
                        data.cart_total
                    );
                }
                document.getElementById("cart-count").innerText =
                    data.cart_count;

                // Update header count dynamically
                updateCartHeaderCount(data.cart_count);

                // Update the Pay with Card link dynamically
                const payWithCardLink =
                    document.querySelector('a[href*="stripe"]');
                if (payWithCardLink) {
                    payWithCardLink.href = `/stripe/${data.cart_total.toFixed(
                        2
                    )}`;
                }

                // Update the Cash on Delivery form dynamically
                const cashOnDeliveryInput = document.querySelector(
                    'input[name="cart_total"]'
                );
                if (cashOnDeliveryInput) {
                    cashOnDeliveryInput.value = data.cart_total.toFixed(2);
                }

                // Ensure the quantity is updated visually
                const inputField = document.querySelector(
                    `#cart-item-${cartId} input[name="quantity"]`
                );
                if (inputField) {
                    inputField.value = quantity;
                }
            } else {
                alert(data.message || "Failed to update the cart.");
            }
        })
        .catch((error) => {
            console.error("Error updating cart:", error);
            alert("An error occurred. Please try again.");
        });
}

function removeCartItem(cartId) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/delete_cart_item/${cartId}`, {
        method: "DELETE", // Use DELETE HTTP method
        headers: {
            "X-CSRF-TOKEN": csrfToken, // Add CSRF token
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Remove the item row from the table
                const row = document.querySelector(`#cart-item-${cartId}`);
                if (row) row.remove();

                // Update cart total and count dynamically
                document.getElementById("cart-total").innerText =
                    data.cart_total.toFixed(2);
                document.getElementById("cart-count").innerText =
                    data.cart_count;

                // Show toastr notification
                toastr.success(data.message, "Success", {
                    timeOut: 5000,
                    closeButton: true,
                    positionClass: "toast-top-right",
                });

                // Update the header cart count dynamically
                updateCartHeaderCount(data.cart_count);
            } else {
                toastr.error(data.message || "Failed to remove the item.");
            }
        })
        .catch((error) => {
            console.error("Error removing cart item:", error);
            toastr.error("An error occurred. Please try again.");
        });
}

function addToCart(productId) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

    fetch(`/add_cart/${productId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ quantity }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Update cart count dynamically
                const cartCountBadge =
                    document.getElementById("header-cart-count");
                if (cartCountBadge) {
                    cartCountBadge.textContent = data.cart_count;
                }

                // Show toastr notification
                toastr.success("Product added to cart!", "Success", {
                    timeOut: 5000,
                    closeButton: true,
                    positionClass: "toast-top-right",
                });
            } else {
                toastr.error(data.message || "Failed to add product to cart.");
            }
        })
        .catch((error) => {
            console.error("Error adding to cart:", error);
            toastr.error("Please make sure you are registered or logged in.");
        });
}
