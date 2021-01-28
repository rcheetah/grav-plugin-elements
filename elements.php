<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

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
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
            'onGetPageBlueprints'  => ['onGetPageBlueprints',  0],
            'onGetPageTemplates'   => ['onGetPageTemplates',   0],
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
        // if ($this->isAdmin()) {
        //     $this->active = false;
        //     return;
        // }

        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
        ]);
    }



    /**
     * Push styles to Admin-plugin via Assets Manager
     *
     * @return void
     */
    public function onPageInitialized(Event $event)
    {
        if ($this->isAdmin()) {
            $assets = $this->grav['assets'];
            $assets->addCss('plugin://elements/css/adminstyles.css', 1);
        }
        
    }



    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
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



    /**
     * Add page templates
     */
    public function onGetPageTemplates(Event $event)
    {
        /** @var Types $types */
        $types = $event->types;
        $types->register('plugins://elements/templates');
    }

    
}
