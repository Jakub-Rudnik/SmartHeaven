<?php
require_once 'autoload.php';

use UI\components\Navbar;
use UI\components\Dashboard;
use UI\components\Devices;
use Lib\DatabaseConnection;
use Services\DeviceService;



$currentPath = $_SERVER['REQUEST_URI'];
$navItems = [
    [
        'url' => '/',
        'text' => 'Tablica',
        'icon' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.5 10.9949V14.4999C6.5 14.6325 6.44732 14.7597 6.35355 14.8535C6.25979 14.9472 6.13261 14.9999 6 14.9999H2C1.86739 14.9999 1.74022 14.9472 1.64645 14.8535C1.55268 14.7597 1.5 14.6325 1.5 14.4999V7.49992C1.49988 7.43421 1.51272 7.36913 1.53777 7.30839C1.56282 7.24764 1.5996 7.19244 1.646 7.14592L7.646 1.14592C7.69245 1.09935 7.74762 1.06241 7.80837 1.0372C7.86911 1.012 7.93423 0.999023 8 0.999023C8.06577 0.999023 8.13089 1.012 8.19164 1.0372C8.25238 1.06241 8.30756 1.09935 8.354 1.14592L14.354 7.14592C14.4004 7.19244 14.4372 7.24764 14.4622 7.30839C14.4873 7.36913 14.5001 7.43421 14.5 7.49992V14.4999C14.5 14.6325 14.4473 14.7597 14.3536 14.8535C14.2598 14.9472 14.1326 14.9999 14 14.9999H10C9.86739 14.9999 9.74022 14.9472 9.64645 14.8535C9.55268 14.7597 9.5 14.6325 9.5 14.4999V10.9999C9.5 10.7499 9.25 10.4999 9 10.4999H7C6.75 10.4999 6.5 10.7499 6.5 10.9949Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M13 2.5V6L11 4V2.5C11 2.36739 11.0527 2.24021 11.1464 2.14645C11.2402 2.05268 11.3674 2 11.5 2H12.5C12.6326 2 12.7598 2.05268 12.8536 2.14645C12.9473 2.24021 13 2.36739 13 2.5Z" fill="white"/>
</svg>
'
    ],
    [
        'url' => '/devices',
        'text' => 'Urządzenia',
        'icon' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M9.82782 3H13.8098C14.0877 2.99997 14.3626 3.05787 14.6169 3.16999C14.8712 3.28212 15.0994 3.44601 15.2868 3.65122C15.4742 3.85643 15.6168 4.09845 15.7055 4.36184C15.7942 4.62524 15.827 4.90422 15.8018 5.181L15.1648 12.181C15.1197 12.6779 14.8904 13.14 14.522 13.4766C14.1537 13.8131 13.6728 13.9998 13.1738 14H2.82582C2.32686 13.9998 1.84599 13.8131 1.47762 13.4766C1.10925 13.14 0.87998 12.6779 0.834824 12.181L0.197824 5.181C0.15521 4.71778 0.276218 4.25427 0.539824 3.871L0.499824 3C0.499824 2.46957 0.710538 1.96086 1.08561 1.58579C1.46068 1.21071 1.96939 1 2.49982 1H6.17182C6.70221 1.00011 7.21084 1.2109 7.58582 1.586L8.41382 2.414C8.78881 2.7891 9.29743 2.99989 9.82782 3ZM1.50582 3.12C1.71982 3.042 1.94982 3 2.18982 3H7.58582L6.87882 2.293C6.69133 2.10545 6.43702 2.00006 6.17182 2H2.49982C2.23787 1.99995 1.98635 2.1027 1.79935 2.28614C1.61235 2.46959 1.5048 2.71909 1.49982 2.981L1.50582 3.12Z" fill="white"/>
</svg>
'
    ],
    [
        'url' => '/groups',
        'text' => 'Grupy urządzeń',
        'icon' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_5495_1743)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 0.5C5.5 0.367392 5.44732 0.240215 5.35355 0.146447C5.25979 0.0526784 5.13261 0 5 0C4.86739 0 4.74021 0.0526784 4.64645 0.146447C4.55268 0.240215 4.5 0.367392 4.5 0.5V2C3.83696 2 3.20107 2.26339 2.73223 2.73223C2.26339 3.20107 2 3.83696 2 4.5H0.5C0.367392 4.5 0.240215 4.55268 0.146447 4.64645C0.0526784 4.74021 0 4.86739 0 5C0 5.13261 0.0526784 5.25979 0.146447 5.35355C0.240215 5.44732 0.367392 5.5 0.5 5.5H2V6.5H0.5C0.367392 6.5 0.240215 6.55268 0.146447 6.64645C0.0526784 6.74021 0 6.86739 0 7C0 7.13261 0.0526784 7.25979 0.146447 7.35355C0.240215 7.44732 0.367392 7.5 0.5 7.5H2V8.5H0.5C0.367392 8.5 0.240215 8.55268 0.146447 8.64645C0.0526784 8.74021 0 8.86739 0 9C0 9.13261 0.0526784 9.25979 0.146447 9.35355C0.240215 9.44732 0.367392 9.5 0.5 9.5H2V10.5H0.5C0.367392 10.5 0.240215 10.5527 0.146447 10.6464C0.0526784 10.7402 0 10.8674 0 11C0 11.1326 0.0526784 11.2598 0.146447 11.3536C0.240215 11.4473 0.367392 11.5 0.5 11.5H2C2 12.163 2.26339 12.7989 2.73223 13.2678C3.20107 13.7366 3.83696 14 4.5 14V15.5C4.5 15.6326 4.55268 15.7598 4.64645 15.8536C4.74021 15.9473 4.86739 16 5 16C5.13261 16 5.25979 15.9473 5.35355 15.8536C5.44732 15.7598 5.5 15.6326 5.5 15.5V14H6.5V15.5C6.5 15.6326 6.55268 15.7598 6.64645 15.8536C6.74021 15.9473 6.86739 16 7 16C7.13261 16 7.25979 15.9473 7.35355 15.8536C7.44732 15.7598 7.5 15.6326 7.5 15.5V14H8.5V15.5C8.5 15.6326 8.55268 15.7598 8.64645 15.8536C8.74021 15.9473 8.86739 16 9 16C9.13261 16 9.25979 15.9473 9.35355 15.8536C9.44732 15.7598 9.5 15.6326 9.5 15.5V14H10.5V15.5C10.5 15.6326 10.5527 15.7598 10.6464 15.8536C10.7402 15.9473 10.8674 16 11 16C11.1326 16 11.2598 15.9473 11.3536 15.8536C11.4473 15.7598 11.5 15.6326 11.5 15.5V14C12.163 14 12.7989 13.7366 13.2678 13.2678C13.7366 12.7989 14 12.163 14 11.5H15.5C15.6326 11.5 15.7598 11.4473 15.8536 11.3536C15.9473 11.2598 16 11.1326 16 11C16 10.8674 15.9473 10.7402 15.8536 10.6464C15.7598 10.5527 15.6326 10.5 15.5 10.5H14V9.5H15.5C15.6326 9.5 15.7598 9.44732 15.8536 9.35355C15.9473 9.25979 16 9.13261 16 9C16 8.86739 15.9473 8.74021 15.8536 8.64645C15.7598 8.55268 15.6326 8.5 15.5 8.5H14V7.5H15.5C15.6326 7.5 15.7598 7.44732 15.8536 7.35355C15.9473 7.25979 16 7.13261 16 7C16 6.86739 15.9473 6.74021 15.8536 6.64645C15.7598 6.55268 15.6326 6.5 15.5 6.5H14V5.5H15.5C15.6326 5.5 15.7598 5.44732 15.8536 5.35355C15.9473 5.25979 16 5.13261 16 5C16 4.86739 15.9473 4.74021 15.8536 4.64645C15.7598 4.55268 15.6326 4.5 15.5 4.5H14C14 3.83696 13.7366 3.20107 13.2678 2.73223C12.7989 2.26339 12.163 2 11.5 2V0.5C11.5 0.367392 11.4473 0.240215 11.3536 0.146447C11.2598 0.0526784 11.1326 0 11 0C10.8674 0 10.7402 0.0526784 10.6464 0.146447C10.5527 0.240215 10.5 0.367392 10.5 0.5V2H9.5V0.5C9.5 0.367392 9.44732 0.240215 9.35355 0.146447C9.25979 0.0526784 9.13261 0 9 0C8.86739 0 8.74021 0.0526784 8.64645 0.146447C8.55268 0.240215 8.5 0.367392 8.5 0.5V2H7.5V0.5C7.5 0.367392 7.44732 0.240215 7.35355 0.146447C7.25979 0.0526784 7.13261 0 7 0C6.86739 0 6.74021 0.0526784 6.64645 0.146447C6.55268 0.240215 6.5 0.367392 6.5 0.5V2H5.5V0.5ZM6.5 5C6.10218 5 5.72064 5.15804 5.43934 5.43934C5.15804 5.72064 5 6.10218 5 6.5V9.5C5 9.89782 5.15804 10.2794 5.43934 10.5607C5.72064 10.842 6.10218 11 6.5 11H9.5C9.89782 11 10.2794 10.842 10.5607 10.5607C10.842 10.2794 11 9.89782 11 9.5V6.5C11 6.10218 10.842 5.72064 10.5607 5.43934C10.2794 5.15804 9.89782 5 9.5 5H6.5ZM6.5 6C6.36739 6 6.24021 6.05268 6.14645 6.14645C6.05268 6.24021 6 6.36739 6 6.5V9.5C6 9.63261 6.05268 9.75979 6.14645 9.85355C6.24021 9.94732 6.36739 10 6.5 10H9.5C9.63261 10 9.75979 9.94732 9.85355 9.85355C9.94732 9.75979 10 9.63261 10 9.5V6.5C10 6.36739 9.94732 6.24021 9.85355 6.14645C9.75979 6.05268 9.63261 6 9.5 6H6.5Z" fill="white"/>
</g>
<defs>
<clipPath id="clip0_5495_1743">
<rect width="16" height="16" fill="white"/>
</clipPath>
</defs>
</svg>
'
    ],
    [
        'url' => '/schedules',
        'text' => 'Harmonogramy',
        'icon' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_5495_1747)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M6.01146 0.5C6.01146 0.367392 6.06414 0.240215 6.1579 0.146447C6.25167 0.0526784 6.37885 0 6.51146 0L9.51146 0C9.64406 0 9.77124 0.0526784 9.86501 0.146447C9.95878 0.240215 10.0115 0.367392 10.0115 0.5C10.0115 0.632608 9.95878 0.759785 9.86501 0.853553C9.77124 0.947322 9.64406 1 9.51146 1H9.01146V2.07C10.3733 2.26658 11.647 2.86007 12.6734 3.77633C13.6999 4.6926 14.4336 5.89101 14.7829 7.22186C15.1322 8.5527 15.0816 9.95697 14.6374 11.2592C14.1932 12.5615 13.3752 13.704 12.2855 14.544L12.8865 15.146C12.9803 15.2398 13.0331 15.367 13.0332 15.4996C13.0333 15.6323 12.9807 15.7596 12.887 15.8535C12.7932 15.9474 12.666 16.0002 12.5333 16.0003C12.4006 16.0004 12.2733 15.9478 12.1795 15.854L11.4335 15.108C10.3884 15.6946 9.20984 16.0018 8.01146 16C6.81308 16.0018 5.63447 15.6946 4.58946 15.108L3.84346 15.854C3.79697 15.9004 3.74179 15.9372 3.68108 15.9623C3.62036 15.9874 3.5553 16.0003 3.4896 16.0003C3.42391 16.0002 3.35886 15.9872 3.29818 15.9621C3.2375 15.9369 3.18238 15.9 3.13596 15.8535C3.08954 15.807 3.05272 15.7518 3.02763 15.6911C3.00253 15.6304 2.98963 15.5653 2.98968 15.4996C2.98977 15.367 3.04257 15.2398 3.13646 15.146L3.73846 14.544C2.64874 13.704 1.83068 12.5616 1.38646 11.2594C0.942244 9.95726 0.891563 8.55306 1.24075 7.22224C1.58994 5.89143 2.32351 4.693 3.34984 3.77667C4.37616 2.86034 5.64973 2.26673 7.01146 2.07V1H6.51146C6.37885 1 6.25167 0.947322 6.1579 0.853553C6.06414 0.759785 6.01146 0.632608 6.01146 0.5ZM0.871458 5.387C0.612718 5.16194 0.403047 4.88605 0.255487 4.57649C0.107926 4.26693 0.0256296 3.93032 0.0137162 3.5876C0.00180277 3.24488 0.0605268 2.90337 0.186236 2.58431C0.311946 2.26525 0.501952 1.97547 0.74444 1.73298C0.986928 1.49049 1.27671 1.30049 1.59577 1.17478C1.91483 1.04907 2.25633 0.990345 2.59906 1.00226C2.94178 1.01417 3.27839 1.09647 3.58794 1.24403C3.8975 1.39159 4.17339 1.60126 4.39846 1.86C2.87841 2.63175 1.6432 3.86695 0.871458 5.387ZM11.6245 1.86C11.8495 1.60126 12.1254 1.39159 12.435 1.24403C12.7445 1.09647 13.0811 1.01417 13.4239 1.00226C13.7666 0.990345 14.1081 1.04907 14.4271 1.17478C14.7462 1.30049 15.036 1.49049 15.2785 1.73298C15.521 1.97547 15.711 2.26525 15.8367 2.58431C15.9624 2.90337 16.0211 3.24488 16.0092 3.5876C15.9973 3.93032 15.915 4.26693 15.7674 4.57649C15.6199 4.88605 15.4102 5.16194 15.1515 5.387C14.3797 3.86695 13.1445 2.63175 11.6245 1.86ZM8.51146 5.5C8.51146 5.36739 8.45878 5.24021 8.36501 5.14645C8.27124 5.05268 8.14407 5 8.01146 5C7.87885 5 7.75167 5.05268 7.6579 5.14645C7.56414 5.24021 7.51146 5.36739 7.51146 5.5V8.862L6.08246 11.242C6.01416 11.3558 5.99387 11.492 6.02603 11.6208C6.05819 11.7495 6.14018 11.8602 6.25396 11.9285C6.36774 11.9968 6.50398 12.0171 6.63273 11.9849C6.76147 11.9528 6.87216 11.8708 6.94046 11.757L8.44046 9.257C8.48695 9.17934 8.51149 9.09051 8.51146 9V5.5Z" fill="white"/>
