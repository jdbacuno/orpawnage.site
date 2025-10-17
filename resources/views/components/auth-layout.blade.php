<!DOCTYPE html>
<html lang="en" class="smooth-scroll scrollbar-hidden">

<head>
  <meta charset="UTF-8" />
  <link rel="canonical" href="https://orpawnage.site" />
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'ORPAWNAGE | Adopt. Don\'t Shop.')</title>
  <meta name="description" content="@yield('description', 'At OrPAWnage, we believe that every animal deserves a loving
            home. Our mission is to rescue, protect, and find forever homes
            for abandoned or abused pets. With the help of our compassionate
            team and supportive community, we strive to reduce animal
            homelessness and promote responsible pet ownership.')">
  <meta name="keywords"
    content="@yield('keywords', 'orpawnage, orpawnage.site, orpawnage.com, pawnage, paws, paw, orphanage, pet adoption, adoption adopt, animal services, angeles city veterinary office, adopt a pet')">
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

  <link rel="icon" type="image/x-icon" href="https://orpawnage.site/images/favicon.ico">
  <link rel="icon" type="image/x-icon" sizes="16x16" href="https://orpawnage.site/images/favicon-16x16.ico">

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "OrPAWnage",
      "url": "https://orpawnage.site",
      "logo": "https://orpawnage.site/images/favicon.ico",
      "favicon": "https://orpawnage.site/images/favicon.ico"
    }
  </script>

  @vite(['resources/css/auth.css','resources/css/preloader.css',
  'resources/css/admin/fonts/phosphor/phosphor-fill.css', 'resources/css/orpawnage-animation.css'])

  <style>
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    @media (max-width: 1024px) and (min-width: 912px) {
      .left-content {
        justify-content: center;
      }

      .logo {
        display: block;
      }

      .right-content {
        display: none;
      }
    }
  </style>
</head>

<body x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop':
 false }" x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">
  <!-- ===== Preloader Start ===== -->
  <div id="preloader" class="preloader">
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

  <div id="main-content" class="hidden">
    {{ $slot }}
  </div>


  <script src="{{ asset('js/custom.js') }}"></script>
  <script defer src="{{ asset('js/auth.js') }}"></script>
  <script src="{{ asset('js/disableSubmission.js') }}"></script>
  <script src="{{ asset('js/preloader.js') }}"></script>
</body>

</html>
