
function updateProduct(product_id, name, price, quantity, category) {
    let params = new URLSearchParams();
    params.append('product_id', product_id);
    params.append('name', name);
    params.append('price', price);
    params.append('quantity', quantity);

    console.log(category);
    params.append('category', category);

    fetch('controllers/update_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(product_id);
}

function deleteProduct(product_id) {
    let params = new URLSearchParams();
    params.append('product_id', product_id);

    fetch('controllers/delete_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(product_id);
}


function updateOrder(order_id,status){
    let params = new URLSearchParams();
    params.append('order_id', order_id);
    params.append('status', status);

    fetch('controllers/update_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(status);

}

function deleteOrder(order_id) {
    let params = new URLSearchParams();
    params.append('order_id', order_id);

    fetch('controllers/delete_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(order_id);
}

function deleteUser(userid) {
    let params = new URLSearchParams();
    params.append('user_id', userid);

    fetch('controllers/delete_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(userid);
}

function updateUserRole(userid, role) {
    let params = new URLSearchParams();
    params.append('user_id', userid);
    params.append('role', role);

    fetch('controllers/update_user_role.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params.toString()
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    console.log(userid);
}