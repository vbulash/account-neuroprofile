/*
 *  Document   : datatables.js
 *  Author     : pixelcave
 *  Description: Using custom JS code to init DataTables plugin
 */

// DataTables, for more examples you can check out https://www.datatables.net/
class pageTablesDatatables {
  /*
   * Init DataTables functionality
   *
   */
  static initDataTables() {
    // Override a few default classes
    jQuery.extend(jQuery.fn.dataTable.ext.classes, {
      sWrapper: "dataTables_wrapper dt-bootstrap5",
      sFilterInput: "form-control",
      sLengthSelect: "form-select"
    });

    // Override a few defaults
    jQuery.extend(true, jQuery.fn.dataTable.defaults, {
      language: {
        lengthMenu: "<span class='me-2'>Записей на страницу</span> _MENU_",
        search: "_INPUT_",
        searchPlaceholder: "Поиск..",
        info: "Страница <strong>_PAGE_</strong> из <strong>_PAGES_</strong>",
        paginate: {
          first: '<i class="fa fa-angle-double-left"></i>',
          previous: '<i class="fa fa-angle-left"></i>',
          next: '<i class="fa fa-angle-right"></i>',
          last: '<i class="fa fa-angle-double-right"></i>'
        }
      }
    });

    // Override buttons default classes
    jQuery.extend(true, jQuery.fn.DataTable.Buttons.defaults, {
      dom: {
        button: {
          className: 'btn btn-sm btn-primary'
        },
      }
    });

    // Init full DataTable
    jQuery('.js-dataTable-full').DataTable({
      pageLength: 50,
      lengthMenu: [[5, 10, 50], [5, 10, 50]],
      autoWidth: false
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initDataTables();
  }
}

// Initialize when page loads
Dashmix.onLoad(() => pageTablesDatatables.init());
