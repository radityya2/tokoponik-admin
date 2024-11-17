@extends('layout')

@section('title')
    Create New Address
@endsection

@section('content')
<div class="bg-green-50 rounded-lg shadow-md p-8">
    <div class="border-b border-gray-200 mb-6">
        <p class="text-gray-800 text-2xl font-bold mb-3">Form Add Address</p>
    </div>
    <form id="createAddressForm">
        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="receiver_name">Receiver Name</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="receiver_name" name="receiver_name" required>
            <p id="receiver_name-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="address">Address</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="address" name="address" required>
            <p id="address-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="note">Note</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="note" name="note">
            <p id="note-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="province">Province</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="province" name="province" required>
            <p id="province-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="district">District</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="district" name="district" required>
            <p id="district-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="subdistrict">Subdistrict</label>
            <input type="text" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="subdistrict" name="subdistrict" required>
            <p id="subdistrict-error" class="text-red-500 text-xs mt-1"></p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-800 text-sm font-semibold mb-3" for="postcode">Postcode</label>
            <input type="number" class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                id="postcode" name="postcode" required>
            <p id="postcode-error" class="text-red-500 text-xs mt-1"></p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const userId = window.location.pathname.split('/')[3];
    const token = localStorage.getItem('token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    $('#createAddressForm').on('submit', function(e) {
        e.preventDefault();

        // Reset error messages
        $('.text-red-500').text('');
        $('input').removeClass('border-red-500');

        const formData = {
            user_id: userId,
            receiver_name: $('#receiver_name').val(),
            address: $('#address').val(),
            note: $('#note').val() || '-', // Memberikan default value karena required di API
            province: $('#province').val(),
            district: $('#district').val(),
            subdistrict: $('#subdistrict').val(),
            post_code: $('#postcode').val() // Mengubah nama field sesuai API
        };

        // Validasi client-side
        let isValid = true;
        const requiredFields = ['receiver_name', 'address', 'province', 'district', 'subdistrict', 'post_code'];

        requiredFields.forEach(field => {
            const value = formData[field];
            if (!value || value.trim() === '') {
                isValid = false;
                const displayField = field.replace('_', ' ');
                $(`#${field === 'post_code' ? 'postcode' : field}`).addClass('border-red-500');
                $(`#${field === 'post_code' ? 'postcode' : field}-error`).text(`${displayField} wajib diisi`);
            }
        });

        if (!isValid) return;

        $.ajax({
            url: 'https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/addresses/store',
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(formData),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Address has been successfully added',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/address/${userId}`;
                    }
                });
            },
            error: function(xhr) {
                console.log('Error Status:', xhr.status);
                console.log('Error Response:', xhr.responseText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        const fieldId = key === 'post_code' ? 'postcode' : key;
                        $(`#${fieldId}`).addClass('border-red-500');
                        $(`#${fieldId}-error`).text(errors[key][0]);
                    });
                } else if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    alert('Terjadi kesalahan saat menyimpan alamat');
                }
            }
        });
    });

    // Reset error state saat input berubah
    $('input').on('input', function() {
        $(this).removeClass('border-red-500');
        $(`#${$(this).attr('id')}-error`).text('');
    });
});
</script>
@endpush
