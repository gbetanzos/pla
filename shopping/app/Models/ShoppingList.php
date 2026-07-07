<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'notes',
        'items',
        'is_completed',
        'completed_at'
    ];

    protected $casts = [
        'items' => 'array',
        'is_completed' => 'boolean',
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    protected $appends = ['completed_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toggleComplete()
    {
        $this->update([
            'is_completed' => !$this->is_completed,
            'completed_at' => now()
        ]);
    }

    public function completeItems(array $checkedItemIndices)
    {
        $items = is_array($this->items) ? $this->items : [];
        $updatedItems = [];
        foreach ($items as $index => $item) {
            if (isset($checkedItemIndices[$index])) {
                $item['checked'] = true;
            }
            $updatedItems[] = $item;
        }
        $this->update(['items' => $updatedItems]);
    }

    public function getCompletedPercentageAttribute()
    {
        $items = is_array($this->items) ? $this->items : [];
        if (empty($items)) {
            return '0%';
        }
        $checked = collect($items)->filter(fn($i) => $i['checked'] ?? false)->count();
        return (int)round($checked / count($items) * 100) . '%';
    }
}
