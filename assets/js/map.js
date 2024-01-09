//Java Skript in Controll of the Overview Map
const dir = getDir();
const html_map = document.querySelector('.map');

//Default Start Values
const startPosition = [48.57390609055261, 13.460523755393428] //In Latitude and Longitude
const startZoom = 15;

var map;

function setUpMap() {
    //Leaflet
    // MapLibre GL JS does not handle RTL text by default, so we recommend adding this dependency to fully support RTL rendering. 
    maplibregl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.1/mapbox-gl-rtl-text.js')

    //Tile Set http://leaflet-extras.github.io/leaflet-providers/preview/index.html
    // https://tiles.stadiamaps.com/styles/stamen_toner_lite.json
    var Stamen_lite = L.maplibreGL({
        style: 'https://tiles.stadiamaps.com/styles/stamen_toner_lite.json',
        attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a>&copy; <a href="https://stamen.com/" target="_blank">Stamen Design</a>&copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a>&copy; <a href="https://www.openstreetmap.org/about/" target="_blank">OpenStreetMap contributors</a>',
    });



    var mapPosition = startPosition;
    var mapZoom = startZoom;
    //Overwrites
    if (overwriteAddress != null) {
        if (typeof overwriteAddress !== 'object') {
            if ((overwriteAddress.at(0) == '[' && overwriteAddress.at(overwriteAddress.length - 1) == ']') || (overwriteAddress.at(0) == '{' && overwriteAddress.at(overwriteAddress.length - 1) == '}')) {
                mapoverwriteAddress = JSON.parse(overwriteAddress);
            } else {
                mapoverwriteAddress = convertAddress(overwriteAddress);
            }
        } else {
            mapPosition = overwriteAddress;
        }
    }
    if (overwriteZoom != null) {
        mapZoom = overwriteZoom;
    }

    //Setup
    map = new L.Map(html_map, {
        attributionControl: false,
        zoomSnap: 0.5,
        zoomControl: interactive,
        boxZoom: interactive,
        doubleClickZoom: interactive,
        dragging: interactive,
        keyboard: interactive,
        scrollWheelZoom: interactive,

    });
    map.addLayer(Stamen_lite);
    map.setView(mapPosition, mapZoom);

    //Change attribution position to the Bottom Left
    L.control.attribution({
        position: 'bottomleft'
    }).addTo(map);

    //Add if Interactive
    if (interactive) {
        //Set Up User Position Controlls
        var compassSize = getCssVar('--map-location-arrow-size');
        L.control.locate({
            flyTo: true,
            keepCurrentZoomLevel: true,
            locateOptions: {
                enableHighAccuracy: true
            },
            compassStyle: {
                fillColor: "#2A93EE",
                fillOpacity: 1,
                weight: 0,
                color: "#fff",
                opacity: 1,
                radius: 9 * compassSize, // How far is the arrow is from the center of of the marker
                width: 9 * compassSize, // Width of the arrow
                depth: 6 * compassSize // Length of the arrow
            },
            markerStyle: {
                className: "leaflet-control-locate-marker",
                color: "#fff",
                fillColor: "#2A93EE",
                fillOpacity: 1,
                weight: 3 * compassSize,
                opacity: 1 * compassSize,
                radius: 9 * compassSize
            },
        }).addTo(map);

        //Add Dropdown City Selector
        var selectorHTML = '<div class="leaflet-bar leaflet-control"><select class="citySelector leaflet-bar-part leaflet-bar-part-single">';
        cities.forEach(city => { //PHP injected Array of all Selectable Cities
            selectorHTML += '<option value="' + city.address + '">' + city.title + '</option>'
        });
        selectorHTML += '</select></div>';

        //Adding the City Selector to the Map
        document.querySelector('.leaflet-top.leaflet-right').innerHTML += selectorHTML;

        //Adding the Button to Jump to the City
        var selectorButtonHTML = '<div class="leaflet-bar leaflet-control"><a href="#" role="button" aria-label="Jump to City" aria-disabled="false" class="citySelectorButton" title="Zur Stadt springen" style="outline: none;"><img src="' + dir + '../pictures/tracker.svg" alt="0"></a></select></div>';

        document.querySelector('.leaflet-top.leaflet-right').innerHTML += selectorButtonHTML;


        //Enter the in Value Saved Latitude and Longitude as the Map View when Selected
        document.querySelector('.citySelector').onchange = function(event) {
            var value = event.target.value;
            var coordinates = [];
            if ((value.at(0) == '[' && value.at(value.length - 1) == ']') || (value.at(0) == '{' && value.at(value.length - 1) == '}')) {
                coordinates = JSON.parse(value);
            } else {
                coordinates = convertAddress(value);
            }
            //Set the Cords
            map.setView(coordinates);
        };

        //Jump to City on Button Press
        document.querySelector('.citySelectorButton').onclick = function(event) {
            var value = document.querySelector('.citySelector').value;
            var coordinates = [];
            if ((value.at(0) == '[' && value.at(value.length - 1) == ']') || (value.at(0) == '{' && value.at(value.length - 1) == '}')) {
                coordinates = JSON.parse(value);
            } else {
                coordinates = convertAddress(value);
            }
            map.setView(coordinates);
        }
    }


    //Marker
    var MarkerList = [];
    loadedLocationData.forEach(loc => {
        MarkerList.push(createMarker(loc.address, loc.coordinates, loc.theme, loc.title, loc.url)); //Gets the Data out of a Class created in PHP with all loaded Information
    });

    //Add all Marker & Labels to Map
    MarkerList.forEach(function(marker) {
        marker.bindTooltip(marker.title).openTooltip();
        //marker.bindPopup(marker.options['title']);
        marker.addTo(map);
    });

    if (interactive) {
        //Activating location Controls
        document.querySelector('.leaflet-control-locate-location-arrow').parentElement.click()
    }
}

