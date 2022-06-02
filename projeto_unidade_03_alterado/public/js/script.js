
$('#btn-delete').click(function (e) {
    e.preventDefault()

    let id = $(this).attr("title");
    //console.log(id);
    $.ajax({
        type:"POST",
        data:"pedidoID=" + id,
        url:"deleteOrder.php",
        async:false

   }).done(function (data) {
       let message = $.parseJSON(data)["message"];
        console.log(data);
        $("#btn-delete").hide();

        $("#show-message").html(`${message}`);  

   }).fail(function (data) {

        console.log(data); 

        console.log("Houve um erro na remoção do pedido");
       
        
   });




});
