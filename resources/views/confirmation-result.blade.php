<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Confirmation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full mx-4">
    @if($success)
    <div class="text-center text-green-500 mb-6">
      <i class="fas fa-check-circle text-6xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-center text-green-700 mb-4">Confirmation Successful!</h1>
    <p class="text-gray-700 text-center mb-6">{{ $message }}</p>

    @if(isset($type) && $type === 'adoption')
    <p class="text-sm text-gray-600 text-center mb-6">
      You can now track your adoption application status in your transactions page.
    </p>
    @elseif(isset($type) && $type === 'surrender')
    <p class="text-sm text-gray-600 text-center mb-6">
      You can now track your surrender application status in your transactions page.
    </p>
    @endif
    @else
    <div class="text-center text-red-500 mb-6">
      <i class="fas fa-exclamation-circle text-6xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-center text-red-700 mb-4">Confirmation Failed</h1>
    <p class="text-gray-700 text-center mb-6">{{ $message }}</p>
    @endif

    <div class="text-center mt-6">
      <button onclick="closeWindow()"
        class="bg-{{ $success ? 'green' : 'red' }}-600 text-white px-6 py-2 rounded-md hover:bg-{{ $success ? 'green' : 'red' }}-700 transition-colors cursor-pointer">
        Close this page
      </button>
    </div>

    <p class="text-xs text-gray-500 text-center mt-4">
      This page can be safely closed after confirmation.
    </p>
  </div>

  <script>
    function closeWindow() {
            // Try to close the window
            if (window.history.length > 1) {
                // If there's history, go back
                window.history.back();
            } else if (typeof window.close === 'function') {
                // Try to close the window
                try {
                    window.close();
                } catch (e) {
                    alert('You can safely close this tab/window now.');
                }
            } else {
                alert('You can safely close this tab/window now.');
            }
        }
        
        // Optional: Auto-close after 5 seconds on success
        @if($success)
        setTimeout(function() {
            closeWindow();
        }, 5000);
        @endif
  </script>
</body>

</html>