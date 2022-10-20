<?php

namespace GrowBitTech\Framework\Swagger;

use GrowBitTech\Framework\Action;
use GrowBitTech\Framework\RouteLoader\Attributes\Route;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

final class Swagger extends Action
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        $html = "<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='UTF-8'>
    <title>Swagger UI</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.14.3/swagger-ui.css' integrity='sha512-n2x79hahu4UUkv+ltJkOSoSLVsc4x6qgFuMHFdATzk9NNjnl9DqQCrTrAaIkqsExMFphJPnnKlcjaPjFYxmNeA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    <style>
      html
      {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
      }
      *,
      *:before,
      *:after
      {
        box-sizing: inherit;
      }

      body
      {
        margin:0;
        background: #fafafa;
      }
    </style>
  </head>

  <body>
    <div id='swagger-ui'></div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.14.3/swagger-ui-standalone-preset.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.14.3/swagger-ui-bundle.js'></script>
    <script>
    window.onload = function() {
      // Begin Swagger UI call region
      const ui = SwaggerUIBundle({
        url: '$actual_link/swageryaml',
        dom_id: '#swagger-ui',
        deepLinking: true,
          presets: [
              SwaggerUIBundle.presets.apis,
              SwaggerUIStandalonePreset
          ],
          layout: 'StandaloneLayout'
      })
      // End Swagger UI call region
      window.ui = ui
    }
  </script>
  </body>
</html>";

        $response->getBody()->write($html);

        return $response;
    }
}
