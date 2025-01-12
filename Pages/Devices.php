<?php

namespace Pages;

use Lib\DatabaseConnection;
use Services\DeviceService;
use UI\Header;
use UI\Navbar;

$db = new DatabaseConnection();
$deviceService = new DeviceService($db);

// Pobieramy listę wszystkich urządzeń
$devices = $deviceService->getDevices();

$currentPath = $_SERVER['REQUEST_URI'];

/**
 * Helper: Zwraca fragment SVG (ikona) zależnie od typu urządzenia (ID DeviceType).
 * W Twoim przypadku: ID=2 => Lampa, cokolwiek innego => Domyślna ikona.
 */
function getDeviceIcon(string $type): string
{
    switch ($type) {
        case 2:
            // Ikona lampy
            return '
                <g clip-path="url(#clip0_5507_2136)">
                    <path d="M8.00002 24C7.9999 20.0368 8.98121 16.1353 10.8563 12.6439C12.7315 9.15238 15.442 6.17959 18.746 3.99094C22.05 1.8023 25.8446 0.465915 29.7909 0.101127C33.7373 -0.263661 37.7125 0.354498 41.3617 1.90041C45.0109 3.44632 48.2205 5.87186 50.7039 8.96046C53.1873 12.0491 54.8671 15.7046 55.5935 19.6006C56.3198 23.4966 56.0701 27.5119 54.8665 31.2878C53.6629 35.0638 51.543 38.483 48.696 41.24C47.884 42.024 47.26 42.84 46.884 43.716L43.836 50.792C43.6814 51.1506 43.4251 51.4561 43.0988 51.6708C42.7726 51.8855 42.3906 51.9999 42 52H22C21.6088 52.0007 21.2259 51.8866 20.8989 51.6719C20.5718 51.4572 20.3149 51.1512 20.16 50.792L17.116 43.712C16.677 42.7789 16.0617 41.9395 15.304 41.24C12.9898 39.0052 11.1501 36.3266 9.89512 33.3643C8.64012 30.4021 7.99556 27.2171 8.00002 24ZM20 58C20 57.4696 20.2107 56.9609 20.5858 56.5858C20.9609 56.2107 21.4696 56 22 56H42C42.5305 56 43.0392 56.2107 43.4142 56.5858C43.7893 56.9609 44 57.4696 44 58C44 58.5304 43.7893 59.0391 43.4142 59.4142C43.0392 59.7893 42.5305 60 42 60L41.104 61.788C40.7721 62.4523 40.2617 63.0111 39.6301 63.4018C38.9985 63.7925 38.2707 63.9996 37.528 64H26.472C25.7294 63.9996 25.0015 63.7925 24.3699 63.4018C23.7383 63.0111 23.228 62.4523 22.896 61.788L22 60C21.4696 60 20.9609 59.7893 20.5858 59.4142C20.2107 59.0391 20 58.5304 20 58Z" fill="white"/>
                </g>
                <defs>
                    <clipPath id="clip0_5507_2136">
                        <rect width="64" height="64" fill="white"/>
                    </clipPath>
                </defs>
            ';
        default:
            // Domyślna ikona (np. kwadrat)
            return '
                <g clip-path="url(#clip0_5533_170)">
                    <path d="M26 24C25.4696 24 24.9609 24.2107 24.5858 24.5858C24.2107 24.9609 24 25.4696 24 26V38C24 38.5304 24.2107 39.0391 24.5858 39.4142C24.9609 39.7893 25.4696 40 26 40H38C38.5304 40 39.0391 39.7893 39.4142 39.4142C39.7893 39.0391 40 38.5304 40 38V26C40 25.4696 39.7893 24.9609 39.4142 24.5858C39.0391 24.2107 38.5304 24 38 24H26Z" fill="white"/>
                    <path d="M22 2C22 1.46957 21.7893 0.960859 21.4142 0.585786C21.0391 0.210714 20.5304 0 20 0C19.4696 0 18.9609 0.210714 18.5858 0.585786C18.2107 0.960859 18 1.46957 18 2V8C15.3478 8 12.8043 9.05357 10.9289 10.9289C9.05357 12.8043 8 15.3478 8 18H2C1.46957 18 0.960859 18.2107 0.585786 18.5858C0.210714 18.9609 0 19.4696 0 20C0 20.5304 0.210714 21.0391 0.585786 21.4142C0.960859 21.7893 1.46957 22 2 22H8V26H2C1.46957 26 0.960859 26.2107 0.585786 26.5858C0.210714 26.9609 0 27.4696 0 28C0 28.5304 0.210714 29.0391 0.585786 29.4142C0.960859 29.7893 1.46957 30 2 30H8V34H2C1.46957 34 0.960859 34.2107 0.585786 34.5858C0.210714 34.9609 0 35.4696 0 36C0 36.5304 0.210714 37.0391 0.585786 37.4142C0.960859 37.7893 1.46957 38 2 38H8V42H2C1.46957 42 0.960859 42.2107 0.585786 42.5858C0.210714 42.9609 0 43.4696 0 44C0 44.5304 0.210714 45.0391 0.585786 45.4142C0.960859 45.7893 1.46957 46 2 46H8C8 48.6522 9.05357 51.1957 10.9289 53.0711C12.8043 54.9464 15.3478 56 18 56V62C18 62.5304 18.2107 63.0391 18.5858 63.4142C18.9609 63.7893 19.4696 64 20 64C20.5304 64 21.0391 63.7893 21.4142 63.4142C21.7893 63.0391 22 62.5304 22 62V56H26V62C26 62.5304 26.2107 63.0391 26.5858 63.4142C26.9609 63.7893 27.4696 64 28 64C28.5304 64 29.0391 63.7893 29.4142 63.4142C29.7893 63.0391 30 62.5304 30 62V56H34V62C34 62.5304 34.2107 63.0391 34.5858 63.4142C34.9609 63.7893 35.4696 64 36 64C36.5304 64 37.0391 63.7893 37.4142 63.4142C37.7893 63.0391 38 62.5304 38 62V56H42V62C42 62.5304 42.2107 63.0391 42.5858 63.4142C42.9609 63.7893 43.4696 64 44 64C44.5304 64 45.0391 63.7893 45.4142 63.4142C45.7893 63.0391 46 62.5304 46 62V56C48.6522 56 51.1957 54.9464 53.0711 53.0711C54.9464 51.1957 56 48.6522 56 46H62C62.5304 46 63.0391 45.7893 63.4142 45.4142C63.7893 45.0391 64 44.5304 64 44C64 43.4696 63.7893 42.9609 63.4142 42.5858C63.0391 42.2107 62.5304 42 62 42H56V38H62C62.5304 38 63.0391 37.7893 63.4142 37.4142C63.7893 37.0391 64 36.5304 64 36C64 35.4696 63.7893 34.9609 63.4142 34.5858C63.0391 34.2107 62.5304 34 62 34H56V30H62C62.5304 30 63.0391 29.7893 63.4142 29.4142C63.7893 29.0391 64 28.5304 64 28C64 27.4696 63.7893 26.9609 63.4142 26.5858C63.0391 26.2107 62.5304 26 62 26H56V22H62C62.5304 22 63.0391 21.7893 63.4142 21.4142C63.7893 21.0391 64 20.5304 64 20C64 19.4696 63.7893 18.9609 63.4142 18.5858C63.0391 18.2107 62.5304 18 62 18H56C56 15.3478 54.9464 12.8043 53.0711 10.9289C51.1957 9.05357 48.6522 8 46 8V2C46 1.46957 45.7893 0.960859 45.4142 0.585786C45.0391 0.210714 44.5304 0 44 0C43.4696 0 42.9609 0.210714 42.5858 0.585786C42.2107 0.960859 42 1.46957 42 2V8H38V2C38 1.46957 37.7893 0.960859 37.4142 0.585786C37.0391 0.210714 36.5304 0 36 0C35.4696 0 34.9609 0.210714 34.5858 0.585786C34.2107 0.960859 34 1.46957 34 2V8H30V2C30 1.46957 29.7893 0.960859 29.4142 0.585786C29.0391 0.210714 28.5304 0 28 0C27.4696 0 26.9609 0.210714 26.5858 0.585786C26.2107 0.960859 26 1.46957 26 2V8H22V2ZM26 20H38C39.5913 20 41.1174 20.6321 42.2426 21.7574C43.3679 22.8826 44 24.4087 44 26V38C44 39.5913 43.3679 41.1174 42.2426 42.2426C41.1174 43.3679 39.5913 44 38 44H26C24.4087 44 22.8826 43.3679 21.7574 42.2426C20.6321 41.1174 20 39.5913 20 38V26C20 24.4087 20.6321 22.8826 21.7574 21.7574C22.8826 20.6321 24.4087 20 26 20Z" fill="white"/>
                </g>
                <defs>
                    <clipPath id="clip0_5533_170">
                        <rect width="64" height="64" fill="white"/>
                    </clipPath>
                </defs>
            ';
    }
}

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urządzenia | SmartHaven</title>
    <link rel="stylesheet" href="/styles/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous">
    </script>
