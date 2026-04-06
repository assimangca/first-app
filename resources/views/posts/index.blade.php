<!-- 1. Include SweetAlert & UI Scripts at the VERY TOP -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- 2. Define the Delete Function FIRST -->
<script>
    window.confirmDelete = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This post will be deleted forever!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the specific form and submit it
                const form = document.getElementById('delete-form-' + id);
                if (form) {
                    form.submit();
                } else {
                    alert('Error: Form not found for ID ' + id);
                }
            }
        });
    }
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Posts') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen" x-data="{ openCreateModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <!-- Create Post Button -->
                <div class="mb-8">
                    <button @click="openCreateModal = true"
                       style="background-color: #4f46e5;" 
                       class="inline-flex items-center px-4 py-2 text-white rounded-md font-bold uppercase text-xs shadow-md hover:opacity-90">
                        Create Post
                    </button>
                </div>

                <!-- CREATE MODAL -->
                <template x-teleport="body">
                    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4" x-cloak>
                        <div @click.away="openCreateModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h2 class="text-lg font-bold text-gray-800 uppercase">Create New Post</h2>
                            </div>
                            <form action="{{ route('posts.store') }}" method="POST" class="p-6">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Title</label>
                                    <input type="text" name="title" required class="w-full border border-gray-300 rounded-md p-2.5">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Content</label>
                                    <textarea name="content" rows="5" required class="w-full border border-gray-300 rounded-md p-2.5"></textarea>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="submit" style="background-color: #4f46e5;" class="px-6 py-2.5 text-white text-xs font-bold rounded uppercase">Save Post</button>
                                    <button type="button" @click="openCreateModal = false" class="px-6 py-2.5 border border-gray-300 text-gray-700 text-xs font-bold rounded uppercase">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>

                <!-- Table -->
                <div class="border border-gray-100 rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Content</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase pl-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($posts as $post)
                                <tr class="hover:bg-gray-50" x-data="{ openEditModal: false }">
                                    <td class="px-6 py-5 text-sm text-gray-900">{{ $post->title }}</td>
                                    <td class="px-6 py-5 text-sm text-gray-600">{{ $post->content }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium pl-24">
                                        <div class="flex items-center gap-2">
                                            
                                            <!-- EDIT -->
                                            <button @click="openEditModal = true" style="background-color: #eab308;" class="w-20 h-9 text-white text-xs font-bold rounded uppercase">Edit</button>

                                            <!-- DELETE (Look closely at ID and Onclick) -->
                                            <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('{{ $post->id }}')" 
                                                        style="background-color: #dc2626;" 
                                                        class="w-20 h-9 text-white text-xs font-bold rounded uppercase">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>

                                        <!-- EDIT MODAL -->
                                        <template x-teleport="body">
                                            <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4" x-cloak>
                                                <div @click.away="openEditModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden">
                                                    <div class="p-6 border-b border-gray-100">
                                                        <h2 class="text-lg font-bold text-gray-800 uppercase">Edit Post</h2>
                                                    </div>
                                                    <form action="{{ route('posts.update', $post) }}" method="POST" class="p-6">
                                                        @csrf @method('PUT')
                                                        <div class="mb-5">
                                                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Title</label>
                                                            <input type="text" name="title" value="{{ $post->title }}" class="w-full border border-gray-300 rounded-md p-2.5">
                                                        </div>
                                                        <div class="mb-6">
                                                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Content</label>
                                                            <textarea name="content" rows="5" class="w-full border border-gray-300 rounded-md p-2.5">{{ $post->content }}</textarea>
                                                        </div>
                                                        <div class="flex items-center gap-3">
                                                            <button type="submit" style="background-color: #4f46e5;" class="px-6 py-2.5 text-white text-xs font-bold rounded uppercase">Update</button>
                                                            <button type="button" @click="openEditModal = false" class="px-6 py-2.5 border border-gray-300 text-gray-700 text-xs font-bold rounded uppercase">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400">No posts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $posts->links() }}</div>
            </div>
        </div>
    </div>

    <!-- 3. Final Script for Success Alerts -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
            });
        @endif
    </script>
</x-app-layout>

<style> [x-cloak] { display: none !important; } </style>