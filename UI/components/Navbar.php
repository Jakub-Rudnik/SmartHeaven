<?php

namespace UI\components;

use Interfaces\UIElement;

class Navbar implements UIElement
{
    private array $navItems;
    private string $currentPath;

    public function __construct(array $navItems, string $currentPath)
    {
        $this->navItems = $navItems;
        $this->currentPath = $currentPath;
    }

    public function render(): string
    {
        $currentPath = $_SERVER['REQUEST_URI'];

        //MOBILE MENU
        $html = '<nav class="w-100 d-flex d-md-none bg-dark-subtle border-top fixed-bottom py-3 px-4">
    <ul class="nav nav-pills d-flex justify-content-between w-100 gap-3">';

        foreach ($this->navItems as $item):
            $isCurrent = $this->currentPath == $item['url'] ? "active" : "btn btn-dark";

            $html .= "<li class='nav-item'>\n";
            $html .= "    <a class='nav-link text-white d-flex align-items-center gap-2 " . $isCurrent . "' href='" . $item['url'] . "'>\n";
            $html .= $item['icon'];
            $html .= "        <span class='d-none d-xl-block'>\n";
            $html .= $item['text'];
            $html .= "        </span>\n";
            $html .= "    </a>\n";
            $html .= "</li>\n";
        endforeach;

        $html .= '</ul></nav>';

        //DESKTOP MENU
        $html .= '<div class="card d-none d-md-flex flex-column justify-content-between align-items-center p-4 min-h-100 bg-dark-subtle">
                    <div class="d-flex flex-column justify-content-between align-items-center w-100 gap-4">
                        <!--Symbol logo-->
                            <svg class="d-xl-none" width="46" height="37" viewBox="0 0 46 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M24.6 14.3714C25.562 14.3713 26.5048 14.641 27.3212 15.15C28.1375 15.6589 28.7948 16.3866 29.2183 17.2504L29.315 17.4571H30.7714C30.9457 17.4571 31.1171 17.5014 31.2695 17.5857C31.422 17.6701 31.5505 17.7918 31.643 17.9395C31.7356 18.0871 31.7891 18.2558 31.7985 18.4298C31.808 18.6038 31.7731 18.7773 31.6971 18.9341L31.6272 19.0565L30.0309 21.45C29.9085 21.6341 29.8486 21.8526 29.8601 22.0733L29.8745 22.205L30.0195 23.0011C31.0368 28.5945 26.8227 33.7507 21.181 33.9101L20.9115 33.9143H12.2571C12.0829 33.9143 11.9115 33.87 11.7591 33.7856C11.6066 33.7013 11.4781 33.5796 11.3855 33.4319C11.293 33.2843 11.2395 33.1155 11.23 32.9416C11.2206 32.7676 11.2555 32.594 11.3314 32.4372L11.4014 32.3148L19.0591 20.8277C19.3186 20.4389 19.4572 19.9818 19.4571 19.5143C19.4571 18.1503 19.999 16.8422 20.9635 15.8777C21.9279 14.9132 23.236 14.3714 24.6 14.3714ZM21 23.6285C20.7213 23.6285 20.3181 23.7005 19.9344 23.8435C19.5487 23.9875 19.3358 24.1469 19.2617 24.2323L15.781 29.4544C16.8075 29.1592 17.905 28.8341 18.9315 28.432C20.029 28.0031 20.9661 27.5145 21.6151 26.9447C22.2446 26.3923 22.5429 25.8215 22.5429 25.1714C22.5429 24.7622 22.3803 24.3698 22.091 24.0804C21.8016 23.7911 21.4092 23.6285 21 23.6285ZM24.6 18.4857C24.3272 18.4857 24.0656 18.5941 23.8727 18.7869C23.6798 18.9798 23.5714 19.2415 23.5714 19.5143C23.5714 19.787 23.6798 20.0487 23.8727 20.2416C24.0656 20.4345 24.3272 20.5428 24.6 20.5428C24.8728 20.5428 25.1344 20.4345 25.3273 20.2416C25.5202 20.0487 25.6286 19.787 25.6286 19.5143C25.6286 19.2415 25.5202 18.9798 25.3273 18.7869C25.1344 18.5941 24.8728 18.4857 24.6 18.4857Z"
                                fill="white"/>
                                <path d="M43.1143 28.7714V23.3204C43.1143 22.0032 42.5945 20.7393 41.6679 19.8031L26.6108 4.59038C24.6541 2.61346 21.4602 2.61347 19.5035 4.59038L4.44634 19.8031C3.51975 20.7393 3 22.0032 3 23.3204V31.3966V35.9714"
                                stroke="white" stroke-width="5"/>
                            </svg>
                            <!--Full size logo-->
                            <svg class="d-none d-xl-block" width="172" height="45" viewBox="0 0 172 45" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.38413 35.0014C6.21327 35.0014 4.41851 34.4958 2.99977 33.4843C1.59813 32.4556 0.837487 30.9557 0.717834 28.9843H6.76881C6.85428 30.0299 7.31579 30.5527 8.15335 30.5527C8.46104 30.5527 8.71745 30.4842 8.92256 30.3472C9.14475 30.1927 9.25586 29.9614 9.25586 29.6527C9.25586 29.2242 9.02511 28.8814 8.56361 28.6243C8.10208 28.35 7.38416 28.0413 6.40985 27.6985C5.24753 27.2872 4.28176 26.8842 3.51257 26.4901C2.76046 26.0957 2.11093 25.5213 1.56395 24.7671C1.01696 24.0128 0.75202 23.0443 0.769112 21.8614C0.769112 20.6785 1.06824 19.6757 1.6665 18.8528C2.28186 18.0128 3.11088 17.3786 4.15356 16.95C5.21333 16.5214 6.40132 16.3071 7.71748 16.3071C9.93961 16.3071 11.7002 16.8214 12.9993 17.85C14.3155 18.8785 15.0077 20.3271 15.0761 22.1957H8.9482C8.9311 21.6814 8.80289 21.3128 8.56361 21.09C8.32429 20.8671 8.0337 20.7557 7.69184 20.7557C7.45253 20.7557 7.25598 20.8414 7.10213 21.0128C6.94829 21.1671 6.87138 21.39 6.87138 21.6814C6.87138 22.0928 7.0936 22.4357 7.538 22.71C7.99953 22.9671 8.72599 23.2843 9.71739 23.6614C10.8626 24.09 11.8027 24.5014 12.5378 24.8957C13.2899 25.29 13.9394 25.8386 14.4864 26.5414C15.0334 27.2442 15.3069 28.127 15.3069 29.1901C15.3069 30.3042 15.0334 31.3071 14.4864 32.1985C13.9394 33.0727 13.1446 33.7586 12.1019 34.2556C11.0592 34.7529 9.81994 35.0014 8.38413 35.0014ZM36.6136 20.2157C38.4595 20.2157 39.8868 20.7728 40.8954 21.8871C41.9209 23.0014 42.4336 24.51 42.4336 26.4127V34.8214H36.7674V27.1327C36.7674 26.5156 36.5793 26.0358 36.2033 25.6927C35.8442 25.3327 35.3572 25.1528 34.7417 25.1528C34.1094 25.1528 33.6138 25.3327 33.2546 25.6927C32.8958 26.0358 32.7162 26.5156 32.7162 27.1327V34.8214H27.0498V27.1327C27.0498 26.5156 26.8619 26.0358 26.4857 25.6927C26.1268 25.3327 25.6396 25.1528 25.0243 25.1528C24.3919 25.1528 23.8962 25.3327 23.5372 25.6927C23.1783 26.0358 22.9988 26.5156 22.9988 27.1327V34.8214H17.3067V20.3186H22.9988V22.2728C23.409 21.6557 23.9645 21.1586 24.6653 20.7814C25.3832 20.4043 26.2208 20.2157 27.178 20.2157C28.2208 20.2157 29.1438 20.4471 29.9471 20.91C30.7504 21.3557 31.3916 21.99 31.8701 22.8128C32.3999 22.0586 33.0751 21.4414 33.8956 20.9614C34.7163 20.4643 35.6221 20.2157 36.6136 20.2157ZM44.1304 27.5701C44.1304 26.0444 44.3868 24.7243 44.8995 23.61C45.4294 22.4786 46.1473 21.6214 47.0532 21.0386C47.9593 20.4386 48.9764 20.1386 50.1044 20.1386C51.0444 20.1386 51.8566 20.3357 52.5403 20.73C53.224 21.1071 53.7451 21.63 54.1042 22.2986V20.3186H59.7703V34.8214H54.1042V32.8414C53.7451 33.5101 53.224 34.0415 52.5403 34.4356C51.8566 34.8128 51.0444 35.0014 50.1044 35.0014C48.9764 35.0014 47.9593 34.7099 47.0532 34.1272C46.1473 33.527 45.4294 32.67 44.8995 31.5556C44.3868 30.4243 44.1304 29.0958 44.1304 27.5701ZM54.1042 27.5701C54.1042 26.7985 53.9075 26.1986 53.5144 25.7701C53.1213 25.3413 52.6171 25.1271 52.0019 25.1271C51.3864 25.1271 50.8823 25.3413 50.4891 25.7701C50.0958 26.1986 49.8994 26.7985 49.8994 27.5701C49.8994 28.3414 50.0958 28.9413 50.4891 29.3701C50.8823 29.7986 51.3864 30.0127 52.0019 30.0127C52.6171 30.0127 53.1213 29.7986 53.5144 29.3701C53.9075 28.9413 54.1042 28.3414 54.1042 27.5701ZM68.0185 22.9928C68.5995 22.1528 69.3089 21.4843 70.1465 20.9871C70.9841 20.4728 71.8559 20.2157 72.7618 20.2157V26.3101H71.1465C70.0697 26.3101 69.2747 26.4987 68.7619 26.8756C68.2663 27.2528 68.0185 27.9215 68.0185 28.8814V34.8214H62.3264V20.3186H68.0185V22.9928ZM83.2948 29.9614V34.8214H81.1412C77.1756 34.8214 75.1927 32.8414 75.1927 28.8814V25.0757H73.3979V20.3186H75.1927V16.8214H80.8848V20.3186H83.2437V25.0757H80.8848V28.9843C80.8848 29.3271 80.9616 29.5756 81.1155 29.7301C81.2865 29.8843 81.56 29.9614 81.9359 29.9614H83.2948ZM102.257 16.6157V34.8214H96.5645V27.7243H91.1547V34.8214H85.4626V16.6157H91.1547V23.1728H96.5645V16.6157H102.257ZM104.048 27.5701C104.048 26.0444 104.304 24.7243 104.817 23.61C105.347 22.4786 106.065 21.6214 106.971 21.0386C107.877 20.4386 108.894 20.1386 110.022 20.1386C110.962 20.1386 111.774 20.3357 112.458 20.73C113.142 21.1071 113.663 21.63 114.022 22.2986V20.3186H119.688V34.8214H114.022V32.8414C113.663 33.5101 113.142 34.0415 112.458 34.4356C111.774 34.8128 110.962 35.0014 110.022 35.0014C108.894 35.0014 107.877 34.7099 106.971 34.1272C106.065 33.527 105.347 32.67 104.817 31.5556C104.304 30.4243 104.048 29.0958 104.048 27.5701ZM114.022 27.5701C114.022 26.7985 113.825 26.1986 113.432 25.7701C113.039 25.3413 112.535 25.1271 111.92 25.1271C111.304 25.1271 110.8 25.3413 110.407 25.7701C110.014 26.1986 109.817 26.7985 109.817 27.5701C109.817 28.3414 110.014 28.9413 110.407 29.3701C110.8 29.7986 111.304 30.0127 111.92 30.0127C112.535 30.0127 113.039 29.7986 113.432 29.3701C113.825 28.9413 114.022 28.3414 114.022 27.5701ZM129.577 29.3956L131.885 20.3186H137.936L133.116 34.8214H126.014L121.193 20.3186H127.244L129.577 29.3956ZM153.445 27.4414C153.445 27.8358 153.42 28.2127 153.368 28.5727H144.215C144.3 29.8244 144.822 30.4501 145.779 30.4501C146.394 30.4501 146.839 30.1672 147.112 29.6014H153.138C152.932 30.6301 152.497 31.5556 151.83 32.3785C151.18 33.1842 150.351 33.8271 149.343 34.3072C148.352 34.7701 147.258 35.0014 146.061 35.0014C144.625 35.0014 143.343 34.7013 142.215 34.1014C141.104 33.5015 140.232 32.6442 139.6 31.5301C138.985 30.3985 138.677 29.0786 138.677 27.5701C138.677 26.0613 138.985 24.75 139.6 23.6357C140.232 22.5043 141.104 21.6385 142.215 21.0386C143.343 20.4386 144.625 20.1386 146.061 20.1386C147.497 20.1386 148.77 20.4386 149.881 21.0386C151.009 21.6214 151.881 22.4614 152.497 23.5586C153.129 24.6557 153.445 25.9501 153.445 27.4414ZM147.676 26.0785C147.676 25.5987 147.523 25.2385 147.215 24.9986C146.907 24.7414 146.523 24.6128 146.061 24.6128C145.053 24.6128 144.463 25.1014 144.292 26.0785H147.676ZM165.373 20.2157C167.031 20.2157 168.322 20.7728 169.245 21.8871C170.185 23.0014 170.655 24.51 170.655 26.4127V34.8214H164.989V27.1327C164.989 26.4471 164.8 25.9071 164.424 25.5127C164.066 25.1014 163.578 24.8957 162.963 24.8957C162.33 24.8957 161.835 25.1014 161.476 25.5127C161.117 25.9071 160.937 26.4471 160.937 27.1327V34.8214H155.245V20.3186H160.937V22.53C161.382 21.8443 161.972 21.2871 162.707 20.8586C163.459 20.43 164.348 20.2157 165.373 20.2157Z"
                                 fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M68.3727 7.5C68.8721 7.49995 69.3619 7.64041 69.7862 7.90548C70.2098 8.17055 70.551 8.54956 70.7711 8.99946L70.8212 9.10713H71.5777C71.6679 9.10713 71.7573 9.13016 71.8361 9.1741C71.9152 9.21809 71.9822 9.28147 72.03 9.35835C72.0781 9.43525 72.1061 9.52313 72.1114 9.61376C72.1161 9.70434 72.098 9.79472 72.0585 9.87643L72.0222 9.94016L71.1932 11.1868C71.1295 11.2826 71.0985 11.3965 71.1045 11.5114L71.1118 11.58L71.1871 11.9946C71.7155 14.9079 69.5271 17.5934 66.5973 17.6764L66.4573 17.6786H61.9628C61.8724 17.6786 61.7833 17.6555 61.7042 17.6116C61.6251 17.5676 61.5584 17.5043 61.5103 17.4274C61.4622 17.3504 61.4345 17.2626 61.4292 17.1719C61.4244 17.0814 61.4426 16.991 61.4821 16.9093L61.5184 16.8455L65.4953 10.8627C65.6297 10.6601 65.702 10.4221 65.702 10.1786C65.702 9.46817 65.9833 8.78685 66.484 8.28454C66.9848 7.78221 67.6645 7.5 68.3727 7.5ZM66.5031 12.3214C66.3583 12.3214 66.149 12.3589 65.9498 12.4334C65.7494 12.5084 65.6388 12.5914 65.6005 12.6359L63.7929 15.3557C64.326 15.202 64.8959 15.0327 65.429 14.8232C65.9989 14.5998 66.4855 14.3454 66.8227 14.0486C67.1495 13.7609 67.3044 13.4636 67.3044 13.125C67.3044 12.9119 67.22 12.7075 67.07 12.5568C66.9194 12.4061 66.7156 12.3214 66.5031 12.3214ZM68.3727 9.64286C68.2311 9.64286 68.0949 9.69931 67.9952 9.79975C67.8947 9.90022 67.8385 10.0365 67.8385 10.1786C67.8385 10.3206 67.8947 10.4569 67.9952 10.5574C68.0949 10.6578 68.2311 10.7143 68.3727 10.7143C68.5142 10.7143 68.6504 10.6578 68.7504 10.5574C68.8509 10.4569 68.9068 10.3206 68.9068 10.1786C68.9068 10.0365 68.8509 9.90022 68.7504 9.79975C68.6504 9.69931 68.5142 9.64286 68.3727 9.64286Z"
                                fill="white"/>
                                <path d="M77.9876 15V12.1915C77.9876 11.4859 77.7098 10.8088 77.2152 10.3072L69.4699 2.45912C68.4245 1.40006 66.7184 1.40006 65.6731 2.45912L57.9278 10.3072C57.4329 10.8088 57.1552 11.4859 57.1552 12.1915V16.3672V18.75"
                                stroke="white" stroke-width="2"/>
                            </svg>
                            <nav class="w-100">
                                <ul class="nav nav-pills d-flex flex-column w-100 gap-3">';

        foreach ($this->navItems as $item):
            $isCurrent = $this->currentPath == $item['url'] ? "active" : "btn btn-dark";
            $html .= "<li class='nav-item'>";
            $html .= "<a class='nav-link text-white d-flex align-items-center gap-2 " . $isCurrent . "' href='" . $item['url'] . "'>";
            $html .= $item['icon'];
            $html .= "<span class='d-none d-xl-block'>";
            $html .= $item['text'];
            $html .= "</span></a></li>";
        endforeach;

        $html .= '</ul></nav></div>';

        $html .= '<div class="nav-item d-flex flex-column flex-xl-row gap-4 justify-content-between align-items-center w-100">
                <a class="nav-link d-flex align-items-center gap-2 btn btn-dark p-2" href="/profile">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M3 14C3 14 2 14 2 13C2 12 3 9 8 9C13 9 14 12 14 13C14 14 13 14 13 14H3ZM8 8C8.79565 8 9.55871 7.68393 10.1213 7.12132C10.6839 6.55871 11 5.79565 11 5C11 4.20435 10.6839 3.44129 10.1213 2.87868C9.55871 2.31607 8.79565 2 8 2C7.20435 2 6.44129 2.31607 5.87868 2.87868C5.31607 3.44129 5 4.20435 5 5C5 5.79565 5.31607 6.55871 5.87868 7.12132C6.44129 7.68393 7.20435 8 8 8V8Z"
                      fill="white"/>
            </svg>
            <span class="d-none d-xl-block text-start"><small>Dawid Animowski</small></span>
        </a>
        <a class="nav-link d-flex justify-content-center align-items-center p-2 btn btn-dark" href="/logout">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.5 14.9999C1.36739 14.9999 1.24021 15.0526 1.14645 15.1464C1.05268 15.2401 1 15.3673 1 15.4999C1 15.6325 1.05268 15.7597 1.14645 15.8535C1.24021 15.9472 1.36739 15.9999 1.5 15.9999H14.5C14.6326 15.9999 14.7598 15.9472 14.8536 15.8535C14.9473 15.7597 15 15.6325 15 15.4999C15 15.3673 14.9473 15.2401 14.8536 15.1464C14.7598 15.0526 14.6326 14.9999 14.5 14.9999H13V2.49992C13 2.1021 12.842 1.72057 12.5607 1.43926C12.2794 1.15796 11.8978 0.999924 11.5 0.999924H11V0.499924C11 0.428355 10.9846 0.357622 10.9549 0.292507C10.9252 0.227391 10.8819 0.16941 10.8278 0.122483C10.7738 0.0755565 10.7103 0.0407771 10.6417 0.020496C10.5731 0.000214798 10.5009 -0.0050954 10.43 0.00492428L3.43 1.00492C3.31072 1.02179 3.20154 1.08115 3.12253 1.1721C3.04353 1.26305 3.00002 1.37946 3 1.49992V14.9999H1.5ZM11 1.99992V14.9999H12V2.49992C12 2.36732 11.9473 2.24014 11.8536 2.14637C11.7598 2.0526 11.6326 1.99992 11.5 1.99992H11ZM8.5 9.99993C8.224 9.99993 8 9.55193 8 8.99993C8 8.44793 8.224 7.99993 8.5 7.99993C8.776 7.99993 9 8.44793 9 8.99993C9 9.55193 8.776 9.99993 8.5 9.99993Z"
                      fill="white"/>
            </svg>
        </a>
    </div>
</div>
</div>
    </div>
    </div>';
        return $html;
    }
}
