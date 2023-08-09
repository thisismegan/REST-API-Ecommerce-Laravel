@props(['labelFor', 'labelName', 'type'])

<div class="grid grid-cols-3 gap-2 mt-3 justify-start items-center">
    <label {{ $for }}
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $labelName }}</label>

    <input
        {{ $attributes->merge([
            'class' =>
                'block col-span-2 p-2 rounded-md text-gray-900 border border-gray-300 bg-white sm:text-xs focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-200',
        ]) }}>
</div>
