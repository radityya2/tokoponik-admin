@extends('layout')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title')
    Edit Bank
@endsection

@section('content')
    <div class="bg-green-50 rounded-lg shadow-md p-8">
        <div class="border-b border-green-200 mb-6">
            <h1 class="text-gray-800 text-2xl font-bold mb-4">Form Edit Bank</h1>
        </div>

        <form id="editBankForm" class="space-y-6">
            @csrf
            <div>
                <label for="owner_name" class="block text-gray-800 text-sm font-semibold mb-3">Owner Name</label>
                <input type="text" name="owner_name" id="owner_name"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                <p id="owner_name-error" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div>
                <label for="bank_name" class="block text-gray-800 text-sm font-semibold mb-3">Bank Name</label>
                <input type="text" name="bank_name" id="bank_name"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                <p id="bank_name-error" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div>
                <label for="number" class="block text-gray-800 text-sm font-semibold mb-3">Number</label>
                <input type="text" name="number" id="number"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                <p id="number-error" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div class="flex gap-4">
                <button type="submit" id="submitBtn" class="flex items-center px-6 py-2.5 bg-green-800 hover:bg-green-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit
                </button>
                <a href="{{ route('bank.index') }}" class="flex items-center px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const token = localStorage.getItem('token');
    console.log('Token di halaman edit:', token); // Debugging

    if (!token) {
        console.log('Token tidak ditemukan di halaman edit'); // Debugging
        window.location.href = '/login';
        return;
    }

    const bankId = window.location.pathname.split('/')[2];

    // Ambil data bank
    $.ajax({
        url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks/${bankId}`,
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Data bank berhasil diambil:', response); // Debugging
            if (response.data) {
                $('#owner_name').val(response.data.owner_name || '');
                $('#bank_name').val(response.data.bank_name || '');
                $('#number').val(response.data.number || '');
            }
        },
        error: function(xhr) {
            console.error('Error mengambil data bank:', xhr); // Debugging
            if (xhr.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        }
    });

    // Handle form submit
    $('#editBankForm').on('submit', function(e) {
        e.preventDefault();

        // Reset error messages
        $('.text-red-500').text('');
        $('input').removeClass('border-red-500');

        // Validasi client-side
        let isValid = true;
        const owner_name = $('#owner_name').val().trim();
        const bank_name = $('#bank_name').val().trim();
        const number = $('#number').val().trim();

        if (!owner_name) {
            $('#owner_name-error').text('Nama pemilik bank harus diisi');
            $('#owner_name').addClass('border-red-500');
            isValid = false;
        }

        if (!bank_name) {
            $('#bank_name-error').text('Nama bank harus diisi');
            $('#bank_name').addClass('border-red-500');
            isValid = false;
        }

        if (!number) {
            $('#number-error').text('Nomor bank harus diisi');
            $('#number').addClass('border-red-500');
            isValid = false;
        }

        if (!isValid) return;

        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Saving...');

        $.ajax({
            url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks/${bankId}/update`,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                owner_name: owner_name,
                bank_name: bank_name,
                number: number
            }),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Bank has been successfully updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('bank.index') }}";
                    }
                });
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $(`#${key}`).addClass('border-red-500');
                        $(`#${key}-error`).text(errors[key][0]);
                    });
                } else if (xhr.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                } else {
                    alert('Terjadi kesalahan saat memperbarui data bank');
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

window.editBank = function(id) {
    $.ajax({
        url: `https://restapi-tokoponik-aqfsagdnfph3cgd8.australiaeast-01.azurewebsites.net/api/auth/banks/${id}`,
        method: 'GET',
        success: function(response) {
            window.location.href = `/bank/${id}/edit`;
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        }
    });
}
</script>
@endpush
