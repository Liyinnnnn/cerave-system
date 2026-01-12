import re

files_to_fix = [
    'resources/views/consultation-reports/index.blade.php',
    'resources/views/consultation-reports/show.blade.php'
]

for filepath in files_to_fix:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Replace @{{ with {{ (remove the escape character)
    content = content.replace('@{{ $user->nickname }}', '{{ $user->nickname }}')
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f'✓ Fixed {filepath}')

print('\n✅ All nickname displays fixed!')
