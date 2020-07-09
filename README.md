# Category Tiles Block

This block plugin will display top-level category images in a linked list. Works great on the Dashboard.

There are no options to set. Admins will see hidden categories.

The block contains a `style.css` file which is automatically included. Override styles through your favorite theme.

It automatically adds the classnames to the list elements containing the images via jquery at the following pixel widths:

| Min-Width (px) | Classname |
|----------------|-----------|
| 1050 | col4 |
| 750 | col3 |
| 400 | col2 |
| 0 | col1 |

Just edit a category and insert an image into the description field. You can use the repository browser to insert a local image, or hotlink to an image from the internet. The category renderer will look for the `src` attribute and use that (it does not copy the whole image tag).

