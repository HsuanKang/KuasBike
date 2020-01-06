/*#home*/

$(document).on("pagecreate","#home",function(){
    var x = document.getElementById("data");
    var y = document.getElementById("P1_D1");
    getLocation();
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var latlon = new google.maps.LatLng(lat, lon)
        var mapholder = document.getElementById("data")
        mapholder.style.height = '350px';
        mapholder.style.width = '100%';

        var myOptions = {
            center:latlon,
            zoom:14,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            mapTypeControl:false,
            navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  }
        var map = new google.maps.Map(mapholder, myOptions);
        var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
        var markers=[];
        var url = "bike.json";
        var jqxhr = $.getJSON(url, function(arr) {
                //console.log("success");
                var i;
                for(i = 0; i < arr.length; i++) {
					search(arr[i]);
                }
                var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
				function search(place){
					var latlon = new google.maps.LatLng(place.lat, place.lng);
                    marker = new google.maps.Marker({
                        position:latlon,
                        map:map,
                        title:place.sna,
                        icon:"pin.png"});
                    markers.push(marker);
					var placeLoc = {
						  "lat" : place.lat,
						  "lng" : place.lng
					}; 
					var content = '<font color="#FF8800"><b>' + arr[i].sno + '&nbsp;&nbsp; ' + arr[i].sarea + '</b></font></br>場站名稱：' + arr[i].sna + '</br>可借車位數：' + arr[i].sbi +
                              '</br>可還車位數：' + arr[i].bemp + '</br>總停車格數：' + arr[i].tot;
					var infowindow = new google.maps.InfoWindow({
					content: arr[i].sna
					});
					
                    marker.addListener('click', function() {
                        //console.log("click");
                        infowindow.open(map,this);
                        y.innerHTML=content;
                      });
				}
        });
    }

    function showError(error) {
        switch(error.code) {
        case error.PERMISSION_DENIED:
          x.innerHTML = "User denied the request for Geolocation."
          break;
        case error.POSITION_UNAVAILABLE:
          x.innerHTML = "Location information is unavailable."
          break;
        case error.TIMEOUT:
          x.innerHTML = "The request to get user location timed out."
          break;
        case error.UNKNOWN_ERROR:
          x.innerHTML = "An unknown error occurred."
          break;
        }
    }

});

/*#Timerpage*/

$(document).on("pagecreate","#Timerpage",function(){
		var c=0;
		var t;
		$("#TP_B1_start").on("vclick",function(event){
			timedCount();
			function timedCount(){
				document.getElementById('showtime').innerHTML=c;
				c=c+1;
				t=setTimeout(timedCount,1000);
				totalmoney();
			}
		});	
		$("#TP_B2_end").on("vclick",function(event){
			
			stopCount();
			function stopCount(){
			document.getElementById('showtime').innerHTML=c;
			c=0;
			setTimeout("",0);
			clearTimeout(t);
			}
			
		});
		
		

			
			
			function totalmoney(){
				money=Math.floor(c/5);
				document.getElementById('money').innerHTML=money;
				if(c<=3){
					document.getElementById('money').innerHTML="$"+money+"<br>(不收費)";
				}else if(c>3 && c<=24){
					money=(Math.floor(c/3))*10;
					document.getElementById('money').innerHTML="$"+money+"<br>(10元收費)";	
				}else if(c>24 && c<=48){
					money=80+((Math.floor((c-24)/3))*20);
					document.getElementById('money').innerHTML="$"+money+"<br>(20元收費)";	
				}else {
					money=240+((Math.floor((c-48)/3))*30);
					document.getElementById('money').innerHTML="$"+money+"<br>(30元收費)";
				}
			}
		
		
    });
    
    //規劃路線
    $(document).on("pagecreate","#predict",function(){
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var centerPos; //中心位置
        var map;
        var infowindow;
        var x = document.getElementById("info");
            getLocation();
            var nowlan; //目前緯度
            var nowlon; //目前經度
    
        function getLocation() {
            if (navigator.geolocation) {
                var options = {timeout:10000};
                navigator.geolocation.getCurrentPosition(showPosition,showError,options);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
    
            function showPosition(position) {
                nowlan = position.coords.latitude;
                nowlon = position.coords.longitude;
                centerPos = new google.maps.LatLng(nowlan, nowlon);
                var thisMap = document.getElementById("map");
                thisMap.style.height = '350px';
                thisMap.style.width = '100%';
    
                map = new google.maps.Map(thisMap,{center: centerPos,zoom: 15}); // 將中心位置地圖存進map物件裡
    
                infowindow = new google.maps.InfoWindow();
                var url = "bike.json";
                var jqxhr = $.getJSON(url, function(arr) {
                    console.log("locatsuccess");
                    var i;
                    for(i = 0; i < arr.length; i++) {
                        search(arr[i]);
                    }
                function search(place){
                    var latlon = new google.maps.LatLng(place.lat,place.lng);
                          marker = new google.maps.Marker({position:latlon,map:map,title:place.sna}); 
                    content = place.sna;
                    var infowindow = new google.maps.InfoWindow({content: content});
    
                    marker.addListener('click', function() {
                        infowindow.open(map, this); //this(marker)
                    });
            
    
        
            google.maps.event.addListener(marker,"dblclick",function() {
                directionsDisplay.setMap(map);
                directionsService.route({ //路徑設置
                    origin: centerPos, //中心點
                    destination: latlon, //要搜尋的點
                    travelMode: 'WALKING'//移動方式
                },function(response, status) {
                        if (status === 'OK') {
                            directionsDisplay.setDirections(response);
                            var dirStepArr = response.routes[0].legs[0]; //路徑陣列
                            var dirStep = dirStepArr.steps.length; //陣列長度
                            //alert(dirStep);
    
                            if (dirStep>0) { //路徑文字指示顯示
                                var stepString = "";
                                for (var i=0;i<dirStep;i++) {
                                    stepString += dirStepArr.steps[i].instructions.trim();
                                }
                                // alert(stepString);
                                x.innerHTML = stepString;
                            }
                            } else {
                                window.alert('Directions request failed due to ' + status);
                            }
                    });
                });
            };
        });
    }
    
            function showError(error) {
            switch(error.code) {
            case error.PERMISSION_DENIED:
              x.innerHTML = "User denied the request for Geolocation."
              break;
            case error.POSITION_UNAVAILABLE:
              x.innerHTML = "Location information is unavailable."
              break;
            case error.TIMEOUT:
              x.innerHTML = "The request to get user location timed out."
              break;
            case error.UNKNOWN_ERROR:
              x.innerHTML = "An unknown error occurred."
              break;
                }
            }
    });