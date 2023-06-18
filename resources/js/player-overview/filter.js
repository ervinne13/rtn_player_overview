
(() => {

  const refreshView = () => {
    const param_id = $('#parameter').val();
    const year = $('#year').val();
    const page = document.querySelector('[data-current-page]').innerHTML;

    document.location = `/?page=${page}&param_id=${param_id}&year=${year}`;

    // $.get('/api/player-overview', { param_id, year, page }, (response) => {
    //   const template = document.querySelector('template#player-overview-row');
    //   document.querySelector('[data-player-overview]').innerHTML = '';
    //   for (const overview of response['data']) {
    //     const row = template.content.cloneNode(true);
    //     row.querySelector('[data-name]').innerHTML = overview.football_name;
    //     row.querySelector('[data-statistic]').innerHTML = overview.statistic;
    //     row.querySelector('[data-value]').innerHTML = overview.value;
    //     row.querySelector('[data-year]').innerHTML = overview.match_year;
    //     document.querySelector('[data-player-overview]').append(row);
    //   }
    // });
  };

  $(document).ready(() => {
    $('#parameter').change(refreshView);
    $('#year').change(refreshView);
  });
})();

