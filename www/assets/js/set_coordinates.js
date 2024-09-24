import {Map, View, Feature} from 'ol';
import {fromLonLat, toLonLat} from 'ol/proj';
import {Point} from 'ol/geom';
import TileLayer from 'ol/layer/Tile';
import OSM from 'ol/source/OSM';
import {Vector as SourceVector} from 'ol/source';
import {Vector as LayerVector} from 'ol/layer';
// import {GeometryLayout} from "ol/geom/Geometry";
import {Icon, Style} from "ol/style";

const setCoordinatesModal = document.getElementById("setCoordinatesModal");

if (setCoordinatesModal) {
    let map;
    let setCoordinatesLayerVector;
    let view = new View({
        center: fromLonLat([104.27296760599522, 52.28720573818367]),
        zoom: 10,
    });
    let geoWatchId;

    function setPosition(position) {
        view.setCenter(fromLonLat([position.coords.longitude, position.coords.latitude]));
        view.setZoom(15);
        setMarker(position.coords.latitude, position.coords.longitude);
    }

    function errorPosition(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("К сожалению Вы запретили доступ к вашему местоположению, вы можете включить его к настройках браузера");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Служба геолокации недоступна");
                break;
            case error.TIMEOUT:
                alert("К сожалению, мы не смогли определить ваше местоположение");
                break;
            case error.UNKNOWN_ERROR:
                alert("Произошла непредвиденная ошибка при определении вашего местоположения");
                break;
        }
    }

    function setMarker(lat, lon) {

        if (typeof setCoordinatesLayerVector !== "undefined") {
            map.removeLayer(setCoordinatesLayerVector);
        }


        $("input[data-type=setLat]").val(lat);
        $("input[data-type=setLon]").val(lon);

        let iconFeatures = new Feature({
            geometry: new Point(fromLonLat([lon, lat]))
        });

        iconFeatures.setStyle(new Style({
            image: new Icon({
                color: '#BADA55',
                crossOrigin: 'anonymous',
                src: '/images/map-marker.svg',
                height: 35,
                anchor: [0.5, 1]
            })
        }));

        let sourceVector = new SourceVector({features: [iconFeatures]});
        setCoordinatesLayerVector = new LayerVector({source: sourceVector})

        map.addLayer(setCoordinatesLayerVector);
    }


    $(setCoordinatesModal).find("button:last").on("click", function() {
        let modal = bootstrap.Modal.getInstance(setCoordinatesModal);
        modal.hide();
    });

    setCoordinatesModal.addEventListener("shown.bs.modal", function() {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(setPosition, errorPosition);
            geoWatchId = navigator.geolocation.watchPosition(setPosition);
        }

        if (typeof map === "undefined") {
            map = new Map({
                target: 'setCoordinatesCnt',
                layers: [
                    new TileLayer({
                        source: new OSM(),
                    })
                ],
            });

            map.setView(view);
        }

         if (typeof jsEditObjectLocation !== "undefined") {

            if (typeof setCoordinatesLayerVector !== "undefined") {
                map.removeLayer(setCoordinatesLayerVector);
            }

            let latLon = fromLonLat([jsEditObjectLocation.lat, jsEditObjectLocation.lon]);

            let iconFeatures = new Feature({
                geometry: new Point(latLon)
            });

            iconFeatures.setStyle(new Style({
                image: new Icon({
                    color: '#BADA55',
                    crossOrigin: 'anonymous',
                    src: '/images/map-marker.svg',
                    height: 35,
                    anchor: [0.5, 1]
                })
            }));

            let sourceVector = new SourceVector({features: [iconFeatures]});
            setCoordinatesLayerVector = new LayerVector({source: sourceVector})

            map.addLayer(setCoordinatesLayerVector);


        }

        map.on('singleclick', function(e) {

            if (navigator.geolocation) {
                navigator.geolocation.clearWatch(geoWatchId);
            }

            let latLon = toLonLat(e.coordinate);
            setMarker(latLon[1], latLon[0]);
        })
    });
}

