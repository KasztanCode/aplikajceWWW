// Cart Management Functions
function addToCart(productId, pageId) {
    const quantity = document.getElementById("qty_" + productId).value;
    fetch(`?id=${pageId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: `action=add&product_id=${productId}&quantity=${quantity}`
    })
        .then(response => response.ok ? updateCartCount(pageId) : Promise.reject('Failed to add to cart'))
        .catch(error => console.error('Error:', error));
}

function removeFromCart(index, pageId) {
    fetch(`?id=${pageId}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: `action=remove&index=${index}`
    })
        .then(response => {
            if (response.ok) {
                location.href = `?id=${pageId}&show_cart=1`;
            }
        })
        .catch(error => console.error('Error:', error));
}



function updateCartCount(pageId) {
    fetch(`?id=${pageId}&show_cart=1`)
        .then(response => response.text())
        .then(html => {
            const temp = document.createElement("div");
            temp.innerHTML = html;
            const count = temp.querySelectorAll(".cart-item").length;
            document.getElementById("cart-count").textContent = count;
        })
        .catch(error => console.error('Error:', error));
}

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    // Validate quantity inputs
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value < 1) {
                this.value = 1;
            }
        });
    });

    // Prevent form submission if search is empty
    document.querySelector('.search-filter-form')?.addEventListener('submit', function(e) {
        const searchInput = this.querySelector('.search-input');
        if (searchInput.value.trim() === '' && this.querySelector('.category-select').value === '0') {
            e.preventDefault();
            const pageId = this.querySelector('input[name="id"]').value;
            location.href = `?id=${pageId}`;
        }
    });
});