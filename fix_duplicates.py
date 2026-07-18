import glob
import re

files = glob.glob('resources/views/*/show.blade.php')
for file in files:
    with open(file, 'r') as f:
        content = f.read()

    # clean duplicates
    content = re.sub(r'(dark:text-slate-[0-9]+ )+', r'\1', content)
    content = content.replace('dark:text-slate-400 dark:text-slate-500', 'dark:text-slate-400')
    content = content.replace('dark:text-slate-500 dark:text-slate-400', 'dark:text-slate-400')
    content = content.replace('dark:text-slate-200 dark:text-white', 'dark:text-white')

    with open(file, 'w') as f:
        f.write(content)
