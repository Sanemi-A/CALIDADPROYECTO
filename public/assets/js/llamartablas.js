$(document).ready(function() {
    var table = $('#order-listing').DataTable({
        "language": {
            "paginate": {
                "previous": "<i class='icon-arrow-left'></i>",
                "next": "<i class='icon-arrow-right'></i>",
                "first": "<i class='fas fa-angle-double-left'></i>",
                "last": "<i class='fas fa-angle-double-right'></i>"
            },
            "lengthMenu": "&#8203; _MENU_ ",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "info": " _START_ - _END_ de _TOTAL_ ",
            "infoEmpty": " 0 a 0 de 0 ",
            "infoFiltered": "(filtrado de _MAX_ registros totales)"
        },
        "dom": '<"d-flex justify-content-between align-items-center"<"left-section d-flex align-items-center"l<"custom-filter ms-3">><"right-section"f>>rtip'
    });


});