<?php

namespace Bolt\Extension\MichaelMezger\SlugRouting;

use Silex\Application;
use Bolt\Extension\SimpleExtension;
use Symfony\Component\HttpFoundation\Request;

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


        return;
        $app->before(function(Request $request) use ($app) {

            $slug = ltrim($_SERVER['REQUEST_URI'], '/');
            //$slug = ltrim($request->getPathInfo(), '/');
            $contentTypes = $app['config']->get('contenttypes');

            foreach ($contentTypes as $name => $contentType) {
                $stmt = $app['db']->executeQuery(sprintf("SELECT id, slug FROM bolt_%s WHERE slug = :slug", $contentType['tablename']), array('slug' => $slug));
                if ($content = $stmt->fetch()) {
                    $request->server->set('REQUEST_URI', sprintf('/%s/%s', $contentType['slug'], $slug));

                    return;
                }
            }

            $request->server->set('REQUEST_URI', sprintf('/%s/%s', 'notfound', $slug));
        }, Application::EARLY_EVENT);
    }
}
