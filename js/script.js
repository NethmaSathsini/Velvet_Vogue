/*COMMON HELPERS*/
function showError(msg) {
    alert(msg);
    return false;
}

/*CUSTOMER LOGIN*/
function validateLogin() {
    const email = document.querySelector("[name='email']").value.trim();
    const password = document.querySelector("[name='password']").value.trim();

    if (email === "") {
        return showError("Email is required");
    }

    if (password === "") {
        return showError("Password is required");
    }

    if (password.length < 6) {
        return showError("Password must be at least 6 characters");
    }

    return true;
}

/*ADMIN LOGIN*/
function validateAdminLogin() {
    const username = document.querySelector("[name='username']").value.trim();
    const password = document.querySelector("[name='password']").value.trim();

    if (username === "") {
        return showError("Admin username is required");
    }

    if (password === "") {
        return showError("Admin password is required");
    }

    if (password.length < 5) {
        return showError("Password is too short");
    }

    return true;
}

/*REGISTER*/
function validateRegister() {
    const name = document.querySelector("[name='name']").value.trim();
    const email = document.querySelector("[name='email']").value.trim();
    const password = document.querySelector("[name='password']").value.trim();

    if (name === "") {
        return showError("Full name is required");
    }

    if (email === "") {
        return showError("Email is required");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        return showError("Enter a valid email address");
    }

    if (password.length < 6) {
        return showError("Password must be at least 6 characters");
    }

    return true;
}

/*ADD PRODUCT*/
function validateProduct() {
    const name = document.querySelector("[name='name']").value.trim();
    const price = document.querySelector("[name='price']").value.trim();
    const image = document.querySelector("[name='image']").value;

    if (name === "") {
        return showError("Product name is required");
    }

    if (price === "" || isNaN(price) || price <= 0) {
        return showError("Enter a valid product price");
    }

    if (image === "") {
        return showError("Please select a product image");
    }

    return true;
}
