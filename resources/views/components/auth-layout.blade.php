<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

  <link rel="icon" href="{{ asset('images/orpawnage-logo.png') }}" />

  @vite(['resources/css/auth.css','resources/css/preloader.css',
  'resources/css/admin/fonts/phosphor/phosphor-fill.css'])
</head>

<body
  x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">
  <!-- ===== Preloader Start ===== -->
  <div id="preloader" class="preloader h-16 w-16">
    <div class="dog">
      <div class="torso">
        <div class="fur">
          <div class="spot"></div>
        </div>
        <div class="neck">
          <div class="fur"></div>
          <div class="head">
            <div class="fur">
              <div class="snout"></div>
            </div>
            <div class="ears">
              <div class="ear">
                <div class="fur"></div>
              </div>
              <div class="ear">
                <div class="fur"></div>
              </div>
            </div>
            <div class="eye"></div>
          </div>
          <div class="collar"></div>
        </div>
        <div class="legs">
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
          <div class="leg">
            <div class="fur"></div>
            <div class="leg-inner">
              <div class="fur"></div>
            </div>
          </div>
        </div>
        <div class="tail">
          <div class="tail">
            <div class="tail">
              <div class="tail -end">
                <div class="tail">
                  <div class="tail">
                    <div class="tail">
                      <div class="tail"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ===== Preloader End ===== -->

  {{ $slot }}
  <script src="{{ asset('js/custom.js') }}"></script>
  <script defer src="{{ asset('js/auth.js') }}"></script>
  <script src="{{ asset('js/disableSubmission.js') }}"></script>
  <script src="{{ asset('js/preloader.js') }}"></script>
</body>

</html>