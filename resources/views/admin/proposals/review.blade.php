@extends('layouts.admin')

@section('title', 'Review Proposal')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Review Proposal</h1>
            <p class="text-gray-600 mt-1">Pemohon: <span class="font-semibold">{{ $proposal->user->name }}</span></p>
        </div>
        <a href="{{ route('admin.proposals') }}" class="mt-4 sm:mt-0 inline-block px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 border-r-2 border-gray-100 pr-8">
                <h3 class="text-h4 font-bold text-dark mb-4">Informasi Pemohon</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-bold text-gray-500">Nama</label>
                        <p class="text-dark font-semibold">{{ $proposal->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-500">Email</label>
                        <p class="text-dark font-semibold">{{ $proposal->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-500">Bergabung Sejak</label>
                        <p class="text-dark font-semibold">{{ $proposal->user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <h3 class="text-h4 font-bold text-dark mb-4">Detail Pengajuan</h3>
                <div class="space-y-4">
                    {{-- Asumsi field di model Proposal adalah 'motivation' --}}
                    <div>
                        <label class="text-sm font-bold text-gray-500">Motivasi / Surat Pengantar</label>
                        <div class="mt-1 p-4 bg-gray-50 border-2 border-gray-200 rounded-playful-sm">
                            <p class="text-dark whitespace-pre-wrap">{{ $proposal->motivation ?? 'Tidak ada motivasi yang diberikan.' }}</p>
                        </div>
                    </div>

                    {{-- Asumsi field di model Proposal adalah 'cv_path' --}}
                    <div>
                        <label class="text-sm font-bold text-gray-500">Curriculum Vitae (CV)</label>
                        @if($proposal->cv_path)
                            <a href="{{ asset('storage/' . $proposal->cv_path) }}" target="_blank" class="mt-1 flex items-center w-full sm:w-auto sm:inline-flex px-4 py-2 bg-blue-100 text-blue-800 font-bold rounded-playful-sm border-2 border-dark hover:bg-blue-200">
                                <i class="fas fa-download mr-2"></i> Unduh CV
                            </a>
                        @else
                            <p class="text-gray-500 italic">CV tidak dilampirkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t-2 border-gray-100 flex flex-col sm:flex-row justify-end items-center space-y-4 sm:space-y-0 sm:space-x-4">
            @if($proposal->status == 'pending')
                <button id="reject-button" class="w-full sm:w-auto px-6 py-3 bg-red-500 text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-red-600">
                    <i class="fas fa-times-circle mr-2"></i> Tolak Proposal
                </button>

                <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI proposal ini? Pengguna akan dijadikan Konselor.');">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                        <i class="fas fa-check-circle mr-2"></i> Setujui Proposal
                    </button>
                </form>
            @else
                <p class="text-gray-600 font-semibold italic">Proposal ini sudah di-{{ $proposal->status }}.</p>
            @endif
        </div>
    </div>
</div>

<div id="rejection-modal" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset-lg w-11/12 md:w-1/3">
        <h3 class="text-h4 font-bold text-dark mb-4">Alasan Penolakan</h3>
        <p class="text-sm text-gray-600 mb-4">Mohon berikan alasan mengapa proposal ini ditolak. Alasan ini mungkin akan dikirimkan kepada pengguna.</p>
        <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST">
            @csrf
            <textarea name="rejection_reason" rows="4" class="w-full p-2 rounded-playful-sm border-2 border-dark" placeholder="Contoh: Kualifikasi belum memenuhi syarat..." required></textarea>
            
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" id="cancel-rejection" class="px-4 py-2 bg-gray-200 text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-red-600">Kirim Penolakan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rejectModal = document.getElementById('rejection-modal');
        const rejectButton = document.getElementById('reject-button');
        const cancelButton = document.getElementById('cancel-rejection');

        if (rejectButton) {
            rejectButton.addEventListener('click', () => {
                rejectModal.classList.remove('hidden');
            });
        }

        if (cancelButton) {
            cancelButton.addEventListener('click', () => {
                rejectModal.classList.add('hidden');
            });
        }
    });
</script>
@endpush