/**
 * Funktion to convert Addresses to Latitude and Longitude Values using the OpenStreetMap Nominatim API
 * @param {string} address The address to be converted
 * @returns {JSON} JSON Object containing 'lat' and 'lon'
 */
function convertAddress(address) {
    console.log('Fetching Address for: \'' + address + '\'')
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + address, false);
    xmlhttp.send();
    var raw_address = JSON.parse(xmlhttp.response)[0];
    return { "lat": raw_address['lat'], "lon": raw_address['lon'] };
}

/**
 * Funktion to create a new Marker
 * @param {string} address as string
 * @param {Array} coordinates as Array or Null
 * @param {string} style Style of the Marker (assets/pictures/markers/marker-{style}.svg)
 * @param {string} title Titel of the Markers
 * @param {string} url Url the Marker links to
 * @returns {L.marker} a new Instanz of the Leaflet Marker Class
 */
function createMarker(position, coordinates, style, title, url) {
    //Create Marker Icon
    var markerFactor = getCssVar('--map-marker-size');
    var markerSize = [27 * markerFactor, 32 * markerFactor];
    var styleUrl = 'default';
    if (style != '') {
        styleUrl = style;
    }
    //Load the Icon according to the Style
    var icon = new L.Icon({
        iconUrl: dir + '../pictures/markers/marker-' + styleUrl + '.svg',
        iconSize: markerSize,
        iconAnchor: [markerSize[0] / 2, markerSize[1]]
    });

    //Check if Coordinates are set and if so use them else convert Address to a Position
    if (coordinates.hasOwnProperty('lat')) {
        position = coordinates;
    } else {
        position = convertAddress(position);
    }

    var out = L.marker(position, {
        title: title,
        icon: icon,
        keyboard: true,
        alt: 'Marker for' + title
    });
    out.on('click', function() {
        document.location = url;
    });
    return out;
}

registerOnLoad(setUpMap);