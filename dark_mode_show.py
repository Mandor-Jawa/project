import glob
import os

files = glob.glob('resources/views/*/show.blade.php')
for file in files:
    with open(file, 'r') as f:
        content = f.read()

    replacements = {
        'text-slate-500 hover:text-amber-600': 'text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-500',
        'bg-white shadow-sm ring-1 ring-slate-200': 'bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700',
        'group-hover:ring-amber-300': 'group-hover:ring-amber-300 dark:group-hover:ring-amber-500',
        'glass-panel p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white/60': 'glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10',
        'glass-panel p-6 rounded-3xl shadow-xl shadow-slate-200/50 border border-white/60': 'glass-panel dark:bg-slate-800/80 p-6 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10',
        'text-3xl font-bold text-slate-800': 'text-3xl font-bold text-slate-800 dark:text-white',
        'bg-amber-100 text-amber-700 ring-1 ring-inset ring-amber-600/20': 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20 dark:ring-amber-500/30',
        "'approved' => 'bg-emerald-100/80 text-emerald-700 ring-emerald-600/20',": "'approved' => 'bg-emerald-100/80 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-500/20 dark:text-emerald-400 dark:ring-emerald-500/30',",
        "'rejected' => 'bg-rose-100/80 text-rose-700 ring-rose-600/20',": "'rejected' => 'bg-rose-100/80 text-rose-700 ring-rose-600/20 dark:bg-rose-500/20 dark:text-rose-400 dark:ring-rose-500/30',",
        "'revision_required' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20',": "'revision_required' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20 dark:bg-amber-500/20 dark:text-amber-400 dark:ring-amber-500/30',",
        "'revision_submitted' => 'bg-blue-100/80 text-blue-700 ring-blue-600/20',": "'revision_submitted' => 'bg-blue-100/80 text-blue-700 ring-blue-600/20 dark:bg-blue-500/20 dark:text-blue-400 dark:ring-blue-500/30',",
        "'under_review' => 'bg-zinc-100/80 text-zinc-700 ring-zinc-600/20',": "'under_review' => 'bg-zinc-100/80 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-500/20 dark:text-zinc-400 dark:ring-zinc-500/30',",
        "'pending_review' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20',": "'pending_review' => 'bg-amber-100/80 text-amber-700 ring-amber-600/20 dark:bg-amber-500/20 dark:text-amber-400 dark:ring-amber-500/30',",
        "?? 'bg-slate-100/80 text-slate-700 ring-slate-600/20';": "?? 'bg-slate-100/80 text-slate-700 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-300';",
        'text-lg font-semibold text-slate-800 mb-2': 'text-lg font-semibold text-slate-800 dark:text-white mb-2',
        'whitespace-pre-wrap leading-relaxed': 'whitespace-pre-wrap leading-relaxed dark:text-slate-300',
        'border-t border-slate-100/50': 'border-t border-slate-100/50 dark:border-slate-700/50',
        'bg-slate-800 rounded-xl': 'bg-slate-800 dark:bg-slate-700 rounded-xl',
        'hover:bg-slate-700': 'hover:bg-slate-700 dark:hover:bg-slate-600',
        'bg-amber-50/50 rounded-2xl': 'bg-amber-50/50 dark:bg-amber-900/10 rounded-2xl',
        'border-amber-200/50': 'border-amber-200/50 dark:border-amber-500/20',
        'text-amber-800': 'text-amber-800 dark:text-amber-500',
        'text-amber-700/80': 'text-amber-700/80 dark:text-amber-400/80',
        'border-slate-300': 'border-slate-300 dark:border-slate-600',
        'hover:border-amber-400': 'hover:border-amber-400 dark:hover:border-amber-500',
        'hover:bg-white/50': 'hover:bg-white/50 dark:hover:bg-slate-800/50',
        'text-slate-500': 'text-slate-500 dark:text-slate-400',
        'text-slate-700 font-semibold': 'text-slate-700 dark:text-slate-300 font-semibold',
        'text-xl font-bold text-slate-800 mb-6 flex items-center': 'text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center',
        'bg-white/60 rounded-2xl': 'bg-white/60 dark:bg-slate-900/50 rounded-2xl',
        'border-slate-100/50 hover:bg-white/80 transition-colors': 'border-slate-100/50 dark:border-slate-700/50 hover:bg-white/80 dark:hover:bg-slate-800 transition-colors',
        'font-semibold text-slate-800': 'font-semibold text-slate-800 dark:text-slate-200',
        'text-slate-400 bg-slate-100': 'text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800',
        'text-slate-600 whitespace-pre-wrap': 'text-slate-600 dark:text-slate-300 whitespace-pre-wrap',
        'w-16 h-16 bg-slate-100 rounded-full': 'w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full',
        'text-slate-500 font-medium': 'text-slate-500 dark:text-slate-400 font-medium',
        'text-lg font-bold text-slate-800 mb-6': 'text-lg font-bold text-slate-800 dark:text-white mb-6',
        'border-amber-100 ml-3': 'border-amber-100 dark:border-amber-900 ml-3',
        'bg-amber-100 rounded-full': 'bg-amber-100 dark:bg-amber-900 rounded-full',
        'ring-4 ring-white': 'ring-4 ring-white dark:ring-slate-800',
        'text-slate-400': 'text-slate-400 dark:text-slate-500',
        
        # Admin Show Specifics
        'glass-panel p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white/60 sticky top-6': 'glass-panel dark:bg-slate-800/80 p-8 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-white/60 dark:border-white/10 sticky top-6',
        'bg-slate-50 p-4 rounded-xl border border-slate-100': 'bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50',
        'text-slate-900 font-medium': 'text-slate-900 dark:text-slate-100 font-medium',
        'text-amber-600 font-medium': 'text-amber-600 dark:text-amber-500 font-medium',
        'border-slate-200 bg-white': 'border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800',
        'text-slate-900': 'text-slate-900 dark:text-white',
        'bg-white border-slate-200 text-slate-700': 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300',
        'bg-amber-600 hover:bg-amber-700': 'bg-amber-600 hover:bg-amber-700',
        'text-xl font-bold text-slate-800 mb-4': 'text-xl font-bold text-slate-800 dark:text-white mb-4',
        'bg-slate-50 rounded-2xl p-6 border border-slate-200/50': 'bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50',
        'text-emerald-800': 'text-emerald-800 dark:text-emerald-500',
        'text-emerald-700/80': 'text-emerald-700/80 dark:text-emerald-400/80',
        'bg-emerald-600 hover:bg-emerald-700': 'bg-emerald-600 hover:bg-emerald-700',
        'text-slate-600': 'text-slate-600 dark:text-slate-400',

        # Reviewer Show Specifics
        'bg-white border-slate-200': 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-600',
        'text-rose-800': 'text-rose-800 dark:text-rose-500',
        'text-rose-700/80': 'text-rose-700/80 dark:text-rose-400/80',
        'bg-rose-600 hover:bg-rose-700': 'bg-rose-600 hover:bg-rose-700',
    }

    for old, new in replacements.items():
        content = content.replace(old, new)
        
    with open(file, 'w') as f:
        f.write(content)
        print(f"Updated {file}")