</head>
<body class="d-flex flex-md-row p-1 p-md-3 gap-3 w-100 vh-100 overflow-hidden">

<?php
// Pasek nawigacji
$navbar = new Navbar($currentPath);
echo $navbar->render();
?>

<main class="card bg-dark-subtle flex-grow-1 p-4 overflow-y-auto" style="max-height: 100vh">
    <?php
    // Nagłówek strony
    $header = new Header('Urządzenia');
    echo $header->render();
    ?>
    <div class='d-grid gap-4 devices py-5'>
        <?php if (count($devices) === 0) : ?>
            <p class="text-muted">Brak urządzeń</p>
        <?php endif ?>
        <?php foreach ($devices as $device): ?>
            <?php
            // Jeżeli status=FALSE -> dodajemy klasę 'opacity-25' (wyszarz ikonę)
            $iconOpacityClass = !$device->getStatus() ? 'opacity-25' : '';
            ?>

            <a class='rounded-4 p-4 device-card d-flex gap-2 justify-content-between align-items-center text-decoration-none text-white'
               href='/app/devices/<?= $device->getId() ?>'>
                <div class='d-flex flex-column justify-content-center'>
                    <!-- Nazwa urządzenia -->
                    <h5 class='mb-0 text-truncate' title='<?= htmlspecialchars($device->getName()) ?>'>
                        <?= htmlspecialchars($device->getName()) ?>
                    </h5>
                    <!-- Nazwa grupy (Room) -->
                    <p class='m-0 text-secondary'>
                        <em><?= htmlspecialchars($device->getRoom()) ?></em>
                    </p>
                </div>
                <!-- Ikona urządzenia (zależna od DeviceTypeID), wyszarzana jeśli wyłączone -->
                <svg class='<?= $iconOpacityClass ?>' width='64' height='64'
                     viewBox='0 0 64 64'
                     fill='none' xmlns='http://www.w3.org/2000/svg'>
                    <?= getDeviceIcon((string)$device->getType()->getId()) ?>
                </svg>
            </a>
        <?php endforeach ?>
    </div>
</main>
</body>
</html>
