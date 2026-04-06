<script src="https://cdn.tailwindcss.com"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <!-- Create Form -->
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf

                    <!-- Title Input -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 uppercase mb-2">Title</label>
                        <input type="text" name="title" id="title" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-3 text-gray-700" 
                               placeholder="Enter post title"
                               required>
                    </div>

                    <!-- Content Input -->
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-bold text-gray-700 uppercase mb-2">Content</label>
                        <textarea name="content" id="content" rows="6" 
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border p-3 text-gray-700" 
                                  placeholder="Write your content here..."
                                  required></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3 mt-8">
                        
                        <!-- PRIMARY SAVE BUTTON -->
                        <button type="submit" 
                                style="background-color: #4f46e5;" 
                                class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-md transition">
                            Save Post
                        </button>

                        <!-- SECONDARY CANCEL BUTTON (Visible and Clear) -->
                        <a href="{{ route('posts.index') }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 rounded-md font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            Cancel
                        </a>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>