@extends('layouts.app')

@section('content')
<div style="padding: 40px 20px;">
    <div style="margin-bottom: 30px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" name="title" placeholder="Enter list title..." style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description</label>
            <textarea name="description" rows="2" placeholder="Describe your shopping list..." style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Priority</label>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <label style="display: inline-flex; align-items: center; gap: 5px;">
                    <input type="radio" name="priority" value="1" style="cursor: pointer;">
                    <span style="font-size: 12px; color: #dc3545;">High</span>
                </label>
                <label style="display: inline-flex; align-items: center; gap: 5px;">
                    <input type="radio" name="priority" value="2" checked style="cursor: pointer;">
                    <span style="font-size: 12px; color: #ffc107;">Medium</span>
                </label>
                <label style="display: inline-flex; align-items: center; gap: 5px;">
                    <input type="radio" name="priority" value="3" style="cursor: pointer;">
                    <span style="font-size: 12px; color: #28a745;">Low</span>
                </label>
            </div>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Due Date (Optional)</label>
            <input type="date" name="due_date" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
    </div>
    
    <div style="margin-top: 20px; text-align: right;">
        <a href="{{ route('admin.shopping-list.index') }}
           style="padding: 10px 20px; background: white; border: 1px solid #ccc; color: #333; text-decoration: none; border-radius: 4px; cursor: pointer;">
            Cancel
        </a>
        <button type="submit" form="create-shopping-list-form"
                style="padding: 10px 20px; background: #1976d2; color: white; border: none; border-radius: 4px; cursor: pointer; height: 40px; margin-left: 10px; margin-top: -40px;">
            Create Shopping List
        </button>
    </div>
</div>
@endsection