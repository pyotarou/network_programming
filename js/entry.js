$(document).ready(function() {
    $('#entry').click(function(){
        //POSTメソッドで送るデータを定義する
        var data = {name : $('#name').val(), password : $('#password').val(), passwordCheck: $('#passwordCheck').val()};

        //Ajax通信メソッド
        $.ajax({
        type: "POST",
        url: "./php/entry.php",
        data: data,
        //Ajax通信が成功した場合に呼び出されるメソッド
        success: function(data, dataType){
            if(data == "OK"){
                window.location.href = "./login.html";
            } else {
                $('#msg').html(data);
            }
        },
        //Ajax通信が失敗した場合に呼び出されるメソッド
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Error : ' + errorThrown);
        }
        });
        return false;
    });
});