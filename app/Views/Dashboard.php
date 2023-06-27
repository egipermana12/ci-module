<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>

<!-- map -->
<div class="card">
    <div id="map"></div>
</div>
<script type="text/javascript">
    var data = <?= json_encode($geoLokasi) ?>;
    var markers = <?= json_encode($markers) ?>;

    var customIcon = L.icon({
        iconUrl: '<?= base_url('images/marker-icon.png'); ?>',
        iconSize: [40, 42],
        iconAnchor: [24, 41],
        popupAnchor: [-2, -45],
        shadowSize: [78, 42],
        shadowAnchor: [24, 41]
    });
    function style(feature){
        return{
            weight : 2,
            opacity : 0.5,
            color : 'orange',
            dashArray : '3',
            fillOpacity : 0.1,
            // fillColor : getColor(parseInt(feature.properties.nilai))
        };
    }

    function onEachFeature(feature, layer)
    {
        layer.bindPopup("<h4>Provinsi</h4><br>"+feature.properties.Propinsi);
    }

    var map = L.map("map").setView([-6.248606, 107.117242], 8);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //coba gejson
    var geojson = L.geoJson(data, {
        style: style,
        onEachFeature : onEachFeature
    }).addTo(map);

    var base_url = '<?= base_url('images/unitkerja/') ?>';
    markers.forEach(function(coordinate) {
        var latLng = coordinate.koordinat_lokasi.split(',').map(function(coord) {
            return parseFloat(coord.trim());
        });

        var imageUrl = base_url + coordinate.gambar;
        var popupContent = '<h4>' + coordinate.nm_unit_kerja + '</h4>' +
        '<p>' + coordinate.alamat + '</p>' +
        '<img src="' + imageUrl + '" alt="Gambar" width="300" height="200" />';
        L.marker(latLng, {icon: customIcon}).bindPopup(popupContent).addTo(map);
    });

</script>
    
<?=$this->endSection()?>
