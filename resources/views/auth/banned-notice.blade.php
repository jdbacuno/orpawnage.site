<x-layout>
  <div class="min-h-screen flex flex-col items-center justify-center text-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
      <div class="text-red-500 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>

      @if(Auth::user()->is_temporarily_banned)
        <h2 class="text-2xl font-bold mb-4">Account Temporarily Suspended</h2>
        <p class="mb-6 text-gray-700">
          Your account has been temporarily suspended. This suspension will automatically lift on {{ \Carbon\Carbon::parse(Auth::user()->temporary_ban_expires_at)->format('M d, Y \a\t g:i A') }}.
        </p>

        @if(Auth::user()->temporary_ban_reason)
        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 text-left">
          <p class="font-medium text-orange-700">Reason:</p>
          <p class="text-orange-600">{{ Auth::user()->temporary_ban_reason }}</p>
          <p class="text-sm text-gray-500 mt-1">Suspended on: {{ \Carbon\Carbon::parse(Auth::user()->temporarily_banned_at)->format('M d, Y') }}</p>
        </div>
        @endif
      @else
        <h2 class="text-2xl font-bold mb-4">Account Suspended</h2>
        <p class="mb-6 text-gray-700">
          Your account has been permanently banned. Please contact support if you believe this is an error.
        </p>

        @if(Auth::user()->ban_reason)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 text-left">
          <p class="font-medium text-red-700">Reason:</p>
          <p class="text-red-600">{{ Auth::user()->ban_reason }}</p>
          <p class="text-sm text-gray-500 mt-1">Banned on: {{ \Carbon\Carbon::parse(Auth::user()->banned_at)->format('M d, Y') }}</p>
        </div>
        @endif
      @endif

      <div class="flex flex-col sm:flex-row gap-3 mt-6">
        <a href="mailto:orpawnagedevelopers@gmail.com"
          class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition text-center">
          Contact Support
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit" 
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition w-full sm:w-auto">
            Sign Out
          </button>
        </form>
      </div>
      
      <p class="text-sm text-gray-500 mt-4 text-center">
        You can sign out at any time using the button above.
      </p>
    </div>
  </div>
</x-layout>