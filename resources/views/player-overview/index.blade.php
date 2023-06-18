{{-- Solution that doesn't need JQuery --}}
<x-layout>

  <div class="m-auto">

    <div class="flex">
      <div class="grow p-6">
        <label for="parameter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          Statistic
        </label>
        <select id="parameter"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          @foreach ($parameters as $param)
            <option value={{ $param->id }} @if ($loop->first) selected @endif>
              {{ $param->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="grow p-6">
        <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          Year
        </label>
        <select id="year"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          @foreach ($years as $year)
            <option value={{ $year }} @if ($loop->first) selected @endif>
              {{ $year }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div data-paginated-content-container>
      @include('player-overview.table')
      <div class="p-5">
        {{ $overviews }}
      </div>
    </div>
  </div>

  @vite('resources/js/player-overview/filter.js')
</x-layout>
