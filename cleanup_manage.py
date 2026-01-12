import re

with open('resources/views/appointments/manage.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Remove the leftover code
content = content.replace('''                @if(request('search'))
                    <a href="{{ route('appointments.manage') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium dark:bg-gray-700 dark:hover:bg-gray-800">
                        Clear
                    </a>
                @endif
            </form>
        </div>''', '')

with open('resources/views/appointments/manage.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Cleaned up successfully')
