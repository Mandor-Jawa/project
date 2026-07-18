<x-sidebar-layout>
    <x-slot name="header">
        Manage Proposal
    </x-slot>

    <div class="max-w-7xl mx-auto">
        
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center shadow-sm" role="alert">
            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-500 mb-6 transition-colors group">
            <div class="p-1.5 rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 group-hover:ring-amber-300 dark:group-hover:ring-amber-500 mr-3 transition-all group-hover:-translate-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            Back to Dashboard
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Proposal Content -->
            <div class="md:col-span-2 space-y-6">
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <div class="flex justify-between items-start mb-6 border-b border-slate-100/50 pb-6">
                        <div>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposal->title }}</h3>
                            <div class="mt-3 flex items-center space-x-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100/80 text-amber-700 ring-1 ring-inset ring-amber-600/20">{{ $proposal->category }}</span>
                                <span class="text-sm text-slate-500 dark:text-slate-400">By: <span class="font-semibold text-slate-700">{{ $proposal->proposer->name }}</span></span>
                            </div>
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

                    <div class="pt-6 border-t border-slate-100/50 dark:border-slate-700/50">
                        <a href="{{ route('admin.proposal.download', $proposal) }}" class="inline-flex items-center px-5 py-2.5 bg-slate-800 dark:bg-slate-700 rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-slate-600 hover:shadow-lg hover:shadow-slate-800/20 focus:outline-none transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Proposal PDF
                        </a>
                    </div>
                </div>

                <!-- Past Feedback -->
                @if($proposal->comments->count() > 0)
                <div class="glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
                    <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Reviewer Comments
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

            <!-- Assignment Form and Timeline -->
            <div class="md:col-span-1 space-y-6">
                
                <div class="glass-panel p-6 rounded-3xl shadow-xl shadow-slate-200/50 border border-amber-100/50 bg-white/50 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                    <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center relative z-10">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Assign Reviewer
                    </h4>

                    <form action="{{ route('admin.proposal.assign', $proposal) }}" method="POST" class="space-y-5 relative z-10">
                        @csrf
                        
                        <div>
                            <label for="reviewer_id" class="block text-sm font-semibold text-slate-700 mb-2">Select Reviewer</label>
                            <div class="relative">
                                <select id="reviewer_id" name="reviewer_id" class="block w-full pl-4 pr-10 py-3 text-sm border-0 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-amber-600 rounded-xl bg-white/80 shadow-sm appearance-none transition-all" required>
                                    <option value="">-- Choose Reviewer --</option>
                                    @foreach($reviewers as $reviewer)
                                        <option value="{{ $reviewer->id }}" {{ $proposal->reviewer_id == $reviewer->id ? 'selected' : '' }}>
                                            {{ $reviewer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500 dark:text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-amber-500/30 text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5 mt-2">
                            Update Assignment
                        </button>
                    </form>
                </div>

                <!-- Sidebar Log/Timeline -->
                <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10">
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
