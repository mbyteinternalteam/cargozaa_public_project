<div class="bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 py-8">
        <div class="breadcrumbs text-sm mb-6">
            <ul class="text-gray-500">
                <li><a class="hover:text-primary" href="{{ route('owner.containers.index') }}">My Containers</a></li>
                <li class="text-gray-700 font-medium">Add New</li>
            </ul>
        </div>

        <h1 class="text-[#1a1a2e] text-[28px] font-bold mb-1">
            Add New Container
        </h1>
        <p class="text-gray-500 text-[15px] mb-6">
            List your container on Cargozaa marketplace for rental
        </p>

        <form wire:submit.prevent="save" class="space-y-6">
            @include('livewire.owner.containers.partials._form-fields')

            {{-- <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-heroicon-s-document-text class="w-5 h-5 text-[#000080]" />
                    Description
                </h3>

                <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                    Additional Details
                </label>
                <textarea wire:model="description" rows="5"
                          placeholder="Describe your container's condition, features, and other important details..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors resize-none"></textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="flex gap-4">
                <a href="{{ route('owner.containers.index') }}"
                   class="flex-1 py-3.5 rounded-xl border border-gray-200 text-gray-600 text-[14px] hover:bg-gray-50 transition-colors font-semibold text-center">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-3.5 rounded-xl bg-[#000080] text-white text-[14px] hover:bg-[#000060] transition-colors font-semibold"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>Submit for Approval</span>
                    <span wire:loading>Submitting...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Custom Alert Modal -->
    <div id="custom-alert-modal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md mx-4 w-full relative z-[10000]">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">Invalid Location</h3>
                    </div>
                </div>
                <div class="mb-6">
                    <p id="custom-alert-message" class="text-sm text-gray-600 leading-relaxed"></p>
                </div>
                <div class="flex justify-end">
                    <button id="custom-alert-close" class="px-4 py-2 bg-[#000080] text-white text-sm font-medium rounded-lg hover:bg-[#000060] transition-colors">
                        OK, I Understand
                    </button>
                </div>
            </div>
        </div>
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

            // Malaysia bounds (approximately)
            const malaysiaBounds = [
                [0.8553, 99.9042], // Southwest corner (near Singapore border)
                [7.3667, 119.2702]  // Northeast corner (near Borneo)
            ];

            const map = L.map(mapEl, {
                maxBounds: malaysiaBounds,
                maxBoundsViscosity: 1.0,
                minZoom: 6,
                maxZoom: 18
            }).setView([4.2105, 101.9758], 8);

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
                const data = await res.json();

                // Debug logging to see what's actually returned
                console.log('Reverse geocoding data:', data);
                console.log('Address:', data?.address);

                // Validate if location is in Malaysia or Singapore
                if (!data || !data.address) return null;

                const addr = data.address;
                const countryCode = addr.country_code || '';
                const countryName = addr.country || '';

                // Check for Malaysia variations
                const isMalaysia = countryCode.toLowerCase() === 'my' ||
                                  countryName.toLowerCase().includes('malaysia') ||
                                  countryCode.toLowerCase() === 'MY';

                // Check for Singapore variations
                const isSingapore = countryCode.toLowerCase() === 'sg' ||
                                   countryName.toLowerCase().includes('singapore') ||
                                   countryCode.toLowerCase() === 'SG';

                // Only allow Malaysia and Singapore
                if (!isMalaysia && !isSingapore) {
                    showCustomAlert(`Location must be in Malaysia or Singapore. The selected location is in ${countryName || 'an unsupported country'}). Please choose a location within Malaysia or Singapore.`);
                    return null;
                }

                return data;
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
                if (!data) {
                    // Reverse geocoding already showed validation alert
                    // Don't populate address fields for invalid locations
                    return;
                }

                // Only populate address fields for valid Malaysia/Singapore locations
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

        // Custom Alert Function
        function showCustomAlert(message) {
            const modal = document.getElementById('custom-alert-modal');
            const messageEl = document.getElementById('custom-alert-message');
            const closeBtn = document.getElementById('custom-alert-close');

            if (!modal || !messageEl || !closeBtn) return;

            messageEl.textContent = message;
            modal.classList.remove('hidden');

            const closeModal = () => {
                modal.classList.add('hidden');
                messageEl.textContent = '';
            };

            closeBtn.onclick = closeModal;

            // Close on background click
            modal.onclick = (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            };

            // Close on Escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                    document.removeEventListener('keydown', handleEscape);
                }
            };
            document.addEventListener('keydown', handleEscape);
        }
        </script>
    @endpush
@endonce