</g>
<defs>
<clipPath id="clip0_5495_1747">
<rect width="16" height="16" fill="white"/>
</clipPath>
</defs>
</svg>
'
    ]
];


$DatabaseConnection = new DatabaseConnection();
$navbar = new Navbar($navItems, $currentPath);
$deviceService = new DeviceService($DatabaseConnection);



$deviceId = 1; // ID of the device
$newState = '1'; // New state as a string '1' or '0'

$deviceService->updateDeviceStatus($deviceId, $newState);


?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHaven</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/notifications.css">
</head>
<body class="d-flex flex-md-row p-1 p-md-3 gap-3 w-100 min-vh-100">
<div id="notifications" class="notifications-container"></div>



<?= $navbar->render() ?>

<main class="card bg-dark-subtle flex-grow-1 p-4" style="min-height: 100%">

    <?php
    
    $request = explode('/', $_SERVER['REQUEST_URI']);

    switch ($request[1]) {
        case '':
            $dashboard = new Dashboard();
            echo $dashboard->render();

           
            break;
        case 'devices':
            $devices = new Devices($DatabaseConnection);
            echo $devices->render();

            
            break;
        default:
            echo '404';
            break;
    }
    ?>
</main>
<script src="/scripts/notifications.js"></script>
</body>
</html>