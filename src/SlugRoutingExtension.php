<?php

namespace Bolt\Extension\MichaelMezger\SlugRouting;

use Silex\Application;
use Bolt\Extension\SimpleExtension;
use Symfony\Component\HttpFoundation\Request;
use Bolt\Extension\MichaelMezger\SlugRouting\Slugify\Slugify;

/**
 * ExtensionName extension class.
 *
 * @author Your Name <you@example.com>
 */
class SlugRoutingExtension extends SimpleExtension
{
    public function boot(Application $app)
    {
        $app['controller.frontend'] = $app->share(
            function () {
                return new \Bolt\Extension\MichaelMezger\SlugRouting\Controller\Frontend();
            }
        );

        $app['slugify'] = $app->share(function() {
            return new Slugify();
        });
    }
}
