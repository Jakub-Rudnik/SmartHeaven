<?php

namespace UI;

use Interfaces\UIElement;

class Head implements UIElement
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(): string
    {
        return '
        <!DOCTYPE html>
            <html lang="en" data-bs-theme="dark">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>' . $this->title . ' | SmartHaven</title>
                    <link rel="stylesheet" href="/styles/main.css">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-Yvp0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                        crossorigin="anonymous">
                    </script>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
                    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
                    <script src="https://cdn.socket.io/4.8.1/socket.io.min.js" integrity="sha384-mkQ3/7FUtcGyoppY6bz/PORYoGqOl7/aSUMn2ymDOJcapfS6PHqxhRTMh1RR0Q6+" crossorigin="anonymous"></script>
                </head>
                <body class="d-flex flex-md-row p-1 p-md-3 gap-3 w-100 vh-100 overflow-hidden">
       ';
    }
}