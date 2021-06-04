function reserver(path , age , date )
{
    $.ajax({
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        },
        /* l’url est une chaine de caractères contenant l’adresse où la requête est envoyée */
        url : path ,
        /* La méthode utilisée pour transférer les données est GET */
        type : 'GET',
        /*Ici search value va prendre la chaine entrée par un utilisateur dans la zone de recherche et sera placée après l’url */
        data: {
            'date' : date ,
            'ages' : age ,
        },
        /*Cette fonction permet de vider le contenu du tableau pour recevoir le nouveau contenu*/
        success : function(retour) {
            // si recherche trouve au moin un element
            if (retour) {
                // vider tableau
                $('#tableId').empty();
                // boucle sur liste

                $.each(JSON.parse(retour), function (i, obj) {
                    var d = obj ;
                    $('#tableId').append("<h4> chambre" + (i+1) + ": " +  Object.values(obj)[0] + " " +  Object.keys(obj)[0] +", " + Object.values(obj)[1] +" "+ Object.keys(obj)[1]+"</h4>")
                    console.log(d);

                });

            } else {
                // si recherche ne trouve rien
                $('#tableId').empty();
            }
        },
        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    });
}


function updateNumberPerRoom(path , number  )
{
    $.ajax({
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        },
        /* l’url est une chaine de caractères contenant l’adresse où la requête est envoyée */
        url : path ,
        /* La méthode utilisée pour transférer les données est GET */
        type : 'GET',
        /*Ici search value va prendre la chaine entrée par un utilisateur dans la zone de recherche et sera placée après l’url */
        data: {
            'number' : number ,
        },
        /*Cette fonction permet de vider le contenu du tableau pour recevoir le nouveau contenu*/
        success : function(retour) {
            // si recherche trouve au moin un element
            if (retour) {
                // vider tableau
                $('#tableId').empty();
                // boucle sur liste
                $('#tableId').append("<p>done</p>");


            } else {
                // si recherche ne trouve rien
                $('#tableId').empty();
            }
        },
        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        },
        error: function(xhr, status, error) {
            $('#tableId').append("<p>error</p>");
        },
    });
}

function addAgeRange(ageRangePath , label , min , max ,  cannotBeAlone  )
{
    $.ajax({
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        },
        /* l’url est une chaine de caractères contenant l’adresse où la requête est envoyée */
        url : ageRangePath ,
        /* La méthode utilisée pour transférer les données est GET */
        type : 'GET',
        /*Ici search value va prendre la chaine entrée par un utilisateur dans la zone de recherche et sera placée après l’url */
        data: {
            'label' : label ,
            'min' : min ,
            'max' : max ,
            'cannotBeAlone' : cannotBeAlone ,
        },
        /*Cette fonction permet de vider le contenu du tableau pour recevoir le nouveau contenu*/
        success : function(retour) {
            if (retour) {
                $('#tableId2').empty();
                $('#tableId2').append("<p>done</p>");


            } else {
                $('#tableId2').empty();
            }
        },
        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        },
        error: function(xhr, status, error) {
            $('#tableId2').append("<p>error</p>");
        },
    });
}
