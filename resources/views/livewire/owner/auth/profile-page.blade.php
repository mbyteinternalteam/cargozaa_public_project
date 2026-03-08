<div class="bg-white dark:bg-background min-h-screen">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 space-y-6">
        {{-- Business profile header --}}
        <div class="mb-2">
            <h1 class="text-foreground text-[28px] font-bold">Business Profile</h1>
            <p class="text-gray-500 text-[15px]">Manage your business information and verification details</p>
        </div>

        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-4">
                <div class="flex items-center gap-6">
                    @php($owner = auth()->user()?->owner)
                    <div class="relative">
                        <label class="cursor-pointer block">
                            @if($owner?->profile_picture)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($owner->profile_picture) }}" alt="Profile"
                                    class="w-20 h-20 rounded-full object-cover ring-2 ring-gray-100">
                            @else
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ $this->initials }}
                                </div>
                            @endif
                            <div class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-secondary flex items-center justify-center shadow-lg pointer-events-none">
                                <x-heroicon-s-camera class="w-4 h-4 text-primary" />
                            </div>
                            <input type="file" wire:model="profilePicture" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                        </label>
                        <div wire:loading wire:target="profilePicture" class="absolute inset-0 flex items-center justify-center rounded-full bg-black/30 text-white text-xs">Uploading...</div>
                        @error('profilePicture')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <h2 class="text-foreground text-xl font-bold mb-1">{{ $businessName ?: 'Business name' }}</h2>
                        <p class="text-gray-500 text-sm mb-2">SSM: {{ $ssmNumber ?: '—' }}</p>
                        <div class="flex flex-wrap gap-2">
                            @if($this->isVerified)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800">
                                    <x-heroicon-s-check-circle class="w-4 h-4 text-green-600" />
                                    <span class="text-green-700 dark:text-green-400 text-xs font-semibold">Verified Owner</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-start">
                    @if($isEditing)
                        <div class="flex gap-2">
                            <button type="button" wire:click="cancelEdit" class="btn btn-outline border-gray-200 text-gray-600 text-sm">Cancel</button>
                            <button type="button" wire:click="save" class="btn bg-primary text-white hover:bg-primary/90 text-sm">Save Changes</button>
                        </div>
                    @else
                        <button type="button" wire:click="edit" class="btn btn-outline border-gray-200 text-gray-600 text-sm">
                            {{ $this->isFirstTime ? 'Complete Identity & Bank' : 'Edit Profile' }}
                        </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div class="text-center">
                    <x-heroicon-s-cube class="w-5 h-5 text-primary mx-auto mb-1" />
                    <p class="text-primary text-lg font-bold mb-0.5">{{ $totalContainers ?? 0 }}</p>
                    <p class="text-gray-400 text-xs">Total Containers</p>
                </div>
                <div class="text-center">
                    <x-heroicon-s-calendar class="w-5 h-5 text-green-600 mx-auto mb-1" />
                    <p class="text-green-600 text-lg font-bold mb-0.5">{{ $totalBookings ?? 0 }}</p>
                    <p class="text-gray-400 text-xs">Total Bookings</p>
                </div>
                <div class="text-center">
                    <x-heroicon-s-banknotes class="w-5 h-5 text-secondary mx-auto mb-1" />
                    <p class="text-secondary text-lg font-bold mb-0.5">{{ $revenueMtd }}</p>
                    <p class="text-gray-400 text-xs">Revenue (MTD)</p>
                </div>
                <div class="text-center">
                    <x-heroicon-s-arrow-trending-up class="w-5 h-5 text-blue-600 mx-auto mb-1" />
                    <p class="text-blue-600 text-lg font-bold mb-0.5">{{ $successRate }}</p>
                    <p class="text-gray-400 text-xs">Success Rate</p>
                </div>
            </div>
        </div>

        @if($saved)
            <div class="alert alert-success">
                <span>Profile saved successfully.</span>
            </div>
        @endif

        @if($this->isFirstTime)
            <div class="alert alert-info">
                <span>First time login: you can only update Identity and Bank Details.</span>
            </div>
        @endif

        {{-- User information --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">User Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Full Name</label>
                    <input wire:model.defer="fullName" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('fullName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Email</label>
                    <input wire:model.defer="email" type="email" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Business information --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">Business Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Business Name</label>
                    <input wire:model.defer="businessName" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('businessName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Business Type</label>
                    <select wire:model.defer="businessType" @disabled(! $isEditing || $this->isFirstTime)
                        class="select select-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                        <option value="">Select business type</option>
                        @foreach($this->businessTypeOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('businessType')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Phone</label>
                    <input wire:model.defer="phone" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Website (optional)</label>
                    <input wire:model.defer="website" type="url" placeholder="https://" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('website')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- SSM information --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">SSM Information</h3>
            @php($owner = auth()->user()?->owner)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">SSM Number</label>
                    <input wire:model.defer="ssmNumber" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('ssmNumber')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">SSM Certificate</label>
                    <div class="flex items-center gap-3">
                        @if($owner?->ssm_document)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($owner->ssm_document) }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-sm btn-ghost gap-1.5">
                                <x-heroicon-s-eye class="w-4 h-4" /> View
                            </a>
                        @else
                            <span class="text-sm text-gray-500">No file</span>
                        @endif
                        @if($isEditing && ! $this->isFirstTime)
                            <input type="file" wire:model="ssmCertificate" class="file-input file-input-bordered file-input-sm w-full max-w-xs" accept=".pdf,.jpg,.jpeg,.png" />
                        @endif
                    </div>
                    <div wire:loading wire:target="ssmCertificate" class="text-xs text-gray-500 mt-1">Uploading...</div>
                    @error('ssmCertificate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Registered address --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">Registered Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Address</label>
                    <input wire:model.defer="registeredAddress" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('registeredAddress')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">City</label>
                    <input wire:model.defer="registeredCity" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('registeredCity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Zipcode</label>
                    <input wire:model.defer="registeredPostcode" type="text" @disabled(! $isEditing || $this->isFirstTime)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('registeredPostcode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">State</label>
                    <div class="{{ $isEditing && ! $this->isFirstTime ? '' : 'pointer-events-none opacity-80' }}">
                        <livewire:shared.state-select wire:model.defer="registeredStateId" />
                    </div>
                    @error('registeredStateId')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Identity --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">Identity</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">IC Number</label>
                    <input wire:model.defer="ownerIcNumber" type="text" @disabled(! $isEditing)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('ownerIcNumber')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">IC Document Type</label>
                    <select wire:model.defer="ownerIcType" @disabled(! $isEditing)
                        class="select select-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                        <option value="">Select</option>
                        <option value="nric">NRIC</option>
                        <option value="passport">Passport</option>
                    </select>
                    @error('ownerIcType')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">IC Document</label>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 text-sm text-gray-600">
                            {{ $owner?->identity_document ? basename($owner->identity_document) : 'No file' }}
                        </div>
                        @if($isEditing)
                            <input type="file" wire:model="identityDocument" class="file-input file-input-bordered file-input-sm w-full max-w-xs" accept=".pdf,.jpg,.jpeg,.png" />
                        @endif
                    </div>
                    <div wire:loading wire:target="identityDocument" class="text-xs text-gray-500 mt-1">Uploading...</div>
                    @error('identityDocument')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Bank details --}}
        <div class="rounded-2xl border border-gray-100 dark:border-gray-700 p-6 bg-white dark:bg-card">
            <h3 class="text-foreground text-lg font-bold mb-4">Bank Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Bank Name</label>
                    <input wire:model.defer="bankName" type="text" @disabled(! $isEditing)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('bankName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Account Number</label>
                    <input wire:model.defer="bankAccountNumber" type="text" @disabled(! $isEditing)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('bankAccountNumber')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Account Name</label>
                    <input wire:model.defer="bankAccountName" type="text" @disabled(! $isEditing)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('bankAccountName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Branch</label>
                    <input wire:model.defer="bankBranch" type="text" @disabled(! $isEditing)
                        class="input input-bordered w-full {{ $isEditing ? '' : 'bg-gray-50 dark:bg-gray-800' }}">
                    @error('bankBranch')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500 mb-2 block font-semibold">Bank Statement</label>
                    @php($bankPath = is_array($owner?->bank_statement) ? ($owner->bank_statement['path'] ?? null) : null)
                    <div class="flex items-center gap-3">
                        @if($bankPath)
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($bankPath) }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-sm btn-ghost gap-1.5">
                                <x-heroicon-s-eye class="w-4 h-4" /> View
                            </a>
                        @else
                            <span class="text-sm text-gray-500">No file</span>
                        @endif
                        @if($isEditing)
                            <input type="file" wire:model="bankStatement" class="file-input file-input-bordered file-input-sm w-full max-w-xs" accept=".pdf,.jpg,.jpeg,.png" />
                        @endif
                    </div>
                    <div wire:loading wire:target="bankStatement" class="text-xs text-gray-500 mt-1">Uploading...</div>
                    @error('bankStatement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>
</div>
