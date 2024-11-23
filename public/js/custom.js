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

// Update cart item quantity dynamically
function updateCartItem(cartId, quantity) {
    // Ensure the quantity is at least 0
    if (quantity < 0) {
        alert("Quantity must be at least 0.");
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
                document.getElementById("cart-total").innerText =
                    data.cart_total.toFixed(2);
                document.getElementById("cart-count").innerText =
                    data.cart_count;

                // Update header count dynamically
                updateCartHeaderCount(data.cart_count);

                // Remove the item row if quantity is 0
                if (quantity == 0) {
                    const row = document.querySelector(`#cart-item-${cartId}`);
                    if (row) row.remove();
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
