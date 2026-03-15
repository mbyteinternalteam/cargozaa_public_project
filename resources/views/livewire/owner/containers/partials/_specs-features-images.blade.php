            <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-phosphor-ruler-fill class="w-5 h-5 text-[#000080]" />
                    Specifications
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">Length (ft)</label>
                        <input type="number" wire:model="length" step="0.01"
                               class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                        @error('length')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">Width (ft)</label>
                        <input type="number" wire:model="width" step="0.01"
                               class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                        @error('width')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">Height (ft)</label>
                        <input type="number" wire:model="height" step="0.01"
                               class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                        @error('height')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">Max Weight (kg)</label>
                        <input type="number" wire:model="max_weight" step="0.01"
                               class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                        @error('max_weight')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">Tare Weight (kg)</label>
                        <input type="number" wire:model="tare_weight" step="0.01"
                               class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                        @error('tare_weight')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                        Capacity (cubic meters)
                    </label>
                    <input type="number" wire:model="cargo_capacity" step="0.01"
                           class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                    @error('cargo_capacity')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-heroicon-s-check-circle class="w-5 h-5 text-[#000080]" />
                    Features & Amenities
                </h3>

                @error('features')
                    <p class="text-xs text-red-600 mb-3">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 ">
                    @foreach ($featureOptions as $feature)
                        @php
                            $name = (string) $feature->name;
                        @endphp

                        

                        <label wire:target="{{ $name }}" wire:key="{{ $name }}"
                            class="flex items-center gap-3 p-4 rounded-xl border-2 transition-colors cursor-pointer
                                   @if(in_array($name, old(request('features', [])))
                                       'border-blue-500'
                                   @else
                                       'border-gray-200 hover:bg-gray-50'
                                   @endif">
                            <input type="checkbox" wire:model="features" value="{{ $name }}"
                                   class="checkbox checkbox-sm
                                   @if(in_array($name, old(request('features', [])))
                                       'border-indigo-600 bg-indigo-100 checked:border-orange-500 checked:bg-orange-400'
                                   @else
                                       'bg-gray-100'
                                   @endif" />
                            <span class="text-[14px] font-medium
                                   @if(in_array($name, old(request('features', [])))
                                       'text-white'
                                   @else
                                       'text-gray-700'
                                   @endif">{{ $name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-heroicon-s-photo class="w-5 h-5 text-[#000080]" />
                    Container Images <span class="text-red-500">*</span>
                </h3>

                @if (! empty($existingImages))
                    <div class="mb-4">
                        <p class="text-[12px] text-gray-500 mb-2">Current images</p>
                        <div class="flex gap-3 overflow-x-auto pb-1">
                            @foreach($existingImages as $img)
                                <div class="w-24 h-16 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($img) }}"
                                         alt="Existing image"
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4 mb-3">
                    <p class="text-gray-400 text-[11px]">
                        Uploading new images will replace existing images (max 5, 10MB each).
                    </p>
                    <p class="text-[11px] text-gray-500 whitespace-nowrap">
                        Selected: <span class="font-semibold">{{ count($images) }}</span>/5
                    </p>
                </div>

                <input type="file" wire:model="images" wire:key="images-{{ $imagesInputKey }}" multiple accept="image/*"
                       class="file-input file-input-bordered w-full bg-white">
                <p class="text-gray-400 text-[11px] mt-1">
                    Tip: you can click again to add more images (up to 5).
                </p>
                @error('images')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror

                @if ($images)
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach ($images as $index => $image)
                            <div class="relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img src="{{ $image->temporaryUrl() }}" alt="Selected image {{ $index + 1 }}"
                                     class="h-24 w-full object-cover">
                                <div class="absolute top-1 left-1 flex gap-1">
                                    <button type="button" wire:click="moveImage({{ $index }}, {{ $index - 1 }})"
                                            @disabled($index === 0)
                                            class="btn btn-xs btn-circle bg-white/80 hover:bg-white border-0 disabled:opacity-40">
                                        ‹
                                    </button>
                                    <button type="button" wire:click="moveImage({{ $index }}, {{ $index + 1 }})"
                                            @disabled($index === count($images) - 1)
                                            class="btn btn-xs btn-circle bg-white/80 hover:bg-white border-0 disabled:opacity-40">
                                        ›
                                    </button>
                                </div>
                                <button type="button" wire:click="removeImage({{ $index }})"
                                        class="btn btn-xs btn-circle btn-ghost absolute top-1 right-1 bg-white/80 hover:bg-white">
                                    ✕
                                </button>
                                @if ($index === 0)
                                    <span class="absolute left-1 bottom-1 text-[10px] px-2 py-0.5 rounded-full bg-black/70 text-white">
                                        Main
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

