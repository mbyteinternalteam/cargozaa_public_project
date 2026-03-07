            <div class="rounded-2xl border border-gray-100 p-6">
                <h3 class="text-[#1a1a2e] text-[18px] mb-4 flex items-center gap-2 font-bold">
                    <x-heroicon-s-archive-box class="w-5 h-5 text-[#000080]" />
                    Basic Information
                </h3>

                <div>
                    <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="title" placeholder="e.g., 40ft Dry Container - Port Klang"
                           class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Container Type <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="container_type"
                                class="select select-bordered w-full py-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                            <option value="">Select container type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('container_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Container Size <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="container_size"
                                class="select select-bordered w-full py-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                            <option value="">Select size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                        @error('container_size')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                        Container Condition <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="container_condition"
                            class="select select-bordered w-full py-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                        <option value="">Select condition</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                    </select>
                    @error('container_condition')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Year Built <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="year_built"
                                class="select select-bordered w-full py-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                            <option value="">Select year</option>
                            @for ($y = (int) date('Y'); $y >= 1990; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        @error('year_built')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                            Last Inspection Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model="last_inspection_date"
                               class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                        @error('last_inspection_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-[13px] text-gray-600 mb-2 block font-semibold">
                        Container ID/Serial Number
                    </label>
                    <input type="text" wire:model="serial_number" placeholder="e.g., CSQU3054383"
                           class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none w-full px-4 py-3 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] transition-colors">
                    @error('serial_number')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @include('livewire.owner.containers.partials._location-pricing')
            @include('livewire.owner.containers.partials._specs-features-images')

