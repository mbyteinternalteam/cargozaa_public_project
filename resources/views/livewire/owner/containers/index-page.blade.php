<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-[#1a1a2e] text-[28px] font-bold">
                    My Container Listings
                </h1>
                <p class="text-gray-500 text-[15px]">Manage and monitor all your container listings</p>
            </div>
            <a href="{{ route('owner.containers.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#FFD700] text-[#000080] text-[14px] hover:bg-[#FFD700]/90 transition-colors font-semibold">
                <x-heroicon-s-plus class="w-4 h-4" /> Add Container
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="p-5 rounded-xl border border-gray-100">
                <p class="text-gray-400 text-[13px] mb-1">Total Containers</p>
                <p class="text-[#000080] text-[24px] font-bold">{{ $containers->total() }}</p>
            </div>
            <div class="p-5 rounded-xl border border-gray-100">
                <p class="text-gray-400 text-[13px] mb-1">Active Listings</p>
                <p class="text-green-600 text-[24px] font-bold">{{ $totalActive }}</p>
            </div>
            <div class="p-5 rounded-xl border border-gray-100">
                <p class="text-gray-400 text-[13px] mb-1">Pending Approval</p>
                <p class="text-amber-500 text-[24px] font-bold">{{ $totalPending }}</p>
            </div>
        </div>

        @if($containers->isEmpty())
            <div class="border border-dashed border-gray-200 rounded-2xl p-10 text-center text-gray-500">
                <img src="{{ asset('asset/img/empty-box.png') }}" alt="Empty State" class="h-[200px] w-[200px] mx-auto mb-4">
                <p class="text-[15px] mb-5"><i>You have no containers listed yet.</i></p>
                <a href="{{ route('owner.containers.create') }}" class="text-[#000080] font-semibold hover:underline">
                    Add your first container
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($containers as $container)
                    <div class="rounded-2xl border border-gray-100 overflow-hidden hover:shadow-md transition-all bg-white">
                        <div class="relative h-44 bg-gray-100 flex items-center justify-center">
                            @if($container->images && count($container->images) > 0)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($container->images[0]) }}" alt="{{ $container->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <x-heroicon-s-cube class="w-12 h-12 text-[#000080]" />
                            @endif
                            <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-[12px] font-medium text-white shadow-sm
                                @if($container->status === \App\Enums\ContainerStatus::Active) bg-green-500
                                @elseif($container->status === \App\Enums\ContainerStatus::Pending) bg-amber-500
                                @elseif($container->status === \App\Enums\ContainerStatus::UnderReview) bg-blue-500
                                @elseif($container->status === \App\Enums\ContainerStatus::Rejected) bg-red-500
                                @else bg-gray-500
                                @endif">
                                {{ $container->status->label() }}
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-[#1a1a2e] text-[16px] mb-1 font-semibold truncate" title="{{ $container->title }}">{{ $container->title }}</h3>
                            <div class="flex items-center gap-1 text-gray-400 text-[13px] mb-3 min-w-0">
                                <x-heroicon-s-map-pin class="w-3 h-3 flex-shrink-0" />
                                <span class="truncate" title="{{ $container->full_address }}">{{ $container->full_address }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[#000080] font-bold">RM {{ number_format($container->daily_rate, 2) }}/day</span>
                                <span class="text-gray-400 text-[13px]">0 bookings</span>
                            </div>
                                
                            <a href="{{ route('owner.containers.show', $container) }}"
                                class="flex-1 py-2 rounded-lg border border-gray-200 text-[13px] text-gray-600 hover:bg-gray-50 transition-colors flex items-center justify-center gap-1.5 font-medium">
                                <x-heroicon-s-eye class="w-4 h-4" /> View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $containers->links() }}
            </div>
        @endif
    </div>

    @if($deleteContainerId)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg text-[#1a1a2e]">Delete Container</h3>
                <p class="py-4 text-gray-600">Are you sure you want to delete this container? This action cannot be undone.</p>
                <div class="modal-action">
                    <button type="button" wire:click="cancelDelete" class="btn">Cancel</button>
                    <button type="button" wire:click="deleteContainer" class="btn btn-error text-white">Delete</button>
                </div>
            </div>
            <div class="modal-backdrop bg-black/50" wire:click="cancelDelete"></div>
        </div>
    @endif
</div>
