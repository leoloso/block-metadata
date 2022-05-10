# Block Metadata

This plugin helps convert WordPress into a manager of our digital content, to publish it in different mediums or platforms: not just the website, but also email, iOS/Android apps, home-assistants (like Amazon Alexa) and others.

It does this by extracting the metadata from all Gutenberg blocks inside of a blog post. Because each Gutenberg block stores its own content and properties, these ones can be extracted as metadata and exported through as a JSON object, accessible through the REST API, to feed any application on any platform.

The plugin makes the following REST API field available on objects of `post` type:

```javascript
restful_blocks: [...]
```

## How does it work?

This plugin is based on the strategy called "Create Once, Publish Everywhere" (also called "COPE"), which reduces the amount of work needed to publish our content into different mediums by establishing a single source of truth for all content.

Having content that works everywhere is not a trivial task, since each medium will have its own requirements. For instance, whereas HTML is valid for printing content for the web, this language is not valid for an iOS/Android app; similarly, we can add classes to our HTML for the web, but these must be converted to styles for email.

The solution is to separate form from content: The presentation and the meaning of the content must be decoupled, and only the meaning is used as the single source of truth. The presentation can then be added in another layer, specific to the selected medium. For instance, given the following piece of HTML code, the `<p>` is an HTML tag which applies mostly for the web, and attribute `class="align-center"` is presentation (placing an element "on the center" makes sense for a screen-based medium, but not for an audio-based one such as Amazon Alexa):

```html
<p class="align-center">Hello world!</p>
```

Hence, this piece of content cannot be used as a single source of truth, and it must be converted into a format which separates the meaning from the presentation, such as the following piece of JSON code:

```javascript
{
  content: "Hello world!",
  placement: "center",
  type: "paragraph"
}
```

This piece of code can be used as a single source of truth for content, since from it we can recreate once again the HTML code to use for the web, and procure an appropriate format for other mediums.

## Supported Gutenberg blocks

This plugin attempts to extract the metadata for all Gutenberg blocks shipped in WordPress core; support for additional blocks, such as from plugins, can be added through hooks. Not all Gutenberg blocks can be supported (for instance, because they may only work for the web, or only make sense when applied to screen-based mediums, among other reasons).

The following WordPress core blocks are currently not supported:

- `"core/columns"`
- `"core/column"`
- `"core/cover"`
- `"core/html"`
- `"core/table"`
- `"core/button"`
- `"core/media-text"`

The following Gutenberg blocks are supported, and this plugin extracts their metadata:

- `"core/paragraph"`
- `"core/image"`
- `"core-embed/youtube"` (all other `"core-embed"` blocks can also be extracted, but must be implemented through a hook)
- `"core/heading"`
- `"core/gallery"`
- `"core/list"`
- `"core/audio"`
- `"core/file"`
- `"core/video"`
- `"core/code"`
- `"core/preformatted"`
- `"core/quote"`
- `"core/pullquote"`
- `"core/verse"`

## Extracting metadata for additional blocks

We can extend this plugin to extract the metadata for additional blocks, such as those shipped through plugins. To do this, simply add a hook for filter `"Zamaneh\RestfulBlocks\Metadata::blockMeta"` (located in function `get_block_metadata($block_data)` from class `Metadata` in file `src/Metadata.php`). The attributes that must be extracted must be decided on a block type by block type basis:

```php
add_filter('Zamaneh\RestfulBlocks\Metadata::blockMeta', 'extract_additional_block_metadata', 10, 3);
function extract_additional_block_metadata($blockMeta, $blockName, $block)
{
  if ($blockName == 'my-plugin/my-block-name') {
    return array(
      'property1' => $block['property1'],
      'property2' => $block['property2']
    );
  }

  return $blockMeta;
}
```

## Further references

- Article [“Create Once, Publish Everywhere” with WordPress](https://www.smashingmagazine.com/2019/10/create-once-publish-everywhere-wordpress/), explaining the logic of code in detail
- [Inspiration for the plugin](https://leoloso.com/posts/my-1st-wp-plugin/)
- [Slides from presentation "COPE with WordPress"](https://slides.com/leoloso/cope-with-wp) (from WordCamp Singapore 2019), explaining how the plugin works

<!--_Banner image [designed by Freepik](https://www.freepik.com)_-->
