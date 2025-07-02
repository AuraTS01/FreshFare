
    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-4">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="img/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 278/4A1, Bharathi Estate Part 3, Karamadai, Mettupalayam</li>
                            <li>Phone: +91 87543 64997</li>
                            <li>Email: info@freshfare.aurats.com</li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://aurats.com" target="_blank">Aura Technology Solutions</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                        <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>   
    <script>

        const products = [
            "Laptop",
            "Smartphone",
            "Headphones",
            "Smartwatch",
            "Keyboard",
            "Mouse"
            ];

            const searchInput = document.getElementById("searchInput");
            const productList = document.getElementById("productList");

            // Display all products initially
            function displayProducts(filteredProducts) {
            productList.innerHTML = "";
            filteredProducts.forEach(product => {
                const li = document.createElement("li");
                li.textContent = product;
                productList.appendChild(li);
            });
            }

            // Filter on input
            searchInput.addEventListener("input", () => {
            const query = searchInput.value.toLowerCase();
            const filtered = products.filter(product =>
                product.toLowerCase().includes(query)
            );
            displayProducts(filtered);
            });

            // Initial display
        displayProducts(products);

    </script>

    <script>

        const products = [
            { id: 1, name: "Chicken", price: 200 },
            { id: 2, name: "Smartphone", price: 800 },
            { id: 3, name: "Headphones", price: 200 }
            ];

            const cart = [];

            const productList = document.getElementById("productList");
            const cartList = document.getElementById("cartList");

            // Render product list
            products.forEach(product => {
            const div = document.createElement("div");
            div.innerHTML = `
                <strong>${product.name}</strong> - $${product.price}
                <button onclick="addToCart(${product.id})">Add to Cart</button>
            `;
            productList.appendChild(div);
            });

            // Add item to cart
            function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const cartItem = cart.find(item => item.id === productId);

            if (cartItem) {
                cartItem.quantity += 1;
            } else {
                cart.push({ ...product, quantity: 1 });
            }

            renderCart();
            }

            // Render cart
            function renderCart() {
            cartList.innerHTML = "";
            cart.forEach(item => {
                const li = document.createElement("li");
                li.textContent = `${item.name} - $${item.price} x ${item.quantity}`;
                cartList.appendChild(li);
            });
            }

    </script>
    <script>
        function addToCart(button, name, price) {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const existingItem = cart.find(item => item.name === name);

            if (!existingItem) {
                cart.push({ name, price, quantity: 1 }); // default quantity is 1
                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartCount();

                // Button styling
                button.innerHTML = `<i class="fa fa-shopping-cart"></i> View Cart`;
                button.classList.remove("btn-success");
                button.classList.add("btn-primary");
            } else {
                window.location.href = "shoping-cart.php";
            }
        }



        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const cartCounter = document.getElementById("cart-count");
            if (cartCounter) {
                cartCounter.textContent = cart.length;
            }
        }
        function markCartButtons() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const buttons = document.querySelectorAll("button[data-product-name]");

            buttons.forEach(button => {
                const productName = button.getAttribute("data-product-name");
                const alreadyAdded = cart.some(item => item.name === productName);

                if (alreadyAdded) {
                button.innerHTML = `<i class="fa fa-shopping-cart"></i> View Cart`;
                button.classList.remove("btn-success");
                button.classList.add("btn-success");
                button.setAttribute("data-added", "true");
                }
            });
        }

        // Run once on page load
        document.addEventListener("DOMContentLoaded", function () {
            updateCartCount();
            markCartButtons();

            const isLocationChecked = localStorage.getItem("locationVerified");
            if (!isLocationChecked) {
                checkUserLocation();
            }
        });
    </script>
    <script>
        function loadCartItems() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const cartBody = document.getElementById("cartTableBody");
            const cartTotal = document.getElementById("cartTotal");
            cartBody.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
            cartBody.innerHTML = '<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>';
            cartTotal.textContent = '0.00';
            return;
        }

        cart.forEach((item, index) => {
        const quantity = item.quantity || 1;
        const pricePerUnit = item.price;
        const itemTotal = pricePerUnit * quantity;
        total += itemTotal;

        const row = document.createElement("tr");
        row.innerHTML = `
            <td class="shoping__cart__item">
                <img src="${item.image || 'img/cart/cart-1.jpg'}" alt="" style="width:70px; height:auto;">
                <h5>${item.name}</h5>
            </td>
            <td class="shoping__cart__price">₹${pricePerUnit.toFixed(2)} /kg</td>
            <td class="shoping__cart__step text-center">
                <select onchange="setIncrement(${index}, this.value)" class="form-select form-select-sm" id="inc-${index}" style="width: 80px;">
                <option value="1" ${item.increment === 1 ? 'selected' : ''}>1 kg</option>
                <option value="0.5" ${item.increment === 0.5 ? 'selected' : ''}>0.5 kg</option>
                </select>
            </td>
            <td class="shoping__cart__quantity text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                <button onclick="updateQuantity(${index}, -1)" class="btn btn-outline-secondary btn-sm">-</button>
                <input type="text" value="${quantity.toFixed(1)}" id="qty-${index}" class="form-control form-control-sm text-center" style="width: 60px;" readonly>
                <button onclick="updateQuantity(${index}, 1)" class="btn btn-outline-secondary btn-sm">+</button>
                </div>
            </td>
            
            <td class="shoping__cart__total">₹${itemTotal.toFixed(2)}</td>
            <td class="shoping__cart__item__close">
                <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">Remove</button>
            </td>
            `;
        cartBody.appendChild(row);
        });

        cartTotal.textContent = total.toFixed(2);
    }

    function updateQuantity(index, change) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const item = cart[index];
        const increment = item.increment || 1;

        let newQty = (item.quantity || 1) + (change * increment);
        if (newQty < increment) newQty = increment;

        item.quantity = parseFloat(newQty.toFixed(1));
        cart[index] = item;
        localStorage.setItem("cart", JSON.stringify(cart));
        loadCartItems();
    }

    function setIncrement(index, value) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart[index].increment = parseFloat(value);
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    function removeItem(index) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        loadCartItems();
    }

    loadCartItems();
    </script>
    <script>
       
        function checkUserLocation() {
            if (!navigator.geolocation) {
            showPincodeModal();
            return;
            }

            navigator.geolocation.getCurrentPosition(success, error);

            function success(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const apiKey = "AIzaSyAug-QPQ5ScQHB_OzuIZsy_zJhjrw_uRFM"; // Replace with your key

                fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`)
                    .then(response => response.json())
                    .then(data => {
                    const components = data.results[0].address_components;
                    let foundLocality = "";

                    for (const comp of components) {
                        if (
                        comp.types.includes("locality") ||
                        comp.types.includes("administrative_area_level_2")
                        ) {
                        foundLocality = comp.long_name.toLowerCase();
                        break;
                        }
                    }

                    if (
                        foundLocality.includes("mettupalayam") ||
                        foundLocality.includes("karamadai")
                    ) {
                        showAlert(`<strong>Delivery available</strong> in your area (${foundLocality})`, "success");
                        localStorage.setItem("locationVerified", "true");
                    } else {
                        // location found but NOT serviceable
                        showPincodeModal();
                    }
                    })
                    .catch(() => {
                    // API error or bad response
                    showPincodeModal();
                    });
            }

            function error() {
            // Location blocked or denied
            showPincodeModal();
            }
        }

        function showAlert(message, type = 'warning') {
            const alertBox = document.getElementById("locationAlert");
            alertBox.className = `alert alert-${type} text-center`;
            alertBox.innerHTML = message;
            alertBox.style.display = "block";

            // Optional: auto-dismiss after 5s
            setTimeout(() => {
            alertBox.style.display = "none";
            }, 5000);
        }

        function showPincodeModal() {
            const modal = new bootstrap.Modal(document.getElementById('pincodeModal'));
            modal.show();
        }

        function verifyPincode() {
            const validPincodes = ['641301', '641302', '641104'];
            const userPin = document.getElementById("pincodeInput").value.trim();
            const errorBox = document.getElementById("pincodeError");

            if (validPincodes.includes(userPin)) {
                errorBox.style.display = "none";

                const modalEl = document.getElementById('pincodeModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                modalInstance.hide();
                }

                // Wait 300ms to allow Bootstrap to finish hiding, then clean up
                setTimeout(() => {
                // Remove modal-open class
                document.body.classList.remove("modal-open");

                // Remove any leftover backdrops
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                // Remove inline overflow styles
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';

                // Set flag to avoid location check again
                localStorage.setItem("locationVerified", "true");

                // Show success message
                showAlert(`<strong>Delivery available</strong> in your area (${userPin})`, "success");
                }, 300);
            } else {
                errorBox.style.display = "block";
            }
        }


        function resetLocationCheck() {
            localStorage.removeItem("locationVerified");
            location.reload();
        }

        window.onload = function () {
            const isLocationChecked = localStorage.getItem("locationVerified");
            if (!isLocationChecked) {
                checkUserLocation();
            }
        };
        

        
    </script>
    <script>
        function renderOrderSummary() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const orderList = document.getElementById("orderItems");
            const subtotalElement = document.getElementById("subtotalAmount");
            const totalElement = document.getElementById("totalAmount");

            orderList.innerHTML = "";
            let subtotal = 0;

            cart.forEach(item => {
                const qty = item.quantity || 1;
                const itemTotal = item.price * qty;

                const li = document.createElement("li");
                li.innerHTML = `${item.name} × ${qty} <span>₹${itemTotal.toFixed(2)}</span>`;
                orderList.appendChild(li);

                subtotal += itemTotal;
            });

            subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
            totalElement.textContent = `₹${subtotal.toFixed(2)}`;
        }

        document.addEventListener("DOMContentLoaded", renderOrderSummary);

    </script>
    <script>
        // Dummy placeholders (replace with real data if available)
        const customerInfo = {
        name: localStorage.getItem('customerName') || "John Doe",
        phone: localStorage.getItem('customerPhone') || "9876543210",
        address: localStorage.getItem('customerAddress') || "123, Main Street, Mettupalayam"
        };

        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        function generateOrderId() {
        return "ORD" + Date.now().toString().slice(-6);
        }

        function renderOrderDetails() {
        document.getElementById("orderId").textContent = generateOrderId();
        document.getElementById("customerName").textContent = customerInfo.name;
        document.getElementById("customerPhone").textContent = customerInfo.phone;
        document.getElementById("customerAddress").textContent = customerInfo.address;

        const itemList = document.getElementById("orderedItemsList");
        let subtotal = 0;

        cart.forEach(item => {
            const quantity = item.quantity || 1;
            const itemTotal = item.price * quantity;
            subtotal += itemTotal;

            const li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `${item.name} × ${quantity} <span>₹${itemTotal.toFixed(2)}</span>`;
            itemList.appendChild(li);
        });

        document.getElementById("subtotal").textContent = subtotal.toFixed(2);
        document.getElementById("total").textContent = subtotal.toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", renderOrderDetails);
    </script>
    <script>
        const devNotice = document.getElementById("devNotice");
        const codSection = document.getElementById("codSection");

        document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
            radio.addEventListener("change", () => {
            const selected = radio.value;
            if (selected === "cod") {
                codSection.classList.remove("d-none");
                devNotice.classList.add("d-none");
            } else {
                devNotice.classList.remove("d-none");
                codSection.classList.add("d-none");
            }
            });
        });

        // Optional form handling
        document.getElementById("paymentForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const selected = document.querySelector("input[name='paymentMethod']:checked").value;
            if (selected === "cod") {
            alert("Order placed with Pay on Delivery.");
            } else {
            alert("Please choose Pay on Delivery to continue.");
            }
        });
    </script>
    <script>
        // Redirect if not logged in
        function checkLoginBeforeCheckout() {
            if (!isLoggedIn) {
                alert("Please log in to continue with the checkout.");
                window.location.href = "./login.php"; // PHP login page
                return false;
            }
            return true;
        }

        // Auto-check on checkout page
        window.onload = function () {
            const onCheckoutPage = window.location.pathname.includes("checkout");
            if (onCheckoutPage) {
                checkLoginBeforeCheckout();
            }
        };
    </script>

    <script>
        const loginForm = document.getElementById("loginForm");
        const alertBox = document.getElementById("loginAlert");

        loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        // Simple validation (replace with server-side validation in production)
        if (username === "admin" && password === "123456") {
            localStorage.setItem("isLoggedIn", "true");
            localStorage.setItem("userName", username);

            // Redirect to homepage or checkout
            window.location.href = "index.html"; // Change to checkout.html if needed
        } else {
            alertBox.textContent = "Invalid credentials. Please try again.";
            alertBox.classList.remove("d-none");
        }
        });
    </script>
  






</body>

</html>