@extends('layouts.app')

@section('title', 'Shopping List')
@section('content')
<div style="padding: 20px;">
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 style="margin: 0;">{{ $list->title }}</h2>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.shopping-list.edit', $list->id) }}" class="btn" style="background: #fff; border: 1px solid #ccc; padding: 5px 10px; text-decoration: none; border-radius: 3px;">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.shopping-list.mark-complete', $list->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="background: #27ae60; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: {{ $list->is_completed ? 'default' : 'pointer' }};" {{ $list->is_completed ? 'disabled' : '' }}>
                            Complete List
                        </button>
                    </form>
                    <button form="{{ route('admin.shopping-list.destroy', $list->id) }}" method="POST" class="btn" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;" data-confirm="Are you sure?">
                        Delete
                    </button>
                    @csrf
                </div>
            </div>

            @if($list->is_completed)
                <div style="padding: 10px; background: #f0f0f0; border-left: 4px solid #27ae60; border-radius: 3px;">
                    <span style="color: #27ae60; font-weight: 600;">✓ Complete</span>
                    
                    @if($list->completed_at)
                        <span style="margin-left: 10px; color: #6c757d;">Completed: {{ $list->completed_at->format('M d, Y h:i A') }}</span>
                    @endif
                </div>
            @else
                <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                    @if($list->priority === 'high')
                        <span style="background: #dc3545; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px;">High Priority</span>
                    @elseif($list->priority === 'medium')
                        <span style="background: #ffc107; color: #212529; padding: 3px 8px; border-radius: 3px; font-size: 11px;">Medium Priority</span>
                    @else
                        <span style="background: #28a745; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px;">Low Priority</span>
                    @endif
                    
                    @if($list->due_date)
                        <span style="background: #ffc107; color: #212529; padding: 3px 8px; border-radius: 3px; font-size: 11px;">📅 Due: {{ $list->due_date }}</span>
                    @endif
                </div>
            @endif
            
            @if($list->description)
                <p style="margin: 0; color: #6c757d;">{{ $list->description }}</p>
            @endif

            <div style="background: white; border: 1px solid #dee2e6; border-radius: 5px; padding: 15px;">
                <div class="items-table">
                    @foreach($items as $itemData)
                        @php
                            $product = $items['products'][$itemData['product_id']] ?? null;
                            $checked = $itemData['checked'] ?? false;
                            $brand = $items['brands'][$itemData['product_id']] ?? null;
                        @endphp
                        <div class="items-list-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: {{ $checked ? '#f8f9fa' : 'white' }; border-radius: 3px; border-left: 3px solid {{ $checked ? '#27ae60' : 'transparent' }; }}, margin-bottom: 8px; opacity: {{ $checked ? '1' : '1' }};">
                            <input type="checkbox" name="items[{{ $itemData['product_id'] }}][checked]" 
                                   {{ $checked ? 'checked' : '' }}
                                   class="item-checkbox"
                                   value="{{ $itemData['product_id'] }}"
                                   data-list="{{ $list->id }}">
                            <div style="flex: 1;">
                                <span style="font-size: 14px;">{{ $itemData['name'] ?? 'N/A' }}</span>
                                @if($product)
                                    <span style="font-size: 12px; color: #888;">({{ $itemData['units'] ?? $product->units }})</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        @if(!empty($items['products']))
        <div style="width: 300px;">
            <h4 style="margin-bottom: 10px;">Product Catalog</h4>
            <div class="product-grid" style="display: grid; gap: 8px;">
                @foreach($items['products'] as $productId => $product)
                @if($items['items'] && $items['items'][$productId]) continue; @endif
                
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px; background: #f8f9fa; border-radius: 3px; transition: background 0.2s;">
                    <input type="checkbox" name="items[{{ $productId }}]" 
                           value="{{ $product['id'] }}"
                           class="brand-check"
                           data-brand="{{ $items['brands'][$product['id']] ?? null }}"
                           data-product="{{ json_encode($product) }}"
                           style="width: auto; margin-right: 5px;">
                    <span style="font-size: 14px;">{{ $product['name'] }}</span>
                    <span style="font-size: 12px; color: #888; margin-left: 4px;">{{ $product['units'] ?? 'N/A' }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('.item-checkbox').forEach(function(cb) {
    cb.addEventListener('change', function(e) {
        const listId = e.target.dataset.list;
        const checkbox = e.target;
        const listItems = document.querySelectorAll('.items-list-item[data-list="' + listId + '"]');
        
        const allChecked = Array.from(listItems).every(function(item) {
            return item.querySelector('.item-checkbox').checked;
        });
        
        const noneChecked = Array.from(listItems).every(function(item) {
            return !item.querySelector('.item-checkbox').checked;
        });
        
        if (allChecked) {
            const firstCheckbox = listItems[0].querySelector('.item-checkbox');
            firstCheckbox.checked = false;
            firstCheckbox.style.display = 'none';
        } else if (noneChecked) {
            const firstCheckbox = listItems[0].querySelector('.item-checkbox');
            firstCheckbox.checked = true;
            firstCheckbox.style.display = 'block';
        } else {
            document.querySelectorAll('.item-checkbox').forEach(function(cb) {
                cb.style.display = 'block';
            });
        }
    });
});
</script>
@endpush
@endsection