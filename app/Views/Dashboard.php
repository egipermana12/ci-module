<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>

<!-- map -->
<div class="card">
    <div id="map"></div>
</div>
<script type="text/javascript">
    
    var customIcon = L.icon({
        iconUrl: '<?= base_url('images/marker-icon.png'); ?>',
        iconSize:     [42, 42], // size of the icon
        shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    var map = L.map("map").setView([-6.282493940225169,107.15327486637672], 16);
    const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 20,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(map);
    // koordinat.forEach(item => marker = L.marker(item, {icon: customIcon}).bindPopup('Kantor Utama').addTo(map));
    var marker = L.marker([-6.282493940225169,107.15327486637672], {icon: customIcon}).bindPopup('Kantor Utama').addTo(map)
</script>
    
<?=$this->endSection()?>
