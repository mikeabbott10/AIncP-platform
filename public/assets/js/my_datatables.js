jQuery(function ($) {$(function () {
    let table = $(".dt-table").DataTable(initObj)

    // Add event listener for opening and closing details
    $('.dt-table tbody').on('click', 'td.dt-control', function () {
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
        console.log(deleteResourceBaseUrl+'/'+$(_this).data('id'))
        await fetch(deleteResourceBaseUrl+'/'+$(_this).data('id'),{
            method: 'GET' // warning security issue (csfr)
        })
        //window.location.href='';
    })
})})