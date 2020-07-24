# Category Tiles Block

This block plugin will display categories as tiles in a similar way to dashboard course tiles. If the description field of the category contains an image tag, it will use the first one encountered as the image for that category (internal or external). If no image is found a dynamic image will be generated for that category.

![Category Tiles block shown in Boost theme - Moodle 3.8.3](https://i.imgur.com/u8bKfPn.png)

The block can be placed on the dashboard or in the course category pages or the site homepage (or all of these).

Admins get to see all categories but hidden categories will be noted.

## Options

You can change the block title, and choose whether the category list is _filtered_.

![Settings screen of block](https://i.imgur.com/izO8UlT.png)

A filtered list will only list categories that contain courses that the user is already enrolled in or can enrol themselves in. Filtering doesn't apply to admins.

![Example of a filtered tile list shown to a learner](https://i.imgur.com/125TGNV.png)

## Styling

The styling uses the same block and classname structure as dashboard course tiles. If you're feeling adventurous you can modify the mustache templates and come up with your own layout.

Since the default category renderer will display images and description at the top of the category list, you might not like the doubling up of images you might see

![Category image being shown in standard category page](https://i.imgur.com/3vnGTZ2.png)

You could get creative in your themes stylesheet and have something like

```css
#page-course-index-category .categorypicker + .generalbox.info img:first-of-type { display: none; }
```

in order to hide the first encountered image, or you can edit the html of the image tag and include the 'hidden' attribute which most modern browsers will recognise.

```html
<p>
    <img src="https://my.moodle.site/pluginfile.php/3/coursecat/description/orange.jpg" alt="" role="presentation" hidden>
</p>
``` 

## Licence

http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
