<x-sidebar-layout>
    <x-slot name="header">
        Proposal Details
    </x-slot>

    <div class="max-w-7xl mx-auto">
        
        <!-- Back Button -->
        <a href="{{ route('proposer.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-500 mb-6 transition-colors group">
            <div class="p-1.5 rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 group-hover:ring-amber-300 dark:group-hover:ring-amber-500 mr-3 transition-all group-hover:-translate-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            Back to Dashboard
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Main Proposal Info -->
            <div class="md:col-span-2 space-y-6">
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposal->title }}</h3>
                            <span class="inline-block px-3 py-1 mt-2 text-xs font-semibold rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20 dark:ring-amber-500/30">{{ $proposal->category }}</span>
                        </div>
                        @php
                            $statusColors = [
                                'approved' => 'bg-emerald-100/80 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-500/20 dark:text-emerald-400 dark:ring-emerald-500/30',
                                'rejected' => 'bg-rose-100/80 text-rose-700 ring-rose-600/20 dark:bg-rose-500/20 dark:text-rose-400 dark:ring-rose-500/30',
                                'revision_required' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20 dark:bg-amber-500/20 dark:text-amber-400 dark:ring-amber-500/30',
                                'revision_submitted' => 'bg-blue-100/80 text-blue-700 ring-blue-600/20 dark:bg-blue-500/20 dark:text-blue-400 dark:ring-blue-500/30',
                                'under_review' => 'bg-zinc-100/80 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-500/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                                'pending_review' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20 dark:bg-amber-500/20 dark:text-amber-400 dark:ring-amber-500/30',
                            ];
                            $colorClass = $statusColors[$proposal->status] ?? 'bg-slate-100/80 text-slate-700 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-300';
                        @endphp
                        <span class="px-4 py-2 text-sm font-bold rounded-full ring-1 ring-inset {{ $colorClass }}">
                            {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                        </span>
                    </div>

                    <div class="prose max-w-none text-slate-600 dark:text-slate-400 mb-8">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Abstract</h4>
                        <p class="whitespace-pre-wrap leading-relaxed dark:text-slate-300">{{ $proposal->abstract }}</p>
                    </div>

                    <div class="flex flex-col space-y-6 pt-6 border-t border-slate-100/50 dark:border-slate-700/50">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('proposer.proposal.download', $proposal) }}" class="inline-flex items-center px-5 py-2.5 bg-slate-800 dark:bg-slate-700 rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-slate-600 hover:shadow-lg hover:shadow-slate-800/20 focus:outline-none transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Proposal PDF
                            </a>
                        </div>

                        @if(in_array($proposal->status, ['revision_required', 'rejected']))
                        <div class="bg-amber-50/50 dark:bg-amber-900/10 rounded-2xl p-6 border border-amber-200/50 dark:border-amber-500/20 relative overflow-hidden">
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                            <h4 class="text-lg font-bold text-amber-800 dark:text-amber-500 mb-2 relative z-10">Upload Revision</h4>
                            <p class="text-sm text-amber-700/80 dark:text-amber-400/80 mb-4 relative z-10">Please upload the revised proposal PDF based on the reviewer's feedback.</p>
                            
                            <form action="{{ route('proposer.proposal.updateFile', $proposal) }}" method="POST" enctype="multipart/form-data" class="space-y-4 relative z-10">
                                @csrf
                                <div>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-xl hover:border-amber-400 dark:hover:border-amber-500 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                                <label for="pdf_file" class="relative cursor-pointer rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="pdf_file" name="pdf_file" type="file" accept="application/pdf" class="sr-only" required onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                                </label>
                                            </div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">PDF up to 10MB</p>
                                            <p id="file-name" class="text-sm text-slate-700 dark:text-slate-300 font-semibold mt-2"></p>
                                        </div>
                                    </div>
                                    @error('pdf_file')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-amber-600 rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 hover:shadow-lg hover:shadow-amber-500/30 focus:outline-none transition-all duration-200">
                                        Submit Revision
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Reviewer Feedback
                    </h4>
                    
                    @if($proposal->comments->count() > 0)
                        <div class="space-y-6 max-h-[500px] overflow-y-auto pr-2 scrollbar-hide">
                            @foreach($proposal->comments as $comment)
                            <div class="bg-white/60 dark:bg-slate-900/50 rounded-2xl p-5 border border-slate-100/50 dark:border-slate-700/50 hover:bg-white/80 dark:hover:bg-slate-800 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-amber-500 to-zinc-600 flex items-center justify-center text-white font-bold shadow-md shadow-amber-500/20">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $comment->user->name }}</span>
                                    </div>
                                    <span class="text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">{{ $comment->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="text-slate-600 dark:text-slate-300 whitespace-pre-wrap pl-12 text-sm">{{ $comment->comment }}</div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-500 font-medium">No feedback has been provided yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Log/Timeline -->
            <div class="md:col-span-1 space-y-6">
                <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10 sticky top-6">
                    <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Timeline Log
                    </h4>
                    
                    <div class="relative border-l-2 border-amber-100 dark:border-amber-900 ml-3 space-y-8 mt-4">
                        @foreach($proposal->logs()->latest()->get() as $log)
                        <div class="relative pl-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-amber-100 dark:bg-amber-900 rounded-full -left-[13px] top-0 ring-4 ring-white dark:ring-slate-800">
                                <div class="w-2 h-2 bg-amber-600 rounded-full"></div>
                            </span>
                            <h3 class="mb-1 text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $log->action }}</h3>
                            <time class="block text-xs font-medium text-slate-400 dark:text-slate-500">{{ $log->created_at->format('d M Y, H:i') }}</time>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-sidebar-layout>
