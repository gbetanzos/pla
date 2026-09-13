// Toggle item checkbox state handler
document.querySelectorAll('.items-list-item-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var productId = this.dataset.productId;
        var checked = this.checked;
        var row = this.closest('.items-list-item');

        if (!productId) return;

        fetch('/shopping-list/{{ $list->id }}/toggle-item', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({
                item_id: productId,
                checked: checked,
            }),
        }).then(function(response) {
            return response.json();
        }).then(function(data) {
            if (data.success) {
                row.classList.toggle('completed', checked);
            } else {
                alert('Error toggling item');
            }
        }).catch(function(err) {
            console.error(err);
        });
    });
});
