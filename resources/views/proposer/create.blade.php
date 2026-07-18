<x-sidebar-layout>
    <x-slot name="header">
        New Submission
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="glass-panel rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-white/60 p-8 lg:p-12">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Submit Proposal</h2>
                <p class="text-slate-500 mt-2">Fill in the details below to submit a new proposal for review.</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-4 rounded-2xl bg-rose-50/80 border border-rose-100 flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-500 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-rose-800">Please correct the following errors:</h3>
                        <div class="mt-2 text-sm text-rose-600">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('proposer.proposal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="tipe_pengajuan" class="block text-sm font-semibold text-slate-700">Tipe Pengajuan <span class="text-rose-500">*</span></label>
                        <select name="tipe_pengajuan" id="tipe_pengajuan" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-slate-50/50 py-3 text-slate-700 shadow-sm transition-shadow" required>
                            <option value="" disabled selected>Pilih Tipe</option>
                            <option value="Skripsi">Skripsi</option>
                            <option value="Tugas Akhir">Tugas Akhir</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Mahasiswa <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" readonly class="block w-full rounded-xl border-0 ring-1 ring-slate-200 bg-slate-100/50 text-slate-500 py-3 pl-11 shadow-sm cursor-not-allowed" value="{{ auth()->user()->name }} ({{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }})">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-slate-700">Judul (Bhs. Indonesia) <span class="text-rose-500">*</span></label>
                        <textarea name="title" id="title" rows="2" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-white/50 py-3 shadow-sm transition-shadow resize-none" placeholder="Masukkan judul utama..." required>{{ old('title') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="judul_inggris" class="block text-sm font-semibold text-slate-700">Judul (Bhs. Inggris) <span class="text-rose-500">*</span></label>
                        <textarea name="judul_inggris" id="judul_inggris" rows="2" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-white/50 py-3 shadow-sm transition-shadow resize-none" placeholder="Enter english title..." required>{{ old('judul_inggris') }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-slate-700">Bidang Keilmuan <span class="text-rose-500">*</span></label>
                        <select name="category" id="category" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-slate-50/50 py-3 text-slate-700 shadow-sm transition-shadow" required>
                            <option value="" disabled selected>Pilih Bidang</option>
                            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                            <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="pdf_file" class="block text-sm font-semibold text-slate-700">Dokumen Proposal (PDF) <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <input id="pdf_file" name="pdf_file" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept=".pdf" required>
                            <div class="flex items-center w-full rounded-xl border-0 ring-1 ring-slate-200 bg-white/50 py-3 px-4 shadow-sm group-hover:ring-amber-500 transition-all">
                                <svg class="w-5 h-5 text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span id="file-name-display" class="text-slate-500 truncate flex-1 text-sm">Pilih file PDF...</span>
                                <span class="text-xs font-medium bg-amber-50 text-amber-600 px-3 py-1 rounded-lg">Browse</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    <div class="space-y-2">
                        <label for="pembimbing_1_id" class="block text-sm font-semibold text-slate-700">Dosen Pembimbing 1 <span class="text-rose-500">*</span></label>
                        <select name="pembimbing_1_id" id="pembimbing_1_id" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-white/50 py-3 text-slate-700 shadow-sm transition-shadow" required>
                            <option value="" disabled selected>Pilih Dosen</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="pembimbing_2_id" class="block text-sm font-semibold text-slate-700">Dosen Pembimbing 2 <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <select name="pembimbing_2_id" id="pembimbing_2_id" class="block w-full rounded-xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 bg-white/50 py-3 text-slate-700 shadow-sm transition-shadow">
                            <option value="" selected>Pilih Dosen (Jika Ada)</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <a href="{{ route('proposer.dashboard') }}" class="px-6 py-3 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center px-8 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-zinc-600 hover:from-amber-600 hover:to-zinc-700 shadow-lg shadow-amber-500/30 transform transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Submit Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('pdf_file').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file PDF...';
            var display = document.getElementById('file-name-display');
            display.textContent = fileName;
            if(e.target.files[0]) {
                display.classList.remove('text-slate-500');
                display.classList.add('text-slate-800', 'font-medium');
            } else {
                display.classList.add('text-slate-500');
                display.classList.remove('text-slate-800', 'font-medium');
            }
        });
    </script>
</x-sidebar-layout>
