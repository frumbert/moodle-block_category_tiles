<?php

// modified from code at https://docs.moodle.org/dev/File_API
function block_category_tiles_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
           //                             null, null, 1          , 'category_icons', '1.jpg', 0   , [preview=null, offline=0, embed=0]

    if ($context->id !== context_system::instance()->id && $context->contextlevel !== CONTEXT_BLOCK) {
        return false;
    }

    if ($filearea !== 'category_icons' && $filearea !== 'content') {
        return false;
    }

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }

    // set itemid to 0 otherwise it is null and that's a whole other contenthash
    $itemid = 0;

    // Retrieve the file from the Files API.
    //block_category_tiles
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_category_tiles', $filearea, $itemid, $filepath, $filename);

    if (!$file) {
        return false; // The file does not exist.
    }

    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering.
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}