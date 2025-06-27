document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const productos = document.querySelectorAll('.producto');
    const noResults = document.getElementById('noResults');
    const graficos = document.querySelectorAll('.grafico');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const hasSearch = searchTerm.length > 0; // ¿Hay texto en el buscador?
        let hasResults = false;
        
        // Mostrar/ocultar gráficos basado en si hay búsqueda
        graficos.forEach(grafico => {
            grafico.style.display = hasSearch ? 'none' : 'block';
        });
        
        // Filtrar productos
        productos.forEach(producto => {
            const productName = producto.getAttribute('data-name');
            if (productName.includes(searchTerm)) {
                producto.style.display = 'block';
                hasResults = true;
            } else {
                producto.style.display = 'none';
            }
        });
        
        // Manejar mensaje "no results"
        noResults.style.display = (hasSearch && !hasResults) ? 'block' : 'none';
    });
    
    // Opcional: Manejar cuando se limpia el campo con el botón "X" (en algunos navegadores)
    searchInput.addEventListener('search', function() {
        if (this.value === '') {
            graficos.forEach(grafico => grafico.style.display = 'block');
            productos.forEach(producto => producto.style.display = 'block');
            noResults.style.display = 'none';
        }
    });
});