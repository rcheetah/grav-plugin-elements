# Elements Plugin

The **Elements** Plugin is an extension for [Grav CMS](http://github.com/getgrav/grav). 

*Build grav sites easier by using content elements (modules) for your page contents.*

This plugin offers a toolkit for you to create your own content-elements. It builds upon the concept of modular pages, and offers a boilerplate to create sophisticated modules – or “elements”. You can build pretty complex pages by sticking those elements together. Content element can take any form. Simple examples would be text, images or boxes – but you can also define complex structures like comprehensive sliders, maps, galleries or really anything else. 


## Features
### Create your own elements
This plugin offers a boilerplate for your modules. You still have to write your own blueprints and templates, but you can extend on Elements’ blueprints and templates to make your life easier and inherit standard settings. 

### Title Options
The appearance of the elements title can be modified in the admin panel. You want to hide the title on this particular instance? No problem! You want to override the text-align. Easy! At the moment you can:
- Show or hide the title
- Change the text align
- Add additional css classes
- Override margin and padding
- And even override the html tag

### Layout Options
Modules can be customized in their appearance. Once you set up the plugin, you can use it to create something like a jumbotron out of a simple text-element without writing a single line of code. Change the padding, add a background image and let the element span over the complete page width. Done. At the moment the following settings are possible:
- Change the background color
- Add a background image
- Choose between three layout options
  - Let the element be constrained in it's container (default)
  - Let the element span the whole page
  - Let the background span the whole page, while the content is still constrained to a container
- Set fixed heights for elements
- Use a different color scheme on a dark background
- Change the margin and padding of the element
- Add transitions obove and below the element
- Add additional css classes

### Default elements
The plugin intentionally doesn't define default elements, to keep it a clean boilerplate. An additional plugin with universal elements like Text or Image is planned. But the base plugin currently defines only two very abstract elements. They are included, because their purpose is to *structure* other elements:
- **Columns:** Any other child elements are displayed in columns. If you have a text element and an image element, you can display them beside each other, without creating a separate text-image-element.
- **Wrapper:** This acts as a simple container and displays any child elements underneath each other. You can also use it to have access to the layout options. This allows you, for example, to change the background of a (transparent) element that does not offer the option to change it’s background.

### Also works for pages
You can use the title and layout options on any regular page too, not only on modules. 

### Based on the idea of reasonable defaults
This plugin is based on the idea of default values. A good example for this concept are the color options. You define your brand colors once globally, so a backend user can choose only from the provided colors. Therefore he cannot screw up your corporate design. Inentionally, there are no color-picker fields. This is an opinionated approach that will most likeley suit most users. However, nothing stops you from overwriting the default behaviour, if this suits your needs better.





## Installation

**NOTE: This plugin is not available via the GPM repository yet. Therefore the GPM and Admin installation won't work at the moment. Clone the git repository into your plugin folder or create a zip out of this folder.**

Installing the Elements plugin can be done in one of three ways: ~~The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command,~~ the manual method lets you do so via a zip file, and the ~~admin method lets you do so via the Admin Plugin.~~

### ~~GPM Installation (Preferred)~~

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install elements

This will install the Elements plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/elements`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `elements`. You can find these files on [GitHub](https://github.com/rcheetah/grav-plugin-elements) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/elements
	
> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/rcheetah/grav-plugin-elements/blob/master/blueprints.yaml).

### ~~Admin Plugin~~

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

The plugin is customizable via the admin plugin. Go to Plugins and click on the name of the “elements” plugin. You will find (most of) the setup varialbes in a separate tab called “Configuration”. 

You could also change the settings manually in the yaml file, but as this plugin only works with the admin plugin, you have access to the admin plugin anyway. Using the admin panels settings is the best way, as it prevents you from missing a variable and breaking the plugin.

If you need to check the default settings as a reference, you can check out the plugins configuration file in `user/plugins/elements/elements.yaml`. You should never change this file directly, as it get's overwritten when updating the plugin.

### Setup Classes and Options
At first you have to setup the plugin. This mostly means setting the css classnames. The actual style changes have to be done via your themes css. Here is an example:

IF you define the prefix for the background color to be `bg-` and add the color options `primary`, `secondary` and `danger`, then you have to define the css classes `.bg-primary`, `.bg-secondary` and `.bg-danger`. These could look like:
```css
.bg-primary {
    background-color: #4166f5 !important;
}
```
At the moment the Elements plugin does not offer it's own css rules. Maybe that will be added as an option in a future release. 

#### Hints
- As these classes are very repetivie, I would recommend to use a css precompiler like SASS and use a mixin or the each statement.
- Values that are set via the admin panel can be considered definite. Thus, it is recommended to add the `!imporant` statement to those rules, so they won’t be overruled by other css classes by accident. 
- Most of the standard settings will actually work with bootstrap. So if you already use bootstrap, you only need to setup a few additional css classes like the grid gap.

### Setup Modular Pages

#### Extend your blueprints
In your blueprint `modular.yaml` you need to extend Elements’ blueprint file:

```yaml
extends@: 
  - modular
  - partials/elements_modular
  # ...
```

#### Create a modular template
Create the file `templates/modular.html.twig` in your theme. For standard behaviour you just have to `use` the file `partials/elements_modular_base.html.twig` that is offered by Elements. Add the block `element` where you want it to be, and call the parent function. That’s it. If you don’t need any fancy extras, this will display all child modules. 

```php
{% extends <!-- YOUR BASE TEMPLATE --> %}
{% use 'partials/elements_modular_base.html.twig' %}

{% block <!-- THE CONTENT BLOCK OF YOUR BASE TEMPLATE -->  %}
    {% block element %}
        {{ parent() }}
    {% endblock %}
{% endblock %}
```

### Optional: Setup Default Pages
You can add the functionality of modules (like the layout tab and the title options) to normal pages too. I works just the same as with modular pages, you only have to use different extensions.

- Blueprints: `partials/elements_default`
- Templates: `partials/elements_default_base.html.twig`

If you want to extend any other pages, you can do so the same way. In general you should use the default template for this, because the modular has some very special adaptions. You can also overwrite the settings further.

## Usage

### Create custom elements

#### Extend your blueprints
To setup custom elements you can extend upon Elements boilerplates. To build your blueprints upon the element base you can add the following extend command:

```yaml
extends@: 
  - partials/elements_module_base

  # form definitions
  # ...
```

#### Extend your templates
Here is an example of a template extension:

```php
{% extends "partials/elements_module_base.html.twig" %}

{% block element %}
    {% set element_type = "module" %}
    {% set element_variant = "text" %}
    {{ parent() }}
{% endblock element %}

{% block element_content %} 
    <div class="myCustomClass">
        <div class="module--text__title">
            <i class="icon">{{header.icon}}</i>{{page.header|e}} 
        </div>
        <div class="module--text__meta">{{header.author}}</div>
        <div class="module--text__content">
            {{ page.content|raw }}
        </div>
    </div>
{% endblock element_content %}

```

- In the first line we extend the file `partials/elements_module_base.html.twig`. This is the base file for our custom elements.
- In the block `element` the only necessary line is `{{ parent() }}` which starts the inheritance process.
- Note, that you can overwrite some variable before calling the parent. In this case we set the element type to `module` and the element_variant to `text`. The resulting template will automatically wrap our element with the classes `module module--text`. Thus we can create styling rules that apply to all modules, and styling rules that only target modules of the type text.
- By default the module will display the page title and the content. We will most likely want to overwrite this. In this example we use a few header varibles to add an icon and the author name.


### Using title options
You can use the title options of this plugin in your own elements. To add the necessary backend field you have to extend the corresponding blueprint file:

```yaml
extends@: 
  - partials/elements_module_base
  - partials/elements_titleoptions # here we add the title optioins

  # form definitions
  # ...
```

We could now access all the header variables that are set by these fields and build our title based on that. But in most cases that would be unnecessary. We can just use the standard title rendering that will take into account all the settings which are set by the title options:

```php
{% extends "partials/elements_module_base.html.twig" %}

{# here we import the plugins title rendering #}
{% use "partials/elements_title.html.twig" %} 

{% block element %}
    {{ parent() }}
{% endblock element %}


{% block element_content %} 
    {# ... #}
    <div class="module--text__title">
        {# here we call the title rendering #}
        {% block element_title %} {{ parent() }} {% endblock %}
    </div>
    <div class="module--text__content">
        {{ page.content|raw }}
    </div>
    {# ... #}
{% endblock element_content %}
```

**Note:** The block `element_title` has to be called inside the block `element_content`.

## Credits

Thanks to all the people in the Grav discord channel that helped a hobby programmer like me creating this plugin. 

## To Do

- [ ] Add an option to incorporate standard css rules, to let the plugin work better out-of-the-box
- [ ] Create better docs
- [ ] Add to plugin to the GPM
- [ ] Add option for subtitles
- [ ] Add option for fixed heights (maybe percent using `vh`)
- [ ] Add option for custom module id (for inpage links) or maybe use folder name from slug (unique and well formated)
- [ ] Add option for background layer effects