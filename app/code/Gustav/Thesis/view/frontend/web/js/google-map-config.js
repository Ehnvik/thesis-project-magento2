define(['jquery', 'jquery-ui-modules/widget'], function ($) {
    'use strict';

    $.widget('gustav.googleMapConfig', {
        options: {
            map: null,
            stores: [],
            mapCenterLatitude: 59.3293,
            mapCenterLongitude: 18.0686,
        },

        _create: function () {
            this.initMap();
        },

        initMap: function () {
            const self = this;
            const mapOptions = {
                center: new google.maps.LatLng(
                    self.options.mapCenterLatitude,
                    self.options.mapCenterLongitude
                ),
                zoom: 8,
            };

            self.map = new google.maps.Map(
                document.getElementById('map'),
                mapOptions
            );

            self.generateMarkers();
        },

        generateMarkers: function () {
            const self = this;

            $.each(self.options.stores, function (index, store) {
                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(
                        store.latitude,
                        store.longitude
                    ),
                    map: self.map,
                    title: store.name,
                });

                marker.addListener('click', function () {
                    const infowindowContent =
                        '<div><strong>' +
                        store.name +
                        '</strong><br>' +
                        'Address: ' +
                        store.address +
                        ',<br> ' +
                        store.city +
                        ', ' +
                        store.postcode +
                        ', ' +
                        store.country +
                        '<br>' +
                        'Phone: ' +
                        store.phone +
                        '<br>' +
                        'Open: ' +
                        store.hours +
                        '</div>';
                    const infowindow = new google.maps.InfoWindow({
                        content: infowindowContent,
                    });

                    infowindow.open(self.map, marker);
                });
            });
        },
    });

    return $.gustav.googleMapConfig;
});
