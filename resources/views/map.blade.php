<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GeoJSON API</title>
  <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="{{ asset('assets/lib/fontawesome-marker/dist/leaflet.awesome-markers.css') }}">
  <style>
    #map {
      margin-top: 56px;
      height: calc(100vh - 56px);
      width: 100%;
    }

    .progress {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      z-index: 9999;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa-solid fa-earth-asia"></i> GeoJSON API</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i
                class="fa-solid fa-circle-info"></i> Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i>
              Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="map"></div>

  <div class="progress" role="progressbar" aria-label="Animated striped" aria-valuenow="100" aria-valuemin="0"
    aria-valuemax="100">
    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
  </div>

  <!-- Modal Info -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="infoModalLabel"><i class="fa-solid fa-circle-info"></i> Info</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5 class="mb-3">Leaflet GeoJSON API PostGIS</h5>
          <p class="mb-0">Stack:</p>
          <ul>
            <li>PHP Framework Laravel</li>
            <li>PostgreSQL - PostGIS</li>
          </ul>
          <p class="mb-0">Library:</p>
          <ul>
            <li>Leaflet JS</li>
            <li>Leaflet Fontawesome Marker</li>
            <li>Bootstrap 5</li>
            <li>Font Awesome 6</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
              class="fa-solid fa-circle-xmark"></i> Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="{{ asset('assets/lib/fontawesome-marker/dist/leaflet.awesome-markers.js') }}"></script>
  <script>
    // init map
    var map = L.map('map').setView([-7.0027921, 110.4345703], 14);

    // bbox map
    var bounds = map.getBounds();
    var minll = bounds.getSouthWest();
    var maxll = bounds.getNorthEast();
    var bbox = minll.lng + ',' + minll.lat + ',' + maxll.lng + ',' + maxll.lat;
    console.log(bbox);

    var zoom = map.getZoom();
    console.log(zoom);

    // Creates a red marker with the coffee icon
    var gerejaMarker = L.AwesomeMarkers.icon({
      icon: 'fa-cross',
      markerColor: 'red',
      stylePrefix: 'fas',
      prefix: 'fa',
    });
    var masjidMarker = L.AwesomeMarkers.icon({
      icon: 'fa-star-and-crescent',
      markerColor: 'green',
      stylePrefix: 'fas',
      prefix: 'fa',
    });
    var puraMarker = L.AwesomeMarkers.icon({
      icon: 'fa-torii-gate',
      markerColor: 'blue',
      stylePrefix: 'fas',
      prefix: 'fa',
    });
    var viharaMarker = L.AwesomeMarkers.icon({
      icon: 'fa-vihara',
      markerColor: 'purple',
      stylePrefix: 'fas',
      prefix: 'fa',
    });
    var lainnyaMarker = L.AwesomeMarkers.icon({
      icon: 'fa-hands-praying',
      markerColor: 'orange',
      stylePrefix: 'fas',
      prefix: 'fa',
    });


    // Tile Layer Basemap
    var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: '© OpenStreetMap contributors',
    });

    var Esri_WorldImagery = L.tileLayer(
      'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri — Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
      });

    var rupabumiindonesia = L.tileLayer(
      'https://geoservices.big.go.id/rbi/rest/services/BASEMAP/Rupabumi_Indonesia/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Badan Informasi Geospasial'
      });

    var Google_Roadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
      attribution: 'Google'
    });

    var Google_Satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
      attribution: 'Google'
    });

    // Menambahkan basemap ke dalam peta
    Google_Roadmap.addTo(map);

    // GeoJSON jalan
    var colorJalan = {
      "tol": "#800000", // zoom min 5
      "arteri": "#ff0000", // zoom min 10
      "kolektor": "#ff8c00", // zoom min 12
      "lokal": "#cc33ff", // zoom min 14
      "lain": "#778899", // zoom min 16
    };
    var weightJalan = {
      "tol": 8,
      "arteri": 6,
      "kolektor": 4,
      "lokal": 2,
      "lain": 2,
    };
    var jalan = L.geoJSON(null, {
      // Style
      style: function(feature) {
        return {
          color: colorJalan[feature.properties.fcode],
          weight: weightJalan[feature.properties.fcode],
          opacity: 1,
        };
      },
      // onEachFeature
      onEachFeature: function(feature, layer) {
        // variable popup content
        var popup_content = "Status: " + feature.properties.remark + "<br>" +
          "Kelas: " + feature.properties.fcode + "<br>" +
          "Code: " + feature.properties.lcode + "<br>" +
          "Length: " + feature.properties.length + " m";

        layer.on({
          click: function(e) {
            jalan.bindPopup(popup_content);
          },
          mouseover: function(e) {
            jalan.bindTooltip(feature.properties.remark);

            // highlight
            layer.setStyle({
              weight: 8,
              color: 'cyan',
              opacity: 1,
            });
          },
          mouseout: function(e) {
            jalan.resetStyle(e.target);
          },
        });
      },
    });
    $.getJSON("{{ route('api.jalans') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
      jalan.addData(data);
      map.addLayer(jalan);
    });

    var batasdesa = L.geoJSON(null, {
      // Style
      style: function(feature) {
        return {
          color: "gray",
          weight: 1,
          opacity: 1,
          fillColor: "white",
          fillOpacity: 0.1,
        };
      },
      // onEachFeature
      onEachFeature: function(feature, layer) {
        // variable popup content
        var popup_content = "Desa: " + feature.properties.wadmkd + "<br>" +
          "Kecamatan: " + feature.properties.wadmkc + "<br>" +
          "Kabupaten: " + feature.properties.wadmkk + "<br>" +
          "Provinsi: " + feature.properties.wadmpr + "<br>" +
          "Area: " + (feature.properties.area / 10000).toFixed(2) + " Ha";

        layer.on({
          click: function(e) {
            batasdesa.bindPopup(popup_content);
          },
          mouseover: function(e) {
            batasdesa.bindTooltip(feature.properties.wadmkd);

            // highlight
            layer.setStyle({
              weight: 4,
              color: 'gray',
              opacity: 1,
              fillColor: "cyan",
              fillOpacity: 0.3,
            });
          },
          mouseout: function(e) {
            batasdesa.resetStyle(e.target);
          },
        });
      },
    });
    $.getJSON("{{ route('api.batas.desa') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
      batasdesa.addData(data); // Menambahkan data ke dalam batasdesa variable
      map.addLayer(batasdesa); // Menambahkan GeoJSON batasdesa ke dalam peta
    });

    var bataskecamatan = L.geoJSON(null, {
      // Style
      style: function(feature) {
        return {
          color: "black",
          weight: 2,
          opacity: 1,
          fillColor: "white",
          fillOpacity: 0,
        };
      },
      // onEachFeature
      onEachFeature: function(feature, layer) {
        // variable popup content
        var popup_content = "Kecamatan: " + feature.properties.wadmkc + "<br>" +
          "Kabupaten: " + feature.properties.wadmkk + "<br>" +
          "Provinsi: " + feature.properties.wadmpr + "<br>" +
          "Area: " + (feature.properties.area / 10000).toFixed(2) + " Ha";

        layer.on({
          click: function(e) {
            bataskecamatan.bindPopup(popup_content);
          },
          mouseover: function(e) {
            bataskecamatan.bindTooltip(feature.properties.wadmkc);

            // highlight
            layer.setStyle({
              weight: 4,
              color: 'black',
              opacity: 1,
              fillColor: "cyan",
              fillOpacity: 0.3,
            });
          },
          mouseout: function(e) {
            bataskecamatan.resetStyle(e.target);
          },
        });
      },
    });
    $.getJSON("{{ route('api.batas.kecamatan') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
      bataskecamatan.addData(data); // Menambahkan data ke dalam bataskecamatan variable
      map.addLayer(bataskecamatan); // Menambahkan GeoJSON bataskecamatan ke dalam peta
    });

    var bataskabupaten = L.geoJSON(null, {
      // Style
      style: function(feature) {
        return {
          color: "yellow",
          weight: 4,
          opacity: 1,
          fillColor: "white",
          fillOpacity: 0,
        };
      },
      // onEachFeature
      onEachFeature: function(feature, layer) {
        // variable popup content
        var popup_content = "Kabupaten: " + feature.properties.wadmkk + "<br>" +
          "Provinsi: " + feature.properties.wadmpr + "<br>" +
          "Area: " + (feature.properties.area / 10000).toFixed(2) + " Ha";

        layer.on({
          click: function(e) {
            bataskabupaten.bindPopup(popup_content);
          },
          mouseover: function(e) {
            bataskabupaten.bindTooltip(feature.properties.wadmkk);

            // highlight
            layer.setStyle({
              weight: 4,
              color: 'black',
              opacity: 1,
              fillColor: "cyan",
              fillOpacity: 0.3,
            });
          },
          mouseout: function(e) {
            bataskabupaten.resetStyle(e.target);
          },
        });
      },
    });
    $.getJSON("{{ route('api.batas.kabupaten') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
      bataskabupaten.addData(data); // Menambahkan data ke dalam bataskabupaten variable
      // map.addLayer(bataskabupaten); // Menambahkan GeoJSON bataskabupaten ke dalam peta
    });

    var symbolPeribadatan = {
      "Gereja": gerejaMarker,
      "Masjid": masjidMarker,
      "Pura": puraMarker,
      "Vihara": viharaMarker,
      "Peribadatan/Sosial Lainnya": lainnyaMarker,
    };
    var bangunanperibadatan = L.geoJSON(null, {
      // Style
      pointToLayer: function(feature, latlng) {
        return L.marker(latlng, {
          icon: symbolPeribadatan[feature.properties.remark],
        });
      },
      // onEachFeature
      onEachFeature: function(feature, layer) {
        // variable popup content
        var popup_content = feature.properties.remark;

        layer.on({
          click: function(e) {
            bangunanperibadatan.bindPopup(popup_content);
          },
          mouseover: function(e) {
            bangunanperibadatan.bindTooltip(feature.properties.remark);
          },
          mouseout: function(e) {
            bangunanperibadatan.resetStyle(e.target);
          },
        });
      },
    });
    $.getJSON("{{ route('api.bangunan.peribadatan') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
      bangunanperibadatan.addData(data); // Menambahkan data ke dalam bangunanperibadatan variable
      map.addLayer(bangunanperibadatan); // Menambahkan GeoJSON bangunanperibadatan ke dalam peta
    });

    // Control Layer
    var baseMaps = {
      "OpenStreetMap": osm,
      "Esri World Imagery": Esri_WorldImagery,
      "Rupa Bumi Indonesia": rupabumiindonesia,
      "Google Roadmap": Google_Roadmap,
      "Google Satellite": Google_Satellite,
    };

    var overlayMaps = {
      "Bangunan Peribadatan<br><i class='fas fa-cross ms-3' style='color: red;'></i> Gereja<br><i class='fas fa-star-and-crescent ms-3' style='color: green;'></i> Masjid<br><i class='fas fa-torii-gate ms-3' style='color: cadetblue;'></i> Pura<br><i class='fas fa-vihara ms-3' style='color: purple;'></i> Vihara<br><i class='fas fa-hands-praying ms-3' style='color: orange;'></i> Lainnya": bangunanperibadatan,
      "Ruas Jalan": jalan,
      "Batas Desa": batasdesa,
      "Batas Kecamatan": bataskecamatan,
      "Batas Kabupaten": bataskabupaten,
    };

    var controllayer = L.control.layers(baseMaps, overlayMaps, {
      collapsed: false
    });
    controllayer.addTo(map);

    // update layer jalan
    function updateLayer() {
			$('.progress').show();
      var bounds = map.getBounds();
      var minll = bounds.getSouthWest();
      var maxll = bounds.getNorthEast();
      var bbox = minll.lng + ',' + minll.lat + ',' + maxll.lng + ',' + maxll.lat;
      console.log(bbox);

      var zoom = map.getZoom();
      console.log(zoom);

      $.getJSON("{{ route('api.jalans') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
        jalan.clearLayers();
        jalan.addData(data);
      });

      $.getJSON("{{ route('api.batas.desa') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
        batasdesa.clearLayers();
        batasdesa.addData(data);
      });

      $.getJSON("{{ route('api.batas.kecamatan') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
        bataskecamatan.clearLayers();
        bataskecamatan.addData(data);
      });

      $.getJSON("{{ route('api.batas.kabupaten') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
        bataskabupaten.clearLayers();
        bataskabupaten.addData(data);
      });

      $.getJSON("{{ route('api.bangunan.peribadatan') }}?bbox=" + bbox + "&zoom=" + zoom, function(data) {
        bangunanperibadatan.clearLayers();
        bangunanperibadatan.addData(data);
      });

      map.on('overlayadd', function() {
				$('.progress').hide();
			});
    }

    // event map moveend
    map.on('moveend', function() {
      updateLayer();
    });

    // event map zoomend
    map.on('zoomend', function() {
      updateLayer();
    });

    // body load end
    // $(document).ready(function() {
    // 	$('.progress').hide();
    // });

    // layer load end
    map.on('layeradd', function() {
      $('.progress').hide();
    });
  </script>
</body>

</html>
