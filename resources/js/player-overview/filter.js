
(() => {

  const refreshView = () => {

  };

  $(document).ready(() => {

    $('#parameter').change(function () {
      const selectedParam = $(this).val();
      console.log({ selectedParam });
    });

    $('#year').change(function () {
      const selectedYear = $(this).val();
      console.log({ selectedYear });
    });

    console.log("initialized");
  });
})();

