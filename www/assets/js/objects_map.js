import Feature from 'ol/Feature';
import GeoJSON from 'ol/format/GeoJSON';
import Map from 'ol/Map';
import View from 'ol/View';
import {
    Circle as CircleStyle,
    Fill,
    Icon,
    Stroke,
    Style,
    Text,
} from 'ol/style';
import {Cluster, Vector as VectorSource, XYZ} from 'ol/source';
import {LineString, Point, Polygon} from 'ol/geom';
import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer';
import {createEmpty, extend, getHeight, getWidth} from 'ol/extent';
import {fromLonLat} from 'ol/proj';
import OSM from "ol/source/OSM";

const circleDistanceMultiplier = 1;
const circleFootSeparation = 28;
const circleStartAngle = Math.PI / 2;


const outerCircleFill = new Fill({
    color: 'rgba(255, 153, 102, 0.3)',
});
const innerCircleFill = new Fill({
    color: 'rgba(255, 165, 0, 0.7)',
});
const textFill = new Fill({
    color: '#fff',
});
const textStroke = new Stroke({
    color: 'rgba(0, 0, 0, 0.6)',
    width: 3,
});
const innerCircle = new CircleStyle({
    radius: 14,
    fill: innerCircleFill,
});
const outerCircle = new CircleStyle({
    radius: 20,
    fill: outerCircleFill,
});

const icon = new Icon({
    src: '/images/map-marker.svg',
    height: 35,
    anchor: [0.5, 1]
});

/**
 * Single feature style, users for clusters with 1 feature and cluster circles.
 * @param {Feature} clusterMember A feature from a cluster.
 * @return {Style} An icon style for the cluster member's location.
 */
function clusterMemberStyle(clusterMember) {
    return new Style({
        geometry: clusterMember.getGeometry(),
        image: icon,
    });
}

let clickFeature, clickResolution;
/**
 * Style for clusters with features that are too close to each other, activated on click.
 * @param {Feature} cluster A cluster with overlapping members.
 * @param {number} resolution The current view resolution.
 * @return {Style|null} A style to render an expanded view of the cluster members.
 */
function clusterCircleStyle(cluster, resolution) {
    if (cluster !== clickFeature || resolution !== clickResolution) {
        return null;
    }
    const clusterMembers = cluster.get('features');
    const centerCoordinates = cluster.getGeometry().getCoordinates();
    return generatePointsCircle(
        clusterMembers.length,
        cluster.getGeometry().getCoordinates(),
        resolution,
    ).reduce((styles, coordinates, i) => {
        const point = new Point(coordinates);
        const line = new LineString([centerCoordinates, coordinates]);
        styles.unshift(
            new Style({
                geometry: line,
                stroke: convexHullStroke,
            }),
        );
        styles.push(
            clusterMemberStyle(
                new Feature({
                    ...clusterMembers[i].getProperties(),
                    geometry: point,
                }),
            ),
        );
        return styles;
    }, []);
}

/**
 * From
 * https://github.com/Leaflet/Leaflet.markercluster/blob/31360f2/src/MarkerCluster.Spiderfier.js#L55-L72
 * Arranges points in a circle around the cluster center, with a line pointing from the center to
 * each point.
 * @param {number} count Number of cluster members.
 * @param {Array<number>} clusterCenter Center coordinate of the cluster.
 * @param {number} resolution Current view resolution.
 * @return {Array<Array<number>>} An array of coordinates representing the cluster members.
 */
function generatePointsCircle(count, clusterCenter, resolution) {
    const circumference =
        circleDistanceMultiplier * circleFootSeparation * (2 + count);
    let legLength = circumference / (Math.PI * 2); //radius from circumference
    const angleStep = (Math.PI * 2) / count;
    const res = [];
    let angle;

    legLength = Math.max(legLength, 35) * resolution; // Minimum distance to get outside the cluster icon.

    for (let i = 0; i < count; ++i) {
        // Clockwise, like spiral.
        angle = circleStartAngle + i * angleStep;
        res.push([
            clusterCenter[0] + legLength * Math.cos(angle),
            clusterCenter[1] + legLength * Math.sin(angle),
        ]);
    }

    return res;
}

