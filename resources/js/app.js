const apiUrl = '/api/products';

// Cargar productos al iniciar
window.loadProducts = function () {
    axios.get(apiUrl).then(res => {
        let rows = '';
        res.data.data.forEach(product => {
            rows += `
                <tr class="border-b">
                    <td class="p-2">${product.id}</td>
                    <td class="p-2">${product.name}</td>
                    <td class="p-2">${product.price}</td>
                    <td class="p-2">${product.description}</td>
                    <td class="p-2">
                        <button onclick="editProduct(${product.id})" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
                        <button onclick="deleteProduct(${product.id})" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                    </td>
                </tr>
            `;
        });
        document.getElementById('tableContent').innerHTML = rows;
    }).catch(err => console.log(err));
};

// Crear o actualizar producto
document.getElementById('productForm').addEventListener('submit', e => {
    e.preventDefault();

    let id = document.getElementById('productId').value;
    let product = {
        name: document.getElementById('name').value,
        price: document.getElementById('price').value,
        description: document.getElementById('description').value,
    };

    if (id) {
        axios.put(`${apiUrl}/${id}`, product).then(() => {
            loadProducts();
            e.target.reset();
            document.getElementById('productId').value = '';
        });
    } else {
        axios.post(apiUrl, product).then(() => {
            loadProducts();
            e.target.reset();
        });
    }
});

// Editar
window.editProduct = function (id) {
    axios.get(`${apiUrl}/${id}`).then(res => {
        const data = res.data.data[0];
        document.getElementById('productId').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('price').value = data.price;
        document.getElementById('description').value = data.description;
    });
};

// Eliminar
window.deleteProduct = function (id) {
    if (confirm('¿Seguro que quieres eliminar este producto?')) {
        axios.delete(`${apiUrl}/${id}`).then(() => loadProducts());
    }
}

// Ejecutar cuando cargue la página
window.onload = loadProducts;
