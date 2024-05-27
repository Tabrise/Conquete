// public/js/drag-and-drop.js

document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.getElementById('accordion');
    if (!accordion) {
        console.error('Accordion element not found');
        return;
    }

    let draggedItem = null;

    accordion.addEventListener('dragstart', function(event) {
        const target = event.target.closest('.accordion-item');
        if (target) {
            draggedItem = target;
            event.target.style.opacity = 0.5;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/html', draggedItem.outerHTML);
        }
    });

    accordion.addEventListener('dragend', function(event) {
        event.target.style.opacity = "";
    });

    accordion.addEventListener('dragover', function(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        return false;
    });

    accordion.addEventListener('dragenter', function(event) {
        const item = event.target.closest('.accordion-item');
        if (item && item !== draggedItem) {
            item.style.background = "lightgray";
        }
    });

    accordion.addEventListener('dragleave', function(event) {
        const item = event.target.closest('.accordion-item');
        if (item && item !== draggedItem) {
            item.style.background = "";
        }
    });

    accordion.addEventListener('drop', function(event) {
        event.preventDefault();
        const targetItem = event.target.closest('.accordion-item');
        if (targetItem && targetItem !== draggedItem) {
            targetItem.style.background = "";
            const rect = targetItem.getBoundingClientRect();
            const y = event.clientY - rect.top;
            if (y > rect.height / 2) {
                accordion.insertBefore(draggedItem, targetItem.nextSibling);
            } else {
                accordion.insertBefore(draggedItem, targetItem);
            }
        }
        return false;
    });

    const saveOrderBtn = document.getElementById('save-order-btn');
    if (!saveOrderBtn) {
        console.error('Save Order button not found');
        return;
    }

    saveOrderBtn.addEventListener('click', function() {
        let order = [];
        document.querySelectorAll('.accordion-item').forEach(function(item) {
            order.push(item.dataset.id);
        });

        fetch(saveOrderBtn.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ order: order })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Order updated') {
                alert('Order updated successfully!');
            } else {
                alert('An error occurred while updating the order back.');
            }
        })
        .catch(error => {
            alert('An error occurred while updating the order front.');
        });
    });
});
