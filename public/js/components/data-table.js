
let table = new DataTable('#myTable', {
    layout: {
        topStart: {
            pageLength: {
                menu: [
                    [5, 10, 20, 50, -1],
                    [5, 10, 20, 50, "Todos"]
                ],
                initial: 10
            }
        },
        topEnd: {
            search: {
                placeholder: 'Busca aquí'
            }
        }
    },
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    },
});