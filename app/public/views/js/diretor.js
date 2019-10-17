$(document).ready(() => {
    $('#usuarios').DataTable({			
        "ajax": "./listaUsuario", 
        "columns": [
            { "data": "id_usuario" },
            { "data": "nome" },
            { "data": "email" },
            { "data": "tipo" },
        ]
    }).done((data) => {
        
    });
});
