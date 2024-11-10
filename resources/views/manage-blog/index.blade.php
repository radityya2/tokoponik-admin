@extends('layout')

@section('title')
    Data Blog
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Data Blog</li>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="flex-1 p-8 bg-pastel-50">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-forest-700">All Blog Posts</h1>

                <div class="flex items-center space-x-6">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search for blog posts"
                        class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500">

                    <a href="{{ route('blog.create') }}">
                        <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                            Add new post
                        </button>
                    </a>
                </div>
            </div>


            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table id="productTable" class="w-full">
                    <thead>
                        <tr class="bg-forest-500 text-white">
                            <th class="py-4 px-6 text-left font-medium">No</th>
                            <th class="py-4 px-6 text-left font-medium">Title</th>
                            <th class="py-4 px-6 text-left font-medium">Description</th>
                            <th class="py-4 px-6 text-left font-medium">Image</th>
                            <th class="py-4 px-6 text-left font-medium">Link</th>
                            <th class="py-4 px-6 text-left font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody" class="divide-y divide-gray-100">
                        @if ($blogs->count() != 0)
                            @foreach ($blogs as $blog)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6">{{ $blog->title }}</td>
                                <td class="py-4 px-6">{{ $blog->description }}</td>
                                <td class="py-4 px-6">{{ $blog->blog_picture }}</td>
                                <td class="py-4 px-6">{{ $blog->blog_link }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('blog.edit', $blog->id) }}" class="tooltip" title="Edit Blog">
                                            <i class="bi bi-pencil-square text-xl text-forest-500 hover:text-yellow-500 transition duration-200"></i>
                                        </a>
                                        <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  onclick="return confirm('Ingin hapus blog post?')">
                                                <i class="bi bi-trash3-fill text-xl text-red-500 hover:text-red-700 transition duration-200" title="Delete Blog"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">No data exists</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Pastikan jQuery dimuat terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        console.log('jQuery loaded!'); // Untuk debugging

        $("#searchInput").on("keyup", function() {
            console.log('Searching...'); // Untuk debugging

            var value = $(this).val().toLowerCase();
            $("#productTable tbody tr").each(function() {
                var rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.indexOf(value) > -1);
            });
        });
    });
</script>
@endpush
