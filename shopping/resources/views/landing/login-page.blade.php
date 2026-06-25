@extends('layouts.app')

@section('title', 'Login')
@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 30px;">
    <h1 style="margin-bottom: 10px;">Welcome</h1>
    <p style="color: #666; margin-bottom: 30px;">This is a simple shopping list app. No login required.</p>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; border-left: 4px solid #28a745;">
        <h3 style="margin-top: 0;">Getting Started</h3>
        <ol style="padding-left: 20px;">
            <li>Create a new shopping list</li>
            <li>Add products from the catalog</li>
            <li>Check items off as you shop</li>
        </ol>
    </div>
    
    <a href="{{ route('shopping-list.create') }}" 
       class="btn btn-primary" 
       style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 5px; margin-top: 30px; text-decoration: none; color: white;">
        + Create Your First Shopping List
    </a>
    
    <p style="margin-top: 30px; color: #999; font-size: 13px;">
        Already have lists? <a href="{{ route('landing') }}">View all shopping lists</a>
    </p>
</div>
@endsection
