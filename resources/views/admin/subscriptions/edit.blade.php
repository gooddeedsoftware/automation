@extends('layouts.admin')

@section('title', 'Edit Subscription')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Subscription</h3>
    </div>
    <div class="border-t border-gray-200">
        <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $subscription->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="plan" class="block text-sm font-medium text-gray-700">Plan</label>
                <select name="plan" id="plan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Plan</option>
                    <option value="basic" {{ $subscription->plan === 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="premium" {{ $subscription->plan === 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="enterprise" {{ $subscription->plan === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="active" {{ $subscription->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $subscription->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="expired" {{ $subscription->status === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ $subscription->start_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ $subscription->end_date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.subscriptions.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 mr-2">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
