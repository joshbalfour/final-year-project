// Setup the application
var app = angular.module('LCP', [
	'uiGmapgoogle-maps'
]);

// Configure Google maps
app.config(
    ['uiGmapGoogleMapApiProvider, $compileProvider', function(GoogleMapApiProviders, $compileProvider) {
        GoogleMapApiProviders.configure({
            china: false 
        });
        $compileProvider.debugInfoEnabled(false);
    }]
);
