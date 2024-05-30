document.addEventListener('DOMContentLoaded', function() {
    function setupDragAndDrop(containerSelector, itemSelector) {
        const container = document.querySelector(containerSelector);
        if (!container) {
            console.error('Container element not found:', containerSelector);
            return;
        }

        let draggedItem = null;

        container.addEventListener('dragstart', function(event) {
            const target = event.target.closest(itemSelector);
            if (target) {
                draggedItem = target;
                event.target.style.opacity = 0.5;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/html', draggedItem.outerHTML);
            }
        });

        container.addEventListener('dragend', function(event) {
            event.target.style.opacity = "";
        });

        container.addEventListener('dragover', function(event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
            return false;
        });

        container.addEventListener('dragenter', function(event) {
            const item = event.target.closest(itemSelector);
            if (item && item !== draggedItem) {
                item.style.background = "lightgray";
            }
        });

        container.addEventListener('dragleave', function(event) {
            const item = event.target.closest(itemSelector);
            if (item && item !== draggedItem) {
                item.style.background = "";
            }
        });

        container.addEventListener('drop', function(event) {
            event.preventDefault();
            const item = event.target.closest(itemSelector);
            if (item && item !== draggedItem) {
                item.style.background = "";
                const rect = item.getBoundingClientRect();
                const y = event.clientY - rect.top;
                if (y > rect.height / 2) {
                    container.insertBefore(draggedItem, item.nextSibling);
                } else {
                    container.insertBefore(draggedItem, item);
                }
            }
            return false;
        });
    }

    // Setup drag-and-drop for themes
    setupDragAndDrop('#accordion', '.accordion-item');

    // Setup drag-and-drop for questions in each theme
    document.querySelectorAll('.questions-container').forEach(container => {
        const themeId = container.dataset.themeId;
        setupDragAndDrop(`.questions-container[data-theme-id="${themeId}"]`, '.question-item');
    });

    const saveOrderBtn = document.getElementById('save-order-btn');
    if (!saveOrderBtn) {
        console.error('Save Order button not found');
        return;
    }

    saveOrderBtn.addEventListener('click', function() {
        let themeOrder = [];
        document.querySelectorAll('.accordion-item').forEach(function(item) {
            themeOrder.push(item.dataset.id);
        });

        let questionOrders = {};
        document.querySelectorAll('.questions-container').forEach(function(container) {
            let themeId = container.dataset.themeId;
            let order = [];
            container.querySelectorAll('.question-item').forEach(function(item) {
                order.push(item.dataset.id);
            });
            questionOrders[themeId] = order;
        });

        fetch(saveOrderBtn.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ themeOrder: themeOrder, questionOrders: questionOrders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Order updated') {
                alert('Ordre enregistré');
            } else {
                alert('Il y a eu une erreur interne');
            }
        })
        .catch(error => {
            alert('Il y a eu une erreur interne');
        });
    });
});