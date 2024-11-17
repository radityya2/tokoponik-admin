@extends('layout')

@section('title')
Edit Address
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Edit Address</li>
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-gray-200 mb-6">
            <p class="text-gray-800 text-2xl font-bold mb-3">Form Edit Address</p>
        </div>
        <form id="addressForm" action="javascript:void(0)" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="receiver_name">Receiver Name</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="receiver_name" name="receiver_name">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="address">Address</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="address" name="address">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="note">Note</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="note" name="note">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="province">Province</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="province" name="province">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="district">District</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="district" name="district">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="subdistrict">Subdistrict</label>
                <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="subdistrict" name="subdistrict">
            </div>

            <div class="mb-6">
                <label class="block text-gray-800 text-sm font-semibold mb-3" for="postcode">Postcode</label>
                <input type="number" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                    id="postcode" name="postcode">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex items-center px-6 py-2.5 bg-green-800 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <button type="button" onclick="window.history.back()" class="flex items-center px-6 py-2.5 bg-red-700 text-white rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </button>
            </div>
        </form>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Ambil ID dari URL
    const pathArray = window.location.pathname.split('/');
    const addressId = pathArray[2]; // Mengambil ID dari URL /address/{id}/edit
    let userId; // Deklarasi userId untuk digunakan nanti

    // Fetch data alamat yang akan diedit
    $.ajax({
        type: 'GET',
        url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/addresses/${addressId}`,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: function(response) {
            // Simpan user_id dari response
            userId = response.data.user_id;

            // Isi form dengan data yang ada
            $('#receiver_name').val(response.data.receiver_name);
            $('#address').val(response.data.address);
            $('#note').val(response.data.note);
            $('#province').val(response.data.province);
            $('#district').val(response.data.district);
            $('#subdistrict').val(response.data.subdistrict);
            $('#postcode').val(response.data.post_code);
        },
        error: function(xhr) {
            console.log('Error:', xhr);
            Swal.fire({
                title: 'Error!',
                text: 'Gagal mengambil data alamat',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    $('#addressForm').on('submit', function(e) {
        e.preventDefault();

        let formData = {
            receiver_name: $('#receiver_name').val(),
            address: $('#address').val(),
            note: $('#note').val(),
            province: $('#province').val(),
            district: $('#district').val(),
            subdistrict: $('#subdistrict').val(),
            post_code: $('#postcode').val()
        };

        $.ajax({
            type: 'POST',
            url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/addresses/${addressId}/update`,
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Address has been successfully updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/address/${userId}`;
                    }
                });
            },
            error: function(xhr) {
                console.log('Error:', xhr);

                // Hapus pesan error sebelumnya
                $('.text-red-500').remove();
                $('.border-red-500').removeClass('border-red-500');

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(`#${key}`).addClass('border-red-500');
                        $(`#${key}`).after(`<p class="text-red-500 text-xs mt-1">${value[0]}</p>`);
                    });
                }

                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memperbarui alamat',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
