@extends('layouts.app')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 mb-8 text-white">
        <h1 class="text-3xl font-bold mb-2">My Profile</h1>
        <p class="text-red-100">Manage your account information</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Information -->
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Account Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Full Name</label>
                <p class="text-lg text-gray-800 font-medium">{{ $user->name }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Email Address</label>
                <p class="text-lg text-gray-800 font-medium">{{ $user->email }}</p>
            </div>

            <!-- Account Type -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Account Type</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($user->user_type === 'Student') bg-blue-100 text-blue-800
                    @elseif($user->user_type === 'Volunteer Counselor') bg-green-100 text-green-800
                    @else bg-purple-100 text-purple-800 @endif">
                    {{ $user->user_type }}
                </span>
            </div>

            <!-- College (Only for Students) -->
            @if($user->user_type === 'Student')
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">College</label>
                <p class="text-lg text-gray-800 font-medium">{{ $user->college ?? 'Not specified' }}</p>
            </div>
            @endif

            <!-- Member Since -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Member Since</label>
                <p class="text-lg text-gray-800 font-medium">{{ $user->created_at->format('F j, Y') }}</p>
            </div>

            <!-- Last Updated -->
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-2">Last Updated</label>
                <p class="text-lg text-gray-800 font-medium">{{ $user->updated_at->format('F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Profile</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-red-600 transition-colors">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-red-600 transition-colors"
                       @if($user->user_type === 'Student') readonly @endif>
                @if($user->user_type === 'Student')
                    <p class="text-sm text-gray-500 mt-1">Student email cannot be changed</p>
                @endif
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- College Field (Only for Students) -->
            @if($user->user_type === 'Student')
            <div class="mb-6">
                <label for="college" class="block text-sm font-medium text-gray-700 mb-2">College</label>
                <select id="college"
                        name="college"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-red-600 transition-colors">
                    <option value="">Select your college</option>
                    <option value="College of Engineering" {{ old('college', $user->college) == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                    <option value="College of Engineering Technology" {{ old('college', $user->college) == 'College of Engineering Technology' ? 'selected' : '' }}>College of Engineering Technology</option>
                    <option value="College of Informatics and Computing Sciences" {{ old('college', $user->college) == 'College of Informatics and Computing Sciences' ? 'selected' : '' }}>College of Informatics and Computing Sciences</option>
                    <option value="College of Architecture Fine Arts and Design" {{ old('college', $user->college) == 'College of Architecture Fine Arts and Design' ? 'selected' : '' }}>College of Architecture Fine Arts and Design</option>
                </select>
                @error('college')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                    Update Profile
                </button>
                <a href="{{ route('dashboard') }}"
                   class="px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
