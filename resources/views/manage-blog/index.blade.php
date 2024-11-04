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
        <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-forest-600">All Blog Posts</h1>

                <div class="flex items-center gap-4">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search for blog posts"
                        class="bg-white border border-pastel-200 text-forest-600 px-4 py-2 rounded-lg focus:outline-none focus:border-forest-500">

                    <a href="{{ route('blog.create') }}">
                        <button class="bg-forest-600 hover:bg-forest-500 text-white px-4 py-2 rounded-lg">
                            Add new post
                        </button>
                    </a>
                </div>
            </div>


            <div class="overflow-x-auto">
                <table id="productTable" class="w-full">
                    <thead class="bg-green-200/50">
                    <tr class="bg-pastel-100 text-forest-600">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Title</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Image</th>
                            <th class="py-3 px-6 text-left">Link</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if ($blogs->count() != 0)
                            @foreach ($blogs as $blog)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $blog->title }}</td>
                                <td class="py-3 px-6">{{ $blog->description }}</td>
                                <td class="py-3 px-6">{{ $blog->blog_picture }}</td>
                                <td class="py-3 px-6">{{ $blog->blog_link }}</td>
                                <td class="py-3 px-6 ">
                                    <div class="flex gap-2">
                                        <a href="{{ route('blog.edit', $blog->id) }}">
                                            <button class="w-24 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                                Update
                                            </button>
                                        </a>
                                        <a href="{{ route('blog.destroy', $blog->id) }}">
                                            <button class="w-24 bg-action-danger hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200"
                                                    onClick="return confirm('Ingin hapus blog post?')">
                                                Delete
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center p-4 bg-green-50">Tidak ada data blog</td>
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
