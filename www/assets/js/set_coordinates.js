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

    $(setCoordinatesModal).find("button:last").on("click", function() {
        let modal = bootstrap.Modal.getInstance(setCoordinatesModal);
        modal.hide();
    });

    setCoordinatesModal.addEventListener("shown.bs.modal", function() {

        if (typeof map === "undefined") {
            map = new Map({
                target: 'setCoordinatesCnt',
                layers: [
                    new TileLayer({
                        source: new OSM(),
                    })
                ],
            });

            map.setView(new View({
                center: fromLonLat([104.27296760599522, 52.28720573818367]),
                zoom: 10,
            }));
        }

        let setCoordinatesLayerVector;

        map.on('singleclick', function(e) {

            if (typeof setCoordinatesLayerVector !== "undefined") {
                map.removeLayer(setCoordinatesLayerVector);
            }

            let latLon = toLonLat(e.coordinate);

            $("input[data-type=setLat]").val(latLon[0]);
            $("input[data-type=setLon]").val(latLon[1]);

            let iconFeatures = new Feature({
                geometry: new Point(e.coordinate)
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
        })
    });
}

