function name2Id (table, name)
{
    $.ajax(
        {
            method: "GET",
            url: "search/name2Id",
            data: { object: table, name: name}
        })
        .done(function( msg )
        {
            $('#btnDetalle').attr('disabled', false)
                .attr('href', 'almacenes/'+msg);
        })      // fin del .done
        .fail(function( msg )
        {
            alert( "Error: " + msg );
        }); // fin del .fail
}