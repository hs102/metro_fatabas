



document.addEventListener('DOMContentLoaded', function() {
    let searchInput = document.querySelector('#search');
    searchInput.addEventListener('input', function() {
        let query = this.value.toLowerCase();

        let products = document.querySelectorAll('.product-card');

        products.forEach(function(product) {
            let productName = product.textContent.toLowerCase();
            if (productName.includes(query)) {
                product.style.display = 'flex';
            } else {
                product.style.display = 'none';
            }
        });
    });
});




document.addEventListener('DOMContentLoaded', function() {
    let categoryLinks = document.querySelectorAll('li a');
    let products = document.querySelectorAll('.product-card');

    categoryLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
  
        let category = this.textContent;
  
        products.forEach(function(product) {
          if (product.dataset.category === category) {
            product.style.display = 'flex';
          } else {
            product.style.display = 'none';
          }

          if (category === 'All') {
            product.style.display = 'flex';
          }
        });
      });
    });
});