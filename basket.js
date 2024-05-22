
function addtoBasket(id, userid) {
    fetch('controllers/add_to_Basket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&userid=' + userid,
    })

    
    .then(response => response.text())
    .then(data => {
        console.log(data)
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
        
    });

    console.log(id + " " + userid);
}


function removeFromBasket(id, userid) {
    fetch('controllers/remove_from_Basket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&userid=' + userid,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data)
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


function clearBasket(userid) {
    fetch('controllers/clear_Basket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'userid=' + userid,
    })
    .then(response => response.text())
    .then(data => {
        console.log(data)
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function placeorder() {
    fetch('controllers/place_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
    .then(response => response.text())
    .then(data => {
        console.log(data)
        window.location.reload();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

