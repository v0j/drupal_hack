<?php
/**
 * field_coordinates field overrides
 */
?>
<div id="here-maps-container">
	<div id="mapContainer">
	</div>
</div>

<script type="text/javascript">
// here maps application credentials 
nokia.Settings.set("app_id", "cCBkFwdij4XRZJRJGl9v");
nokia.Settings.set("app_code", "lT2HDxaP36sMAlbbYR566Q");

var map = new nokia.maps.map.Display(
        document.getElementById("mapContainer"), {
                components: [new nokia.maps.map.component.Behavior()],
                center: [14.5826, 120.9786]
});

// Create a route manager
var router = new nokia.maps.routing.Manager();

// Create waypoints
var waypoints = new nokia.maps.routing.WaypointParameterList();

// scan variable then use this snippet:
/*
waypoints.addCoordinate(
        new nokia.maps.geo.Coordinate(14.5834846,120.9808175)
);

waypoints.addCoordinate(
        new nokia.maps.geo.Coordinate(14.5797777,120.9803455)
);
*/
var modes = [{
        type: "shortest",
        transportModes: ["car"],
        options: "avoidTollroad",
        trafficMode: "default"
}];

var onRouteCalculated = function (observedRouter, key, value) {
        if (value == "finished") {
                var routes = observedRouter.getRoutes();

                // Create the default map representation of a route
                var mapRoute = new nokia.maps.routing.component.RouteResultSet(routes[0]).container;
                map.objects.add(mapRoute);

                // Zoom to the bounding box of the route
                map.zoomTo(mapRoute.getBoundingBox(), false, "default");
        } else if (value == "failed") {
                alert("The routing request failed.");
        }
};

// Add the observer function to the router's "state" property
router.addObserver("state", onRouteCalculated);

var iteneraryData = [<?php foreach ($items as $delta => $item): print '['.render($item).'],'; endforeach; ?>];
jQuery.each(iteneraryData, function( key, value ) {
	waypoints.addCoordinate(
	    new nokia.maps.geo.Coordinate(value[0], value[1])
	);
});

// Calculate the route (and call onRouteCalculated afterwards)
router.calculateRoute(waypoints, modes);
</script>
