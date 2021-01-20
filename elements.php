<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Grav;
use Grav\Common\Data;
use Grav\Common\Page\Page;
use Grav\Common\Plugin;
use Grav\Common\Uri;
use Grav\Common\Page\Pages;
use Grav\Common\Utils;
use Grav\Plugin\Sitemap\SitemapEntry;
use RocketTheme\Toolbox\Event\Event;
use RocketTheme\Toolbox\Blueprints;

/**
 * Class ElementsPlugin
 * @package Grav\Plugin
 */
class ElementsPlugin extends Plugin
{

    // /** @var array */
    // public $features = [
    //     'blueprints' => 0, // Use priority 0
    // ];

    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                ['onPluginsInitialized', 0],
            ],
            'onGetPageBlueprints'  => ['onGetPageBlueprints', 0],
        ];
    }

    /**
    * Composer autoload.
    *is
    * @return ClassLoader
    */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }


    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        // Enable the main events we are interested in
        // this->enable();
    }


    /**
     * Add page blueprints
     *
     * @param Event $event
     */
    public function onGetPageBlueprints(Event $event)
    {
        /** @var Types $types */
        $types = $event->types;
        $types->scanBlueprints('plugins://elements/blueprints/pages/');
    }

}
