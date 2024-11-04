@extends('layout')

@section('title')
    Data User
@endsection

@section('content')


        <!-- Main Content -->
        <div class="flex-1 p-8 bg-pastel-50">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-forest-600">All users</h1>

                <div class="flex items-center gap-4">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search for users"
                        onkeyup="searchUsers()"
                        class="bg-white border border-pastel-200 text-forest-600 px-4 py-2 rounded-lg focus:outline-none focus:border-forest-500">

                    <a href="{{ route('user.create') }}">
                        <button class="bg-forest-600 hover:bg-forest-500 text-white px-4 py-2 rounded-lg">
                            Add new user
                        </button>
                    </a>
                </div>
            </div>

            <!-- Table (Hijau Muda) -->
            <div class="bg-white rounded-lg shadow-md">
                <table class="w-full">
                    <thead>
                        <tr class="bg-pastel-100 text-forest-600">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Username</th>
                            <th class="py-3 px-6 text-left">Phone Number</th>
                            <th class="py-3 px-6 text-left">Role</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @if ($users->count() != 0)
                            @foreach ($users as $u)
                            <tr class="border-b border-pastel-50 hover:bg-pastel-50">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $u->name }}</td>
                                <td class="py-3 px-6">{{ $u->username }}</td>
                                <td class="py-3 px-6">{{ '+62 ' . ltrim($u->phone_number, '0') }}</td>
                                <td class="py-3 px-6">{{ $u->role }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('address.index', $u->id) }}">
                                            <button class="bg-action-info hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                                Address
                                            </button>
                                        </a>
                                        <a href="{{ route('user.edit', $u->id) }}">
                                            <button class="bg-action-warning hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                                Update
                                            </button>


                                        </a>
                                        <a href="{{ route('user.destroy', $u->id) }}">
                                            <button class="bg-action-danger hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200"
                                                    onClick="return confirm('Ingin hapus user?')">
                                                Delete item
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data</td>
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
