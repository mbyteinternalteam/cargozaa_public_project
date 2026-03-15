<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-background">
    <div class="w-full max-w-3xl">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 bg-secondary">
                <x-heroicon-s-building-office-2 class="w-8 h-8 text-primary" />
            </div>
            <h1 class="text-3xl font-bold mb-2 text-primary">Become a Container Owner</h1>
            <p class="text-muted-foreground">Start earning revenue by listing your containers on Cargozaa</p>
        </div>

        <div class="bg-white dark:bg-card rounded-2xl shadow-xl p-8">
            <form wire:submit="submit" class="space-y-6" enctype="multipart/form-data">
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-primary">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                            <input wire:model.defer="fullName" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="John Doe">
                            @error('fullName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                            <input wire:model.defer="email" type="email"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="john@company.com">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input wire:model.live="phone" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="601161234567"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   maxlength="12">
                            @error('phone')
                                <p class="mt-1 text-red-600 text-sm">
                                    <span wire:loading wire:target="phone" class="loading loading-xs loading-dots"></span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-primary">Business Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Name</label>
                            <input wire:model.defer="businessName" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="Your Business Sdn Bhd">
                            @error('businessName')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Type</label>
                            <select
                                wire:model.defer="businessType"
                                class="select select-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                            >
                                <option value="">Select business type</option>
                                @foreach($this->businessTypeOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('businessType')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Owner IC Number</label>
                            <input wire:model.live="ownerIcNumber" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="870101141234"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   maxlength="12">
                            @error('ownerIcNumber')
                                <p class="mt-1 text-red-600 text-sm">
                                    <span wire:loading wire:target="ownerIcNumber" class="loading loading-xs loading-dots"></span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IC Type</label>
                            <select wire:model.defer="ownerIcType"
                                    class="select select-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800">
                                <option value="">Select type</option>
                                <option value="nric">NRIC</option>
                                <option value="passport">Passport</option>
                            </select>
                            @error('ownerIcType')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 ">Registered Address</label>
                            <input wire:model.defer="registeredAddress" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="123 Business St, Kuala Lumpur, Malaysia">
                            @error('registeredAddress')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 ">Registered City</label>
                            <input wire:model.defer="registeredCity" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="Klang Lama">
                            @error('registeredCity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registered Postcode</label>
                            <input wire:model.defer="registeredPostcode" type="number" 
                                   class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="50000">
                            @error('registeredPostcode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registered State</label>
                            <livewire:shared.state-select wire:model.defer="registeredStateId" />
                            @error('registeredStateId')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SSM Registration Number</label>
                            <input wire:model.defer="taxId" type="text"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="202301234567">
                            @error('taxId')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Company Registration Certificate (SSM Certificate) *
                            </label>
                            <div class="space-y-3">
                                <input type="file" class="hidden" wire:model="ssmCertificate" id="ssm-upload-livewire">

                                @if ($ssmCertificate)
                                    @php
                                        $mime = $ssmCertificate->getMimeType();
                                        $isImage = str_starts_with($mime, 'image/');
                                    @endphp

                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-secondary/20">
                                                @if ($isImage)
                                                    <img
                                                        src="{{ $ssmCertificate->temporaryUrl() }}"
                                                        alt="SSM Preview"
                                                        class="w-12 h-12 object-cover rounded-lg"
                                                    >
                                                @else
                                                    <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="none">
                                                        <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="1.5" />
                                                        <path d="M9 13h6M9 17h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="text-left">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $ssmCertificate->getClientOriginalName() }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format($ssmCertificate->getSize() / 1024, 1) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="clearSsmCertificate"
                                            class="btn btn-ghost btn-xs text-red-600 hover:text-red-700"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center w-full h-32 px-4 py-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all"
                                         onclick="document.getElementById('ssm-upload-livewire').click()">
                                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                        <span class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                            <span class="font-semibold text-primary">Click to upload</span> or drag and drop
                                        </span>
                                        <span class="text-xs text-gray-500 mt-1">
                                            PDF, JPG, or PNG (Max. 10MB)
                                        </span>
                                    </div>
                                @endif

                                @error('ssmCertificate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <div wire:loading wire:target="ssmCertificate" class="text-xs text-gray-500">
                                    Uploading file...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-primary">Account Security</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                            <input wire:model.live="password" type="password"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="Min. 8 characters">
                            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                            <input wire:model.live="passwordConfirmation" type="password"
                                   class="input input-bordered w-full py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-800"
                                   placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 dark:border-gray-700 space-y-4">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="businessVerified"
                               class="mt-1 rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            I confirm that all business information provided is accurate and I have the authority to list containers on behalf of my company.
                        </span>
                    </label>
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" wire:model.live="acceptTerms"
                               class="mt-1 rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            I agree to the
                            <a href="{{ url('/owner-terms') }}" class="font-medium hover:underline text-primary">Owner Terms &amp; Conditions</a>,
                            <a href="{{ url('/privacy') }}" class="font-medium hover:underline text-primary">Privacy Policy</a>,
                            and
                            <a href="{{ url('/commission') }}" class="font-medium hover:underline text-primary">Commission Structure</a>.
                        </span>
                    </label>
                    @error('businessVerified')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('acceptTerms')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <button
                    type="submit"
                    class="btn w-full py-3 px-4 rounded-lg font-semibold shadow-lg hover:shadow-xl border-0 text-white transition-all bg-gradient-to-r from-secondary to-amber-400 disabled:opacity-50 disabled:cursor-not-allowed"
                    @disabled(! $businessVerified || ! $acceptTerms)
                    wire:loading.attr="disabled"
                    wire:target="submit,ssmCertificate"
                >
                    <span wire:loading wire:target="submit,ssmCertificate" class="loading loading-bars loading-sm mr-2"></span>
                    <span>Create Owner Account</span>
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <p class="text-muted-foreground">
                Already have an owner account?
                <a href="{{ route('owner.login') }}" class="font-semibold hover:underline text-primary">Sign in</a>
            </p>
            <p class="mt-2 text-sm text-gray-500">
                Looking to rent containers?
                <a href="{{ url('/customer/signup') }}" class="font-medium hover:underline text-primary">Create customer account</a>
            </p>
        </div>
    </div>

    @if ($showSuccessModal)
        <div class="modal modal-open">  
            <div class="modal-box">
                <h3 class="font-bold text-lg text-primary">Account created successfully</h3>
                <p class="py-4 text-sm text-gray-700">
                    Your owner account has been created and is now under KYC review.
                    It will take approximately 24 to 48 hours to approve your account before you can start listing containers for lease.
                </p>
                <div class="modal-action">
                    <button type="button" class="btn" wire:click="closeSuccessModal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

