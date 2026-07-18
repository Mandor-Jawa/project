<x-sidebar-layout>
    <x-slot name="header">
        Evaluate Proposal
    </x-slot>

    <div class="max-w-7xl mx-auto">
        
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center shadow-sm" role="alert">
            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('reviewer.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-500 mb-6 transition-colors group">
            <div class="p-1.5 rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 group-hover:ring-amber-300 dark:group-hover:ring-amber-500 mr-3 transition-all group-hover:-translate-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            Back to Dashboard
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Proposal Content -->
            <div class="md:col-span-2 space-y-6">
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <div class="mb-6 border-b border-slate-100/50 pb-6">
                        <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposal->title }}</h3>
                        <div class="mt-3 flex items-center space-x-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100/80 text-amber-700 ring-1 ring-inset ring-amber-600/20">{{ $proposal->category }}</span>
                            <span class="text-sm text-slate-500 dark:text-slate-400">By: <span class="font-semibold text-slate-700">{{ $proposal->proposer->name }}</span></span>
                        </div>
                    </div>

                    <div class="prose max-w-none text-slate-600 dark:text-slate-400 mb-8">
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Abstract</h4>
                        <p class="whitespace-pre-wrap leading-relaxed dark:text-slate-300">{{ $proposal->abstract }}</p>
                    </div>

                    <div class="pt-6 border-t border-slate-100/50 dark:border-slate-700/50">
                        <a href="{{ route('reviewer.proposal.download', $proposal) }}" class="inline-flex items-center px-5 py-2.5 bg-slate-800 dark:bg-slate-700 rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-slate-600 hover:shadow-lg hover:shadow-slate-800/20 focus:outline-none transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Proposal PDF
                        </a>
                    </div>
                </div>

                <!-- Past Feedback -->
                @if($proposal->comments->count() > 0)
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Review History
                    </h4>
                    <div class="space-y-6 max-h-[400px] overflow-y-auto pr-2 scrollbar-hide">
                        @foreach($proposal->comments as $comment)
                        <div class="bg-white/60 dark:bg-slate-900/50 rounded-2xl p-5 border border-slate-100/50 dark:border-slate-700/50 hover:bg-white/80 dark:hover:bg-slate-800 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $comment->user->name }}</span>
                                <span class="text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">{{ $comment->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="text-slate-600 dark:text-slate-300 whitespace-pre-wrap text-sm">{{ $comment->comment }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Review Form -->
            <div class="md:col-span-1 space-y-6">
                <div class="glass-panel p-6 rounded-3xl shadow-xl shadow-slate-200/50 border border-amber-100/50 sticky top-6 bg-white/50 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                    
                    <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center relative z-10">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit Evaluation
                    </h4>

                    <form action="{{ route('reviewer.proposal.review', $proposal) }}" method="POST" class="space-y-5 relative z-10">
                        @csrf
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Decision</label>
                            <div class="relative">
                                <select id="status" name="status" class="block w-full pl-4 pr-10 py-3 text-sm border-0 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-amber-600 rounded-xl bg-white/80 shadow-sm appearance-none transition-all" required>
                                    <option value="under_review" {{ $proposal->status == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                    <option value="revision_required" {{ $proposal->status == 'revision_required' ? 'selected' : '' }}>Revision Required</option>
                                    <option value="approved" {{ $proposal->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 dark:text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-semibold text-slate-700 mb-2">Feedback / Comments</label>
                            <textarea id="comment" name="comment" rows="6" class="block w-full p-4 text-sm border-0 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-amber-600 rounded-xl bg-white/80 shadow-sm transition-all resize-none" placeholder="Provide constructive feedback here..."></textarea>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-amber-500/30 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                            Submit Decision
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-sidebar-layout>
