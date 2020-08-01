$(function(){
    var map = null;
    var directionsService = null;
    var directionsDisplay = null;
    var menuWidth = 300;

    $.ajaxSetup({
        cache:false,
        ifModified: true,
        global: true
    })

    // Ajaxリクエストでサーバーサイドがセッションタイムアウトしていた場合の処理
    $(document).on("ajaxComplete",function(e,xhr,status){
        console.log("ajaxComplete");
        if(xhr.readyState==4 && xhr.status==200){
            var redirectUrl = xhr.getResponseHeader("ajaxRedirect");
            if(redirectUrl){
                console.log(redirectUrl);
                window.location.href = redirectUrl;
            }
        }else if( xhr.readyState == 4 && xhr.status == 500){
            alert("Ajax処理中にエラーが発生しました。");
        }
    });

    var initMap = function() {
        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer;
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: 35, lng: 137}
        });
    }
    
    var routing = function() {
        directionsDisplay.setMap(map);
        directionsService.route({
            origin: $('#departure').val(),
            destination: $('#destination').val(),
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    };

	var clearRoute = function() {
		directionsDisplay.setMap(null);
    };	
    
    var share = function(){
        user = window.prompt("共有するユーザのIDを入力してください", "");

        if(user != null){
            var data = {to_id : String(user)};
            
            $.ajax({
                type: "POST",
                url: "./share.php",
                data: data,
                success: function(data, dataType){
                    alert(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert('Error : ' + errorThrown);
                }
            });
        } else{                                    // 空の場合やキャンセルした場合は警告ダイアログを表示
            window.alert('キャンセルされました');
        }
    }
    
    var select = function(){
        var val = $('[name=select_histry]').val();
        var data = {id:val};
        $.ajax({
            type: "POST",
            url: "./show_histry.php",
            data: data,
            success: function(data, dataType){
                $('#histry').html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                alert('Error : ' + errorThrown);
            }
        });
    }

    $('[name=select_histry]').change(function() {
        select();
    });

    var resize = function() {
        $('#map-content').height($(window).height() - $('#nav-content').height());
        var w = $(window).width();
        if (w < 768) {
            $('#menu').width('100%');
            $('#map').width('100%');
            $('#menu').height('60%');
            $('#map').height('40%');
        } else {
            $('#menu').width(menuWidth + 'px');
            $('#map').width(w - $('#menu').width());
            $('#menu').height('100%');
            $('#map').height('100%');
        }
    }

    $(window).on('load', function() {
        initMap();
        resize();
        select();
        $('#route-btn').on('click', function(e) {
            var data = {departure : $('#departure').val(), destination: $('#destination').val()};
  
            $.ajax({
                type: "POST",
                url: "./histry.php",
                data: data,
                success: function(data, dataType){
                    var val = $('[name=select_histry]').val();
                    var id = $("#id span").text();
                    if(val == id){
                        $('#histry').append(data);
                    }
                    routing();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert('Error : ' + errorThrown);
                }
            });
        });

        $('#share-btn').on('click', function(e) {
			share();
		});

        $('#clear-btn').on('click', function(e) {
			clearRoute();
		});
    });

    $(window).on('resize', resize);
});