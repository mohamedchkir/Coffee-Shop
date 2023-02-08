<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end m-2 p-2">
                <a href="{{ route('admin.meals.create') }}"
                    class="px-3 py-2 rounded-xl bg-blue-500 text-white hover:text-white hover:bg-blue-600"> New
                    Meal</a>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                IMG
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meals as $meal)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class=" w-10 h-10 rounded">
                                    <img src="{{ Storage::url($meal->image) }}">
                                </th>
                                <td class="px-6 py-4">
                                    {{ $meal->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $meal->prix }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $meal->description }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.meals.edit', $meal->id) }}"
                                            class=" bg-green-500 dark:text-blue-500 ">Edit</a>
                                        <form action="{{ route('admin.meals.destroy', $meal->id) }}"
                                            class="px-4 py-2 bg-red-500 " method="POST"
                                            onsubmit="return confirm('are You sur?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Delete</button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-admin-layout>
