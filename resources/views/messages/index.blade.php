<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Private Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="p-6 bg-white shadow sm:rounded-lg border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Send a Secure Message</h3>
                    
                    <form action="{{ route('messages.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="receiver_username" class="block text-sm font-medium text-gray-700">Recipient's Username</label>
                            <input type="text" name="receiver_username" id="receiver_username" value="{{ old('receiver_username') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('receiver_username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message_body" class="block text-sm font-medium text-gray-700">Message Content</label>
                            <textarea name="message_body" id="message_body" rows="4" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('message_body') }}</textarea>
                            @error('message_body')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <div class="p-6 bg-white shadow sm:rounded-lg border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Received Messages</h3>
                    
                    @if($incomingMessages->isEmpty())
                        <div class="text-center py-8 text-gray-500 text-sm">
                            <p>Your inbox is empty. No one has messaged you yet!</p>
                        </div>
                    @else
                        <div class="space-y-4 max-h-[450px] overflow-y-auto pr-2">
                            @foreach($incomingMessages as $msg)
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-indigo-600">From Secure Sender</span>
                                        <span class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $msg->message_body }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>