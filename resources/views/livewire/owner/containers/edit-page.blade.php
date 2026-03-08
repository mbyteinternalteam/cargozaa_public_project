<div class="bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 py-8">
        <div class="breadcrumbs text-sm mb-6">
            <ul class="text-gray-500">
                <li><a class="hover:text-primary" href="{{ route('owner.containers.index') }}">My Containers</a></li>
                <li class="hover:text-primary"><a class="hover:text-primary" href="{{ route('owner.containers.show', $container) }}">{{ $container->title }}</a></li>
                <li class="text-gray-700 font-medium">Edit</li>
            </ul>
        </div>

        <h1 class="text-[#1a1a2e] text-[28px] font-bold mb-1">
            Edit Container
        </h1>
        <p class="text-gray-500 text-[15px] mb-6">
            Update your container details and availability.
        </p>

        <form wire:submit.prevent="save" class="space-y-6">
            @include('livewire.owner.containers.partials._form-fields')
            <div class="flex gap-4">
                <a href="{{ route('owner.containers.show', $container) }}"
                   class="flex-1 py-3.5 rounded-xl border border-gray-200 text-gray-600 text-[14px] hover:bg-gray-50 transition-colors font-semibold text-center">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-3.5 rounded-xl bg-[#000080] text-white text-[14px] hover:bg-[#000060] transition-colors font-semibold"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Save Changes</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
        function initContainerCreateMap() {
            const mapEl = document.getElementById('container-create-map');
            if (!mapEl || mapEl.dataset.inited === '1' || !window.L || !window.Livewire) return;
            mapEl.dataset.inited = '1';

            const componentEl = mapEl.closest('[wire\\:id]');
            const component = () => window.Livewire.find(componentEl.getAttribute('wire:id'));

            const map = L.map(mapEl).setView([3.1390, 101.6869], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            let marker = null;

            const buildShortLocation = (addr, displayName) => {
                if (addr) {
                    const city = addr.city || addr.town || addr.village || addr.municipality || addr.county || '';
                    const state = addr.state || '';
                    const parts = [city, state].filter(Boolean);
                    if (parts.length) return parts.join(', ').slice(0, 255);
                }

                if (!displayName) return '';
                return displayName.split(',').slice(0, 2).join(',').trim().slice(0, 255);
            };

            const reverseGeocode = async (lat, lng) => {
                const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}`;
                const res = await fetch(url, {headers: {'Accept': 'application/json'}});
                if (!res.ok) return null;
                return await res.json();
            };

            const setPin = async (lat, lng) => {
                if (!marker) {
                    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                    marker.on('dragend', async (e) => {
                        const pos = e.target.getLatLng();
                        await setPin(pos.lat, pos.lng);
                    });
                } else {
                    marker.setLatLng([lat, lng]);
                }

                map.panTo([lat, lng]);

                const lw = component();
                lw.set('latitude', +lat);
                lw.set('longitude', +lng);

                const data = await reverseGeocode(lat, lng);
                if (!data) return;

                const displayName = data.display_name || '';
                lw.set('full_address', displayName);
                lw.set('location', buildShortLocation(data.address, displayName));
            };

            const initialLat = parseFloat(mapEl.dataset.lat);
            const initialLng = parseFloat(mapEl.dataset.lng);
            if (!Number.isNaN(initialLat) && !Number.isNaN(initialLng)) {
                setPin(initialLat, initialLng);
                map.setZoom(14);
            }

            map.on('click', async (e) => {
                await setPin(e.latlng.lat, e.latlng.lng);
            });

            const myLocBtn = document.getElementById('container-create-use-my-location');
            if (myLocBtn && navigator.geolocation) {
                myLocBtn.addEventListener('click', () => {
                    navigator.geolocation.getCurrentPosition(
                        async (pos) => {
                            await setPin(pos.coords.latitude, pos.coords.longitude);
                            map.setZoom(16);
                        },
                        () => {
                            alert('Unable to access your current location. Please pin it manually on the map.');
                        },
                        {enableHighAccuracy: true, timeout: 8000}
                    );
                });
            }
        }

        document.addEventListener('livewire:init', initContainerCreateMap);
        document.addEventListener('livewire:navigated', initContainerCreateMap);
        </script>
    @endpush
@endonce

