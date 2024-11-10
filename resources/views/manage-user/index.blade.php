@extends('layout')

@section('title')
    Data User
@endsection

@section('content')


        <!-- Main Content -->
        <div class="flex-1 p-8 bg-pastel-50">
            <!-- Header dengan spacing yang lebih baik -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-forest-700">All Users</h1>

                <div class="flex items-center space-x-6">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search for users"
                        onkeyup="searchUsers()"
                        class="bg-white border border-pastel-200 text-forest-600 px-5 py-2.5 rounded-lg focus:outline-none focus:border-forest-500 focus:ring-2 focus:ring-forest-200 transition-all duration-200">

                    <a href="{{ route('user.create') }}">
                        <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-sm hover:shadow-md">
                            Add new user
                        </button>
                    </a>
                </div>
            </div>

            <!-- Table dengan shadow dan border yang lebih halus -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table id="userTable" class="w-full">
                    <thead>
                        <tr class="bg-forest-500 text-white">
                            <th class="py-4 px-6 text-left font-medium">No</th>
                            <th class="py-4 px-6 text-left font-medium">Name</th>
                            <th class="py-4 px-6 text-left font-medium">Username</th>
                            <th class="py-4 px-6 text-left font-medium">Phone Number</th>
                            <th class="py-4 px-6 text-left font-medium">Role</th>
                            <th class="py-4 px-6 text-left font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="divide-y divide-gray-100">
                        @if ($users->count() != 0)
                            @foreach ($users as $u)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 text-sm">
                                <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6">{{ $u->name }}</td>
                                <td class="py-4 px-6">{{ $u->username }}</td>
                                <td class="py-4 px-6">{{ '+62 ' . ltrim($u->phone_number, '0') }}</td>
                                <td class="py-4 px-6">{{ $u->role }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('address.index', $u->id) }}" class="text-blue-500 hover:text-blue-800 transition duration-200" title="View Address">
                                            <i class="bi bi-house-gear-fill text-xl"></i>
                                        </a>

                                        <a href="{{ route('user.edit', $u->id) }}"
                                        class="text-forest-500 hover:text-yellow-500 transition duration-200"
                                        title="Edit User">
                                            <i class="bi bi-pencil-square text-xl"></i>
                                        </a>

                                        <a href="{{ route('user.destroy', $u->id) }}"
                                        onclick="return confirm('Ingin hapus user?')"
                                        class="text-red-500 hover:text-red-700 transition duration-200"
                                        title="Delete User">
                                            <i class="bi bi-trash3-fill text-xl"></i>
                                        </a>
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

{{-- Tambahkan script di bagian bawah file --}}
<script>
function searchUsers() {
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    let tbody = document.getElementById('userTableBody');
    let tr = tbody.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName('td')[1]; // kolom nama
        if (tdName) {
            let txtValue = tdName.textContent || tdName.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
</script>
