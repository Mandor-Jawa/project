<x-sidebar-layout>
    <x-slot name="header">
        Submissions
    </x-slot>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-2xl relative overflow-hidden group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl group-hover:bg-amber-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 font-medium text-sm">Total Proposals</h3>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposals->count() }}</p>
        </div>
        
        <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-2xl relative overflow-hidden group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 font-medium text-sm">Approved</h3>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposals->where('status', 'approved')->count() }}</p>
        </div>

        <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-2xl relative overflow-hidden group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl group-hover:bg-amber-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 font-medium text-sm">Pending / Revise</h3>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposals->whereIn('status', ['pending_review', 'revision_required', 'revision_submitted', 'under_review'])->count() }}</p>
        </div>

        <div class="glass-panel dark:bg-slate-800/80 p-6 rounded-2xl relative overflow-hidden group hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-500/10 rounded-full blur-xl group-hover:bg-rose-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 font-medium text-sm">Rejected</h3>
                <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $proposals->where('status', 'rejected')->count() }}</p>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="glass-panel rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10 dark:bg-slate-800/80" x-data="{ search: '', filter: 'all', filterOpen: false }">
        <div class="p-8 border-b border-slate-100/50 dark:border-slate-700 bg-white/40 dark:bg-slate-800/40 flex justify-between items-center flex-wrap gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Your Proposals</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage and track your submission status.</p>
            </div>
            
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <a href="{{ route('proposer.proposal.create') }}" class="flex items-center justify-center text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-xl text-sm px-4 py-2 transition-colors shadow-sm shadow-amber-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Submission
                </a>
                <div class="relative flex-1 md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input x-model="search" type="text" class="block w-full pl-10 pr-3 py-2 text-sm border-0 ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-amber-500 rounded-xl bg-white/80 dark:bg-slate-900/50 dark:text-slate-200 placeholder-slate-400 transition-shadow" placeholder="Search proposals...">
                </div>
                <div class="relative">
                    <button @click="filterOpen = !filterOpen" @click.away="filterOpen = false" class="p-2 text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-slate-700 rounded-xl ring-1 ring-slate-200 dark:ring-slate-700 transition-colors" :class="{ 'bg-amber-50 text-amber-600 dark:bg-slate-700 dark:text-amber-500': filter !== 'all' }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                    <div x-show="filterOpen" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 py-1 z-50">
                        <button @click="filter = 'all'; filterOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700" :class="{ 'bg-slate-50 dark:bg-slate-700': filter === 'all' }">All Status</button>
                        <button @click="filter = 'approved'; filterOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700" :class="{ 'bg-slate-50 dark:bg-slate-700': filter === 'approved' }">Approved</button>
                        <button @click="filter = 'pending_review'; filterOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700" :class="{ 'bg-slate-50 dark:bg-slate-700': filter === 'pending_review' }">Pending</button>
                        <button @click="filter = 'rejected'; filterOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700" :class="{ 'bg-slate-50 dark:bg-slate-700': filter === 'rejected' }">Rejected</button>
                        <button @click="filter = 'revision_required'; filterOpen = false" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700" :class="{ 'bg-slate-50 dark:bg-slate-700': filter === 'revision_required' }">Revise</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-8 py-5 font-semibold">ID</th>
                        <th class="px-8 py-5 font-semibold">Title</th>
                        <th class="px-8 py-5 font-semibold">Category</th>
                        <th class="px-8 py-5 font-semibold">Date</th>
                        <th class="px-8 py-5 font-semibold text-center">Status</th>
                        <th class="px-8 py-5 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/50 bg-white/60 dark:bg-slate-900/50">
                    @forelse($proposals as $proposal)
                    <tr x-show="(filter === 'all' || '{{ $proposal->status }}' === filter) && (search === '' || $el.textContent.toLowerCase().includes(search.toLowerCase()))" class="hover:bg-amber-50/30 dark:hover:bg-slate-800 transition-colors duration-200 group">
                        <td class="px-8 py-5 text-sm font-medium text-slate-400 dark:text-slate-500">
                            #{{ str_pad($proposal->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-semibold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-500 transition-colors">
                                {{ $proposal->title }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1 truncate max-w-[200px]">
                                {{ $proposal->tipe_pengajuan ?? 'Standard' }}
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-600 dark:text-slate-400">
                            {{ $proposal->category }}
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-500 dark:text-slate-400">
                            {{ $proposal->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-5 text-center">
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $colorClass }}">
                                {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('proposer.proposal.show', $proposal) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-700 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900">No submissions yet</h3>
                            <p class="mt-1 text-sm text-slate-500 mb-6">Get started by creating your first proposal submission.</p>
                            <a href="{{ route('proposer.proposal.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                New Submission
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Premium Pagination Footer -->
        @if($proposals->count() > 0)
        <div class="px-8 py-4 bg-slate-50/50 dark:bg-slate-800/80 border-t border-slate-100/50 dark:border-slate-700 flex items-center justify-between">
            <span class="text-sm text-slate-500 dark:text-slate-400">Showing all {{ $proposals->count() }} records</span>
            <div class="flex space-x-1">
                <button class="p-2 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 hover:bg-white dark:hover:bg-slate-700 hover:text-slate-600 transition-colors" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button class="p-2 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 hover:bg-white dark:hover:bg-slate-700 hover:text-slate-600 transition-colors" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</x-sidebar-layout>
