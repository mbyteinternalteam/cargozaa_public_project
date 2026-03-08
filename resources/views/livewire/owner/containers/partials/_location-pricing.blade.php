            <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-heroicon-s-map-pin class="w-5 h-5 text-[#000080]" />
                    Location & Pricing
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Pin Location <span class="text-red-500">*</span>
                        </label>
                        <div class="rounded-xl border border-gray-200 overflow-hidden bg-gray-50">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 bg-white">
                                <p class="text-[12px] text-gray-500">
                                    Click the map to drop a pin. We’ll auto-fill the address.
                                </p>
                                <button type="button" id="container-create-use-my-location"
                                        class="btn btn-sm btn-outline">
                                    Use my location
                                </button>
                            </div>

                            <div wire:ignore
                                 id="container-create-map"
                                 data-lat="{{ $latitude ?? '' }}"
                                 data-lng="{{ $longitude ?? '' }}"
                                 class="h-64 w-full"></div>
                        </div>

                        @error('latitude')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @error('longitude')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Full Address
                        </label>
                        <textarea wire:model="full_address" rows="3" placeholder="Complete address (optional)"
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors resize-none"></textarea>
                        @error('full_address')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                                Daily Rate (RM) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model="daily_rate" min="0" step="0.01" placeholder="55.00"
                                   class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                            @error('daily_rate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                                Weekly Rate (RM)
                            </label>
                            <input type="number" wire:model="weekly_rate" min="0" step="0.01" placeholder="350.00"
                                   class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                            @error('weekly_rate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                                Monthly Rate (RM)
                            </label>
                            <input type="number" wire:model="monthly_rate" min="0" step="0.01" placeholder="1200.00"
                                   class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                            @error('monthly_rate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

