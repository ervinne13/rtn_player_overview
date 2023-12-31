<div class="relative overflow-x-auto">
  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th scope="col" class="px-6 py-3">
          Player
        </th>
        <th scope="col" class="px-6 py-3">
          Statistic
        </th>
        <th scope="col" class="px-6 py-3">
          Value
        </th>
        <th scope="col" class="px-6 py-3">
          Year
        </th>
      </tr>
    </thead>
    <tbody data-player-overview>
      {{-- Load blade on top of our JQuery ajax loads so that we don't lose SEO --}}
      @foreach ($overviews as $overview)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ $overview->football_name }}
          </th>
          <td class="px-6 py-4">
            {{ $overview->statistic }}
          </td>
          <td class="px-6 py-4">
            {{ $overview->value }}
          </td>
          <td class="px-6 py-4">
            {{ $overview->match_year }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <template id="player-overview-row">
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
      <th data-name scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">        
      </th>
      <td data-statistic class="px-6 py-4">
      </td>
      <td data-value class="px-6 py-4">
      </td>
      <td data-year class="px-6 py-4">
      </td>
    </tr>
  </template>
</div>
