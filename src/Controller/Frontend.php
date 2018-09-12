<?php

namespace Bolt\Extension\MichaelMezger\SlugRouting\Controller;

use Silex;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Frontend extends \Bolt\Controller\Frontend
{

    public function genericRecord(Request $request, $slug)
    {
        $contentTypeSlug = $this->detectContentTypeSlug($slug);

        if ($contentTypeSlug === false) {
            $this->abort(Response::HTTP_NOT_FOUND, "Page $slug not found.");
        }

        return parent::record($request, $contentTypeSlug, $slug);

    }

    public function detectContentTypeSlug($slug)
    {
        $contentTypes = $this->app['config']->get('contenttypes');

        foreach ($contentTypes as $name => $contentType) {
            $stmt = $this->app['db']->executeQuery(sprintf("SELECT id, slug FROM bolt_%s WHERE slug = :slug", $contentType['tablename']), array('slug' => $slug));
            if ($content = $stmt->fetch()) {

                return $contentType['slug'];
            }
        }

        return false;
    }
}
