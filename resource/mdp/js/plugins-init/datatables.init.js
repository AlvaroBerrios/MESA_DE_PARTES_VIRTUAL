(function($) {
    'use strict'
    var table = $('#tramite').DataTable({
        searchDelay: 500,
        processing: true,
        ajax: './json/tramites.json',
        columns: [
            {data: 'Solicitud', className: 'text-center'},
            {data: 'Sinad', className: 'text-center'},
            {data: 'DNI', className: 'text-center'},
            {data: 'Usuario'},
            {data: 'FechaRespuesta', className: 'text-center'},
            {data: 'Requisitos', className: 'text-center'},
            {data: 'Estado', className: 'text-center'},
            {data: 'Acciones', className: 'text-center', width: '10%', responsivePriority: -1}
        ],
        columnDefs: [
            {
                targets: -1,
                title: 'Acción',
                orderable: false,
                render: function (data, type, full, meta) {
                    return '<div class="dropdown ml-auto show">' +
                        '<div class="btn-link" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v"></i></div>' +
                        '<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-114px, -114px, 0px);">' +
                        '<a class="dropdown-item" href="javascript:">Ver FUT</a>' +
                        '<a class="dropdown-item" href="javascript:">Revisar</a>' +
                        '</div>' +
                        '</div>';
                }
            },
            {
                targets: 5,
                orderable: false,
                render: function (data, type, full, meta) {
                    return '<button type="button" class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#requisitoModal">Ver</button>';
                }
            },
            {
                targets: 6,
                render: function (data, type, full, meta) {
                    var status = {
                        'Observado': {'title': 'Observado', 'class': 'warning'},
                        'Aprobado': {'title': 'Aprobado', 'class': 'success'}
                    };
                    if (typeof status[data] === 'undefined') {
                        return data;
                    }
                    return '<span class="badge light badge-' + status[data].class + '">' + status[data].title + '</span>';
                }
            }
        ]
    });
})(jQuery);
