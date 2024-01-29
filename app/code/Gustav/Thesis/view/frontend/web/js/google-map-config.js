define(['jquery', 'jquery-ui-modules/widget'], function ($) {
    'use strict';

    $.widget('gustav.googleMapConfig', {
        options: {
            map: null,
            mapCenterLatitude: 59.3293,
            mapCenterLongitude: 18.0686,
            markers: {},
            currentInfowindow: null,
        },

        _create: function () {
            this.initMap();
            this._bindEvents();
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
        },

        _bindEvents: function () {
            const self = this;

            $(document).on('storeListUpdated', function (event, stores) {
                self._updateMarkers(stores);
            });

            $(document).on('storeSelected', function (event, storeId) {
                if (self.options.markers[storeId]) {
                    const marker = self.options.markers[storeId];

                    if (self.options.currentInfowindow) {
                        self.options.currentInfowindow.close();
                    }
                    marker.infowindow.open(self.map, marker);
                    self.options.currentInfowindow = marker.infowindow;
                }
            });
        },

        _updateMarkers: function (stores) {
            const self = this;

            Object.values(self.options.markers).forEach(function (marker) {
                marker.setMap(null);
            });
            self.options.markers = {};

            stores.forEach(function (store) {
                const marker = new google.maps.Marker({
                    position: new google.maps.LatLng(
                        store.latitude,
                        store.longitude
                    ),
                    map: self.map,
                    title: store.name,
                });

                const infowindowContent =
                    `<div><strong>${store.name}</strong><br>` +
                    `Address: ${store.address},<br>` +
                    `${store.city}, ${store.postcode}, ${store.country}<br>` +
                    `Phone: ${store.phone}<br>` +
                    `Open: ${store.hours}</div>`;
                const infowindow = new google.maps.InfoWindow({
                    content: infowindowContent,
                });

                marker.addListener('click', function () {
                    if (self.options.currentInfowindow) {
                        self.options.currentInfowindow.close();
                    }
                    infowindow.open(self.map, marker);
                    self.options.currentInfowindow = infowindow;
                });

                self.options.markers[store.id] = marker;
                marker.infowindow = infowindow;
            });
        },
    });

    return $.gustav.googleMapConfig;
});