let hoverFeature;


function clusterStyle(feature) {
    const size = feature.get('features').length;
    if (size > 1) {
        return [
            new Style({
                image: outerCircle,
            }),
            new Style({
                image: innerCircle,
                text: new Text({
                    text: size.toString(),
                    fill: textFill,
                    stroke: textStroke,
                }),
            }),
        ];
    }
    const originalFeature = feature.get('features')[0];
    return clusterMemberStyle(originalFeature);
}

const vectorSource = new VectorSource({
    features: new GeoJSON().readFeatures(objectsMapFeatures, {
        dataProjection: 'EPSG:4326',
        featureProjection: 'EPSG:3857'
    })
});

const clusterSource = new Cluster({
    distance: 35,
    source: vectorSource,
});

// Layer displaying the clusters and individual features.
const clusters = new VectorLayer({
    source: clusterSource,
    style: clusterStyle,
});

// Layer displaying the expanded view of overlapping cluster members.
const clusterCircles = new VectorLayer({
    source: clusterSource,
    style: clusterCircleStyle,
});

let currentFeature;
const info = document.getElementById('info');

const displayFeatureInfo = function (pixel, target) {
    const feature = target.closest('.ol-control')
        ? undefined
        : map.forEachFeatureAtPixel(pixel, function (feature) {
            return feature;
        });

    if (feature) {
        info.style.left = pixel[0] + 'px';
        info.style.top = pixel[1] + 'px';
        console.log(feature.get("features")[0].get('tooltip_content'));
        if (feature !== currentFeature && feature.get("features").length === 1) {
            info.style.visibility = 'visible';
            info.innerText = feature.get("features")[0].get('tooltip_content');
        }
    } else {
        info.style.visibility = 'hidden';
    }
    currentFeature = feature;
};


const map = new Map({
    layers: [
        new TileLayer({
            source: new OSM()
        }),
        clusters,
        clusterCircles
    ],
    target: 'catalogObjectsMap',
    view: new View({
        center: fromLonLat([104.27296760599522, 52.28720573818367]),
        zoom: 10
    })
});

map.on('pointermove', (event) => {
    if (event.dragging) {
        info.style.visibility = 'hidden';
        currentFeature = undefined;
        return;
    }
    const pixel = map.getEventPixel(event.originalEvent);
    displayFeatureInfo(pixel, event.originalEvent.target);

    clusters.getFeatures(event.pixel).then((features) => {
        if (features[0] !== hoverFeature) {
            // Display the convex hull on hover.
            hoverFeature = features[0];

            // Change the cursor style to indicate that the cluster is clickable.
            map.getTargetElement().style.cursor =
                hoverFeature ? 'pointer' : '';
        }
    });
});

map.on('click', (event) => {
    clusters.getFeatures(event.pixel).then((features) => {
        if (features.length > 0) {
            const clusterMembers = features[0].get('features');

            if (clusterMembers.length === 1) {
                document.location.href = "/Catalog/Objects/"+clusterMembers[0].get("source_id")+"/About";

            } else if (clusterMembers.length > 1) {
                // Calculate the extent of the cluster members.
                const extent = createEmpty();
                clusterMembers.forEach((feature) =>
                    extend(extent, feature.getGeometry().getExtent()),
                );
                const view = map.getView();
                const resolution = map.getView().getResolution();
                if (
                    view.getZoom() === view.getMaxZoom() ||
                    (getWidth(extent) < resolution && getHeight(extent) < resolution)
                ) {
                    // Show an expanded view of the cluster members.
                    clickFeature = features[0];
                    clickResolution = resolution;
                    clusterCircles.setStyle(clusterCircleStyle);
                } else {
                    // Zoom to the extent of the cluster members.
                    view.fit(extent, {duration: 500, padding: [50, 50, 50, 50]});
                }
            }
        }
    });
});