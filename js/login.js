$(document).ready(function() {
    $('#sign').click(function(){
        var data = {name : $('#name').val(), password : $('#password').val()};

        $.ajax({
        type: "POST",
        url: "./php/login.php",
        data: data,
        success: function(data, dataType){  
            if(data == "OK"){
                window.location.href = "./php/index.php";
            } else {
                $('#msg').html(data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Error : ' + errorThrown);
        }
        });
        return false;
    });
});