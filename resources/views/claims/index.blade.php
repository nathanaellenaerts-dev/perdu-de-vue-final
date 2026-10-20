<x-layouts.app>
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="flex justify-between items-center">
<h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Déclarations de perte des voyageurs') }}</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-400">
                    <tr>
                        <th class="p-4">{{ __('Date') }}</th>
                        <th class="p-4">{{ __('Description') }}</th>
                        <th class="p-4">{{ __('Objet associé') }}</th>
                        <th class="p-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($claims as $claim)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-500 whitespace-nowrap">
                                {{ $claim->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 text-gray-900 font-medium max-w-xs truncate">
                                {{ Str::limit($claim->description, 60) }}
                            </td>
                            <td class="p-4">
                                @if($claim->item)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Lié : {{ $claim->item->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ __('En attente') }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('claims.show', $claim) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ __('Traiter →') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-400">
                                {{ __('Aucune déclaration de perte enregistrée pour le moment.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination si nécessaire -->
        <div>
            {{ $claims->links() }}
        </div>

    </div>
</x-layouts.app>
