"use strict";
var styleArray = [{
    "featureType": "all",
    "elementType": "geometry",
    "stylers": [{
        "color": "#998061"
    }]
},
    {
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [{
            "gamma": 0.01
        },
            {
                "lightness": 20
            },
            {
                "weight": "1.39"
            },
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [{
            "weight": "0.96"
        },
            {
                "saturation": "9"
            },
            {
                "visibility": "on"
            },
            {
                "color": "#000000"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [{
            "visibility": "off"
        }]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 30
        },
            {
                "saturation": "9"
            },
            {
                "color": "#29446b"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{
            "saturation": 20
        }]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 20
        },
            {
                "saturation": -20
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{
            "lightness": 10
        },
            {
                "saturation": -30
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
            "color": "#193a55"
        }]
    },
    {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
            "saturation": 25
        },
            {
                "lightness": 25
            },
            {
                "weight": "0.01"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
            "lightness": -20,
            "color": '#9fcbfc'
        }]
    }
]


var mapsID = document.getElementById("maps");
var dataLatitude = mapsID.getAttribute('data-latitude');
var dataLongitude = mapsID.getAttribute('data-longitude');


var mapOptions = {
    center: new google.maps.LatLng(dataLatitude, dataLongitude),
    zoom: 10,
    styles: styleArray,
    scrollwheel: false,
    backgroundColor: '#e5ecff',
    mapTypeControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
    mapOptions);
var myLatlng = new google.maps.LatLng(dataLatitude, dataLongitude);
var marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    icon: {
        url: "./assets/images/map-marker.png"
    }
});
