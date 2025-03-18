import OSRMv1 from "leaflet-routing-machine/src/osrm-v1";

export default OSRMv1.extend({
    options: {
        serviceUrl: 'http://api.map4d.vn/sdk/route',
        profile: 'mapbox/driving',
        useHints: false
    },

    initialize: function(accessToken, options) {
        L.Routing.OSRMv1.prototype.initialize.call(this, options);
        this.options.requestParameters = this.options.requestParameters || {};
        /* jshint camelcase: false */
        this.options.requestParameters.access_token = accessToken;
        /* jshint camelcase: true */
    }
});