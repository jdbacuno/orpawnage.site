<x-layout>
  <div class="min-h-screen flex flex-col items-center justify-center text-center">
    <h2 class="text-2xl font-bold mb-4">Verify Your Email Address</h2>

    @if (session('status') === 'verification-link-sent')
    <p class="text-green-600 mb-4">A new verification link has been sent to your email address.</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" id="verificationForm">
      @csrf
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Resend Verification Email</button>
    </form>

    <a href="/settings" class="mt-4 text-blue-600 underline">Go to Settings</a>
  </div>
</x-layout>