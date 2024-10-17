$(function (e) {
    // basic datatable
    $("#datatable-basic").DataTable({
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
        pageLength: 10,
        // scrollX: true
    });
    // basic datatable

    // responsive datatable
    $("#responsiveDataTable").DataTable({
        responsive: true,
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
        pageLength: 10,
    });
    // responsive datatable

    // responsive modal datatable
    $("#responsivemodal-DataTable").DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return data[0] + " " + data[1];
                    },
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: "table",
                }),
            },
        },
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
        pageLength: 10,
    });
    // responsive modal datatable

    // file export datatable
    // $("#file-export").DataTable({
    //     dom: "Bfrtip",
    //     buttons: ["copy", "csv", "excel", "pdf", "print"],
    //     language: {
    //         searchPlaceholder: "Search...",
    //         sSearch: "",
    //     },
    // });

    $("#file-export").DataTable({
        dom: "Bfrtilp",
        buttons: [
            {
                text: '<i class="bi bi-download"></i> Export &nbsp;',
                className: "btn btn-sm btn-secondary mb-2 dropdown-toggle", // Make the main button look like a dropdown toggle
                action: function (e, dt, button, config) {
                    let $button = $(button);

                    // Remove any existing dropdown menus to prevent multiple dropdowns
                    $(".dropdown-menu").remove();

                    // Create dropdown menu structure for Bootstrap
                    let menu = $(`
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-export="copy" href="#"><i class="bi bi-files"></i> Copy</a>
                            <a class="dropdown-item" data-export="csv" href="#"><i class="bi bi-file-earmark-spreadsheet"></i> CSV</a>
                            <a class="dropdown-item" data-export="excel" href="#"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                            <a class="dropdown-item" data-export="pdf" href="#"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
                            <a class="dropdown-item" data-export="print" href="#"><i class="bi bi-printer"></i> Print</a>
                        </div>
                    `);

                    // Toggle the dropdown visibility
                    $button.after(menu);
                    menu.toggle();

                    // Add event listeners for export actions
                    menu.find(".dropdown-item").on("click", function (e) {
                        e.preventDefault();
                        let exportType = $(this).data("export");

                        // Trigger respective export action
                        switch (exportType) {
                            case "copy":
                                dt.button(".buttons-copy").trigger();
                                break;
                            case "csv":
                                dt.button(".buttons-csv").trigger();
                                break;
                            case "excel":
                                dt.button(".buttons-excel").trigger();
                                break;
                            case "pdf":
                                dt.button(".buttons-pdf").trigger();
                                break;
                            case "print":
                                dt.button(".buttons-print").trigger();
                                break;
                        }

                        // Close dropdown after clicking an item
                        menu.remove();
                    });

                    // Close dropdown if clicked outside
                    $(document).on("click", function (event) {
                        if (
                            !$(event.target).closest($button).length &&
                            !$(event.target).closest(menu).length
                        ) {
                            menu.remove(); // Close the dropdown if clicked outside
                        }
                    });

                    // Close dropdown if button is clicked again
                    $button.on("click", function () {
                        menu.remove(); // Close the dropdown when toggle button is clicked again
                    });
                },
            },
            { extend: "copy", className: "d-none" }, // Hide these since they'll be manually triggered
            { extend: "csv", className: "d-none" },
            { extend: "excel", className: "d-none" },
            { extend: "pdf", className: "d-none" },
            { extend: "print", className: "d-none" },
        ],
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
        // pageLength: 20,
        lengthMenu: [10, 25, 50, 100], // Show entries options
    });

    //End of file export datatable

    // delete row datatable
    var table = $("#delete-datatable").DataTable({
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
    });
    $("#delete-datatable tbody").on("click", "tr", function () {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }
    });
    $("#button").on("click", function () {
        table.row(".selected").remove().draw(false);
    });
    // delete row datatable

    // scroll vertical
    $("#scroll-vertical").DataTable({
        scrollY: "265px",
        scrollCollapse: true,
        paging: false,
        scrollX: true,
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
    });
    // scroll vertical

    // hidden columns
    $("#hidden-columns").DataTable({
        columnDefs: [
            {
                target: 2,
                visible: false,
                searchable: false,
            },
            {
                target: 3,
                visible: false,
            },
        ],
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
        pageLength: 10,
        // scrollX: true
    });
    // hidden columns

    // add row datatable
    var t = $("#add-row").DataTable({
        language: {
            searchPlaceholder: "Search...",
            sSearch: "",
        },
    });
    var counter = 1;
    $("#addRow").on("click", function () {
        t.row
            .add([
                counter + ".1",
                counter + ".2",
                counter + ".3",
                counter + ".4",
                counter + ".5",
            ])
            .draw(false);
        counter++;
    });
    // add row datatable
});
