jQuery(function ($) {$(function () {
    // ==============================================================
    // init datatables
    // ==============================================================
    let initObj = {
        // stateSave: true, // needs same table id everytime the page is loaded (https://datatables.net/reference/option/stateSave)
        columnDefs: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
                targets: 0
            },
            { orderable: false, targets: 0 },
            { data:'code', targets: 1 },
            { data:'name', targets: 2 },
            { data:'surname', targets: 3 },
            { data:'gender', targets: 4 },
            { data:'dominance', targets: 5 },
            { data:'aha', targets: 6 },
            { data:'macs', targets: 7 },
            { data:'hemi', targets: 8 },
            { orderable: false, targets: 9 },
        ],
        order: [[3, 'desc']]
    }

    let table = $(".subjects-table").DataTable(initObj)

    /* Formatting function for row details - modify as you need */
    function format(d, tds) {
        // `d` is the original data object for the row
        return (
            '<table class="table child-table" cellpadding="5" cellspacing="0" style="padding-left:50px;">' +
            '<tr>' +
                '<td>Subject Code:</td>' +
                '<td>' +
                    $(d.code).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Name:</td>' +
                '<td>' +
                    $(d.name).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Surname:</td>' +
                '<td>' +
                    $(d.surname).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Gender:</td>' +
                '<td>' +
                    $(d.gender).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>Arm Dominance:</td>' +
                '<td>' +
                    $(d.dominance).text() +
                '</td>' +
            '</tr>'+            
            '<tr>' +
                '<td>AHA value:</td>' +
                '<td>' +
                    $(d.aha).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>MACS class:</td>' +
                '<td>' +
                    $(d.macs).text() +
                '</td>' +
            '</tr>' +
            '<tr>' +
                '<td>hemi:</td>' +
                '<td>' +
                    $(d.hemi).text() +
                '</td>' +
            '</tr>' +
            '</table>'
        );
    }

    // Add event listener for opening and closing details
    $('.subjects-table tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data(), tr.children())).show();
            tr.addClass('shown');
        }
    });

    $('.remove-row').on('click', async (event) => {
        let _this = $(event.target)
        if ( ! _this.is( "button" ) ) { // event.target can return a descendent
            _this = _this.parent();
        }
        if(!confirm("Do you really want to continue?"))
            return;
        await fetch(deleteSubjectBaseUrl+'/'+$(_this).data('id'),{
            method: 'GET'
        })
        window.location.href='';
    })
})})