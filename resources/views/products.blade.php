<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.06);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            outline: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-warning {
            background-color: var(--warning);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .table-row {
            transition: all 0.2s ease;
        }
        
        .table-row:hover {
            background-color: #f8fafc;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 1rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-text);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #cbd5e1;
        }
        
        .notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateX(120%);
            transition: transform 0.3s ease;
            z-index: 1000;
            max-width: 350px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background-color: var(--success);
        }
        
        .notification.error {
            background-color: var(--danger);
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 500px;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #6b7280;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .warning-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .warning-icon i {
            font-size: 3rem;
            color: #f59e0b;
        }

        .success-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .success-icon i {
            font-size: 3rem;
            color: #10b981;
        }
        
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 640px;
            }

            .modal {
                width: 95%;
                margin: 1rem;
            }
        }
    </style>
</head>
<body class="min-h-screen p-4 md:p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Gestión de Productos</h1>
            <p class="text-gray-600">Administra tu inventario de productos de forma sencilla</p>
        </header>

        <!-- Actions Section -->
        <section class="card p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-boxes mr-2 text-blue-500"></i>
                        Lista de Productos
                    </h2>
                </div>
                <button onclick="showCreateModal()" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Producto
                </button>
            </div>
        </section>

        <!-- Products Table -->
        <section class="card p-6">
            <div class="mb-4 flex justify-between items-center">
                <div class="text-sm text-gray-600" id="productCount">
                    Cargando productos...
                </div>
                <button onclick="loadProducts()" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-sync-alt mr-2"></i>Actualizar
                </button>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-3 text-left font-semibold">ID</th>
                            <th class="p-3 text-left font-semibold">Nombre</th>
                            <th class="p-3 text-left font-semibold">Precio</th>
                            <th class="p-3 text-left font-semibold">Descripción</th>
                            <th class="p-3 text-left font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableContent">
                        <!-- Los productos se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
                
                <!-- Empty state -->
                <div id="emptyState" class="empty-state hidden">
                    <i class="fas fa-box-open"></i>
                    <h3 class="text-xl font-medium mb-2">No hay productos</h3>
                    <p class="text-gray-500">Agrega tu primer producto usando el botón "Nuevo Producto".</p>
                </div>

                <!-- Loading state -->
                <div id="loadingState" class="empty-state">
                    <div class="loading mx-auto mb-4" style="width: 40px; height: 40px; border-width: 4px;"></div>
                    <h3 class="text-xl font-medium mb-2">Cargando productos...</h3>
                    <p class="text-gray-500">Por favor espera mientras cargamos los datos.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification">
        <div class="flex items-center">
            <i id="notificationIcon" class="fas fa-check-circle mr-2"></i>
            <span id="notificationMessage">Operación completada con éxito</span>
        </div>
    </div>

    <!-- Create/Edit Product Modal -->
    <div id="productModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="text-lg font-semibold text-gray-800" id="productModalTitle">Agregar Nuevo Producto</h3>
                <button type="button" class="modal-close" onclick="closeProductModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="productForm" class="space-y-4">
                    <input type="hidden" id="productId">
                    
                    <div>
                        <label for="name" class="form-label">Nombre del Producto</label>
                        <input type="text" id="name" class="form-input" placeholder="Ingresa el nombre del producto" required>
                    </div>
                    
                    <div>
                        <label for="price" class="form-label">Precio ($)</label>
                        <input type="number" id="price" step="0.01" min="0" class="form-input" placeholder="0.00" required>
                    </div>
                    
                    <div>
                        <label for="description" class="form-label">Descripción</label>
                        <textarea id="description" rows="3" class="form-input" placeholder="Describe el producto..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400" onclick="closeProductModal()">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="submitProductBtn" onclick="saveProduct()">
                    <i class="fas fa-save mr-2"></i>
                    <span id="submitProductBtnText">Guardar Producto</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="text-lg font-semibold text-gray-800">Confirmar Eliminación</h3>
                <button type="button" class="modal-close" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <p class="text-center text-gray-600 mb-4" id="deleteModalMessage">
                    ¿Estás seguro de que deseas eliminar este producto?
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                        <span class="font-medium text-yellow-800">Esta acción no se puede deshacer</span>
                    </div>
                    <p class="text-sm text-yellow-700">
                        El producto será eliminado permanentemente del sistema.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gray-300 text-gray-700 hover:bg-gray-400" onclick="closeDeleteModal()">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash mr-2"></i>Eliminar Producto
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-body text-center py-8">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2" id="successModalTitle">¡Operación Exitosa!</h3>
                <p class="text-gray-600 mb-6" id="successModalMessage">La operación se completó correctamente.</p>
                <button type="button" class="btn btn-primary" onclick="closeSuccessModal()">
                    <i class="fas fa-check mr-2"></i>Aceptar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Elementos del DOM
        const tableContent = document.getElementById('tableContent');
        const emptyState = document.getElementById('emptyState');
        const loadingState = document.getElementById('loadingState');
        const productCount = document.getElementById('productCount');
        const notification = document.getElementById('notification');
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationMessage = document.getElementById('notificationMessage');
        
        // Modal elements
        const productModal = document.getElementById('productModal');
        const productModalTitle = document.getElementById('productModalTitle');
        const productForm = document.getElementById('productForm');
        const submitProductBtn = document.getElementById('submitProductBtn');
        const submitProductBtnText = document.getElementById('submitProductBtnText');
        
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalMessage = document.getElementById('deleteModalMessage');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        const successModal = document.getElementById('successModal');
        const successModalTitle = document.getElementById('successModalTitle');
        const successModalMessage = document.getElementById('successModalMessage');

        // URL base para las peticiones a la API (ajusta según tu configuración)
        const API_BASE = '/api/products';

        // CSRF Token para Laravel (si estás usando protección CSRF)
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Headers comunes para las peticiones
        const commonHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };

        // Agregar CSRF token si está disponible
        if (CSRF_TOKEN) {
            commonHeaders['X-CSRF-TOKEN'] = CSRF_TOKEN;
        }

        // Variables para los modales
        let productToDelete = null;
        let currentProductId = null;

        // Inicializar la aplicación
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            
            // Configurar eventos de cierre de modales
            setupModalEvents();
        });

        // Configurar eventos para todos los modales
        function setupModalEvents() {
            // Cerrar modales con ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });

            // Cerrar modales haciendo clic fuera del contenido
            const modals = [productModal, deleteModal, successModal];
            modals.forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeAllModals();
                    }
                });
            });

            // Configurar el evento de eliminación cuando se confirma en el modal
            confirmDeleteBtn.addEventListener('click', deleteProduct);
        }

        // Función para cerrar todos los modales
        function closeAllModals() {
            productModal.classList.remove('active');
            deleteModal.classList.remove('active');
            successModal.classList.remove('active');
            productToDelete = null;
            currentProductId = null;
        }

        // Función para mostrar notificación
        function showNotification(message, type = 'success') {
            notification.className = 'notification';
            notification.classList.add(type);
            notification.classList.add('show');
            
            if (type === 'success') {
                notificationIcon.className = 'fas fa-check-circle mr-2';
            } else {
                notificationIcon.className = 'fas fa-exclamation-circle mr-2';
            }
            
            notificationMessage.textContent = message;
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 4000);
        }

        // Función para mostrar/ocultar loading
        function setLoading(loading) {
            if (loading) {
                loadingState.classList.remove('hidden');
                tableContent.innerHTML = '';
                emptyState.classList.add('hidden');
            } else {
                loadingState.classList.add('hidden');
            }
        }

        // Función para mostrar/ocultar botón de loading en submit
        function setSubmitLoading(loading) {
            if (loading) {
                submitProductBtn.disabled = true;
                submitProductBtn.innerHTML = '<div class="loading mr-2"></div><span>Procesando...</span>';
            } else {
                submitProductBtn.disabled = false;
                submitProductBtn.innerHTML = '<i class="fas fa-save mr-2"></i><span id="submitProductBtnText">' + submitProductBtnText.textContent + '</span>';
            }
        }

        // Cargar productos desde la base de datos
        async function loadProducts() {
            setLoading(true);
            
            try {
                const response = await fetch(API_BASE);
                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.error || 'Error al cargar los productos');
                }
                
                if (result.status === 200) {
                    renderProducts(result.data);
                } else {
                    throw new Error(result.error || 'Error en la respuesta del servidor');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al cargar los productos: ' + error.message, 'error');
                renderProducts([]);
            } finally {
                setLoading(false);
            }
        }

        // Mostrar modal para crear producto
        function showCreateModal() {
            currentProductId = null;
            productForm.reset();
            productModalTitle.textContent = 'Agregar Nuevo Producto';
            submitProductBtnText.textContent = 'Guardar Producto';
            productModal.classList.add('active');
        }

        // Mostrar modal para editar producto
        async function showEditModal(id) {
            try {
                const response = await fetch(`${API_BASE}/${id}`);
                const result = await response.json();
                
                if (!response.ok || result.status !== 200) {
                    throw new Error(result.error || 'Error al cargar el producto');
                }
                
                const product = result.data;
                currentProductId = product.id;
                
                document.getElementById('productId').value = product.id;
                document.getElementById('name').value = product.name;
                document.getElementById('price').value = product.price;
                document.getElementById('description').value = product.description || '';
                
                productModalTitle.textContent = 'Editar Producto';
                submitProductBtnText.textContent = 'Actualizar Producto';
                productModal.classList.add('active');
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al cargar el producto: ' + error.message, 'error');
            }
        }

        // Cerrar modal de producto
        function closeProductModal() {
            productModal.classList.remove('active');
            currentProductId = null;
        }

        // Guardar producto (crear o actualizar)
        async function saveProduct() {
            const id = document.getElementById('productId').value;
            const name = document.getElementById('name').value;
            const price = parseFloat(document.getElementById('price').value);
            const description = document.getElementById('description').value;
            
            // Validación básica
            if (!name || !price) {
                showNotification('Por favor completa todos los campos requeridos', 'error');
                return;
            }
            
            const productData = { 
                name, 
                price,
                description 
            };
            
            setSubmitLoading(true);
            
            try {
                let response, result;
                
                if (id) {
                    // Actualizar producto existente
                    response = await fetch(`${API_BASE}/${id}`, {
                        method: 'PUT',
                        headers: commonHeaders,
                        body: JSON.stringify(productData)
                    });
                    
                    result = await response.json();
                    
                    if (!response.ok || result.status !== 200) {
                        throw new Error(result.error || 'Error al actualizar el producto');
                    }
                    
                    showSuccessModal('Producto Actualizado', 'El producto se ha actualizado correctamente.');
                } else {
                    // Crear nuevo producto
                    response = await fetch(API_BASE, {
                        method: 'POST',
                        headers: commonHeaders,
                        body: JSON.stringify(productData)
                    });
                    
                    result = await response.json();
                    
                    if (!response.ok || result.status !== 200) {
                        throw new Error(result.error || 'Error al crear el producto');
                    }
                    
                    showSuccessModal('Producto Creado', 'El producto se ha creado correctamente.');
                }
                
                closeProductModal();
                loadProducts(); // Recargar la lista de productos
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al guardar el producto: ' + error.message, 'error');
            } finally {
                setSubmitLoading(false);
            }
        }

        // Mostrar modal de confirmación para eliminar
        function showDeleteModal(id, name) {
            productToDelete = { id, name };
            deleteModalMessage.innerHTML = `
                ¿Estás seguro de que deseas eliminar el producto 
                <strong>"${name}"</strong>?
            `;
            deleteModal.classList.add('active');
        }

        // Cerrar modal de eliminación
        function closeDeleteModal() {
            deleteModal.classList.remove('active');
            productToDelete = null;
        }

        // Eliminar producto (confirmado desde el modal)
        async function deleteProduct() {
            if (!productToDelete) return;
            
            const { id, name } = productToDelete;
            
            try {
                const response = await fetch(`${API_BASE}/${id}`, {
                    method: 'DELETE',
                    headers: commonHeaders
                });
                
                const result = await response.json();
                
                if (!response.ok || result.status !== 200) {
                    throw new Error(result.error || 'Error al eliminar el producto');
                }
                
                showSuccessModal('Producto Eliminado', `El producto "${name}" ha sido eliminado correctamente.`);
                loadProducts(); // Recargar la lista de productos
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al eliminar el producto: ' + error.message, 'error');
            } finally {
                closeDeleteModal();
            }
        }

        // Mostrar modal de éxito
        function showSuccessModal(title, message) {
            successModalTitle.textContent = title;
            successModalMessage.textContent = message;
            successModal.classList.add('active');
        }

        // Cerrar modal de éxito
        function closeSuccessModal() {
            successModal.classList.remove('active');
        }

        // Renderizar la tabla de productos
        function renderProducts(products) {
            if (!products || products.length === 0) {
                tableContent.innerHTML = '';
                emptyState.classList.remove('hidden');
                productCount.textContent = 'No hay productos registrados';
                return;
            }
            
            emptyState.classList.add('hidden');
            productCount.textContent = `${products.length} producto(s) encontrado(s)`;
            
            let html = '';
            products.forEach(product => {
                html += `
                    <tr class="table-row border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-3 text-gray-700 font-mono">${product.id}</td>
                        <td class="p-3 font-medium text-gray-800">${product.name}</td>
                        <td class="p-3 text-gray-700 font-semibold">$${parseFloat(product.price).toFixed(2)}</td>
                        <td class="p-3 text-gray-600 max-w-xs">${product.description || '<span class="text-gray-400">Sin descripción</span>'}</td>
                        <td class="p-3">
                            <div class="flex space-x-2">
                                <button onclick="showEditModal(${product.id})" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </button>
                                <button onclick="showDeleteModal(${product.id}, '${product.name.replace(/'/g, "\\'")}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash mr-1"></i>Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tableContent.innerHTML = html;
        }
    </script>
</body>
</html>