@props(['notes'])

@if(count($notes))
    <h4 class="text-xl font-semibold text-gray-800 mb-3 text-center">Task Notes</h4>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">SN</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Creator</th>
                    <th class="px-4 py-2">Task</th>
                    <th class="px-4 py-2">Reason</th>
                    <th class="px-4 py-2">Assigned Date</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($notes as $note)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ Str::words($note->description, 6, '...') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex items-center space-x-1">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                    {{ $note->user->name }}
                                </span>
                                <a href="{{ route('users.show', $note->user) }}" class="text-blue-500 hover:underline text-xs">view</a>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            {{ $note->task->title ?? '—' }}
                        </td>
                        <td class="px-4 py-2">{{ $note->reason }}</td>
                        <td class="px-4 py-2">{{ optional($note->task)->assigned_date ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $note->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $notes->links() }}
    </div>
@endif
