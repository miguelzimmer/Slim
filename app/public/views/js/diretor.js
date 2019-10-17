$(document).ready(() => {
    $('#usuarios').DataTable({			
        "ajax": "", 
        "columns": [
            { "data": "id_usuario" },
            { "data": "nome" },
            { "data": "email" },
            { "data": "tipo" },
        ]
    });
});
