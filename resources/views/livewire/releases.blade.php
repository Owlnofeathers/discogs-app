<tbody class="bg-white">
    @foreach($releases as $release)
        <tr wire:key="{{ $release['id'] }}">
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="text-sm leading-5 font-medium text-gray-900">
                            {{ $release['basic_information']['artists'][0]['name'] }}
                        </div>
                        <div class="text-sm leading-5 text-gray-500">Artist info</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <div class="text-sm leading-5 text-gray-900">
                    {{ $release['basic_information']['title'] }}
                </div>
                <div class="text-sm leading-5 text-gray-500">Album info</div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <div class="text-sm leading-5 text-gray-900">
                    {{ $release['basic_information']['labels'][0]['name'] }}
                </div>
                <div class="text-sm leading-5 text-gray-500">Label info</div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                <div class="text-sm leading-5 text-gray-900">
                    {{ isset($release['basic_information']['styles'][0]) ? $release['basic_information']['styles'][0] : '' }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
        </tr>
    @endforeach
</tbody>
