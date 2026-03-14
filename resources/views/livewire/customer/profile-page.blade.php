<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your account information and preferences</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Left Sidebar --}}
            <div class="w-full lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    {{-- Blue Cover Banner --}}
                    <div class="h-28 bg-gradient-to-br from-[#000080] to-[#1a1aff] relative"></div>

                    {{-- Avatar + Info --}}
                    <div class="px-6 pb-6 -mt-12 text-center">
                        <div class="relative inline-block">
                            <label class="cursor-pointer block">
                                @if($this->profilePictureUrl)
                                    <img src="{{ $this->profilePictureUrl }}" alt="Profile"
                                        class="w-24 h-24 rounded-full object-cover ring-4 ring-white shadow-md mx-auto">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center ring-4 ring-white shadow-md mx-auto">
                                        <x-heroicon-o-user class="w-10 h-10 text-gray-400" />
                                    </div>
                                @endif
                                <div class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-[#FFD700] flex items-center justify-center shadow-lg">
                                    <x-heroicon-s-camera class="w-3.5 h-3.5 text-[#000080]" />
                                </div>
                                <input type="file" wire:model="profilePicture" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                            </label>
                            <div wire:loading wire:target="profilePicture" class="absolute inset-0 flex items-center justify-center rounded-full bg-black/30 text-white text-xs">Uploading...</div>
                        </div>
                        @error('profilePicture')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                        <h3 class="text-lg font-bold text-gray-900 mt-3">{{ $fullName ?: 'Customer' }}</h3>
                        @if($companyName)
                            <p class="text-sm text-gray-500">{{ $companyName }}</p>
                        @endif

                        @if($this->isVerified)
                            <span class="inline-flex items-center gap-1 mt-2 px-3 py-1 rounded-full bg-green-50 border border-green-100">
                                <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" />
                                <span class="text-green-700 text-xs font-semibold">Verified Account</span>
                            </span>
                        @endif
                    </div>

                    {{-- Navigation Tabs --}}
                    <div class="px-4 pb-2">
                        <button wire:click="setTab('personal')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ $activeTab === 'personal' ? 'bg-blue-50 text-[#000080]' : 'text-gray-600 hover:bg-gray-50' }}">
                            <x-heroicon-o-user class="w-5 h-5" />
                            Personal Information
                        </button>
                        <button wire:click="setTab('settings')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ $activeTab === 'settings' ? 'bg-blue-50 text-[#000080]' : 'text-gray-600 hover:bg-gray-50' }}">
                            <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                            Account Settings
                        </button>
                        <button wire:click="setTab('activity')"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ $activeTab === 'activity' ? 'bg-blue-50 text-[#000080]' : 'text-gray-600 hover:bg-gray-50' }}">
                            <x-heroicon-o-arrow-trending-up class="w-5 h-5" />
                            Activity & Orders
                        </button>
                    </div>

                    {{-- Sign Out --}}
                    <div class="px-4 pb-4 pt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-red-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Content --}}
            <div class="flex-1 space-y-6">
                {{-- Stats Cards --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl border border-gray-100 p-4">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center mb-3">
                            <x-heroicon-s-cube class="w-5 h-5 text-[#000080]" />
                        </div>
                        <p class="text-xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-gray-500 mt-0.5">Active Leases</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 p-4">
                        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center mb-3">
                            <x-heroicon-s-arrow-trending-up class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xl font-bold text-gray-900">RM 0</p>
                        <p class="text-xs text-gray-500 mt-0.5">Total Spent</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 p-4">
                        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center mb-3">
                            <x-heroicon-s-heart class="w-5 h-5 text-red-500" />
                        </div>
                        <p class="text-xl font-bold text-gray-900">0</p>
                        <p class="text-xs text-gray-500 mt-0.5">Saved Containers</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 p-4">
                        <div class="w-9 h-9 rounded-lg bg-yellow-50 flex items-center justify-center mb-3">
                            <x-heroicon-s-calendar class="w-5 h-5 text-yellow-600" />
                        </div>
                        <p class="text-xl font-bold text-gray-900">{{ $this->memberSince }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Member Since</p>
                    </div>
                </div>

                {{-- Success Alert --}}
                @if($saved)
                    <div class="flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 shrink-0" />
                        Profile updated successfully.
                    </div>
                @endif

                {{-- Personal Information Tab --}}
                @if($activeTab === 'personal')
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-gray-900">Personal Information</h2>
                            @if($isEditing)
                                <div class="flex gap-2">
                                    <button wire:click="cancelEdit" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                                    <button wire:click="save" class="px-4 py-2 text-sm font-medium text-white bg-[#000080] rounded-lg hover:bg-[#000060] transition-colors">
                                        <span wire:loading.remove wire:target="save">Save Changes</span>
                                        <span wire:loading wire:target="save">Saving...</span>
                                    </button>
                                </div>
                            @else
                                <button wire:click="edit" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-[#000080] rounded-lg hover:bg-[#000060] transition-colors">
                                    <x-heroicon-s-pencil class="w-4 h-4" />
                                    Edit Profile
                                </button>
                            @endif
                        </div>

                        <div class="space-y-5">
                            {{-- Full Name & Email --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <x-heroicon-o-user class="w-3.5 h-3.5" /> Full Name
                                    </label>
                                    @if($isEditing)
                                        <input wire:model="fullName" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('fullName')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $fullName ?: '—' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <x-heroicon-o-envelope class="w-3.5 h-3.5" /> Email Address
                                    </label>
                                    @if($isEditing)
                                        <input wire:model="email" type="email" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $email ?: '—' }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Phone & Company --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <x-heroicon-o-phone class="w-3.5 h-3.5" /> Phone Number
                                    </label>
                                    @if($isEditing)
                                        <input wire:model="phone" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $phone ?: '—' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                        <x-heroicon-o-building-office class="w-3.5 h-3.5" /> Company Name
                                    </label>
                                    @if($isEditing)
                                        <input wire:model="companyName" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('companyName')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $companyName ?: '—' }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Divider --}}
                            <hr class="border-gray-100">

                            {{-- Street Address --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                    <x-heroicon-o-map-pin class="w-3.5 h-3.5" /> Street Address
                                </label>
                                @if($isEditing)
                                    <input wire:model="billingAddress" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                    @error('billingAddress')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                @else
                                    <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingAddress ?: '—' }}</p>
                                @endif
                            </div>

                            {{-- City & State --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">City</label>
                                    @if($isEditing)
                                        <input wire:model="billingCity" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('billingCity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingCity ?: '—' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">State</label>
                                    @if($isEditing)
                                        <livewire:shared.state-select wire:model="billingStateId" />
                                        @error('billingStateId')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        @php($stateName = $billingStateId ? \App\Models\State::find($billingStateId)?->name : null)
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $stateName ?: '—' }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Postal Code --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">Postal Code</label>
                                    @if($isEditing)
                                        <input wire:model="billingPostcode" type="text" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all">
                                        @error('billingPostcode')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    @else
                                        <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingPostcode ?: '—' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Account Settings Tab --}}
                @if($activeTab === 'settings')
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Account Settings</h2>

                        <div class="space-y-6">
                            {{-- Change Password --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                        <x-heroicon-o-key class="w-5 h-5 text-[#000080]" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Password</p>
                                        <p class="text-xs text-gray-500">Change your account password</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-[#000080] border border-[#000080]/20 rounded-lg hover:bg-blue-50 transition-colors">Change</button>
                            </div>

                            {{-- Notification Preferences --}}
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                                        <x-heroicon-o-bell class="w-5 h-5 text-yellow-600" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Notifications</p>
                                        <p class="text-xs text-gray-500">Manage email & push notifications</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-[#000080] border border-[#000080]/20 rounded-lg hover:bg-blue-50 transition-colors">Manage</button>
                            </div>

                            {{-- Delete Account --}}
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                        <x-heroicon-o-trash class="w-5 h-5 text-red-500" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Delete Account</p>
                                        <p class="text-xs text-gray-500">Permanently delete your account and data</p>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-sm font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Activity & Orders Tab --}}
                @if($activeTab === 'activity')
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Activity & Orders</h2>
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-sm text-gray-500">No activity yet.</p>
                            <p class="text-xs text-gray-400 mt-1">Your lease history and orders will appear here.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
