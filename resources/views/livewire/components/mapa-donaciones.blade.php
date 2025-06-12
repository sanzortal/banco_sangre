<div>
    <div class="w-full h-80 rounded shadow border" wire:ignore id="mapa-donaciones"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        document.addEventListener("livewire:load", () => {
            const map = L.map('mapa-donaciones').setView([40.4, -3.7], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const markers = [];

            @foreach ($puntos as $punto)
                const marker = L.marker([{{ $punto['latitud'] }}, {{ $punto['longitud'] }}])
                    .addTo(map)
                    .bindPopup("<strong>{{ $punto['nombre'] }}</strong><br>{{ $punto['direccion'] }}");

                markers.push(marker);
            @endforeach

        if (markers.length > 1) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.2));
            } else if (markers.length === 1) {
                map.setView(markers[0].getLatLng(), 14);
            }
        });
    </script>
</div>