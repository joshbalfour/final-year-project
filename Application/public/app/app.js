// Setup the application
var app = angular.module('LCP', [
	'uiGmapgoogle-maps'
]);

// Configure Google maps
app.config(
    ['uiGmapGoogleMapApiProvider', function(GoogleMapApiProviders) {
        GoogleMapApiProviders.configure({
            china: true
        });
    }]
);
