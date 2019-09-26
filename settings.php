<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Course list block settings
 *
 * THIS DOESN"T WORK.
 * When I upload the file, I expect the component to become "category_tiles" or even "block_category_tiles"
 * since that is what the name is
 * but for SOME DUMB REASON moodle uploads these files in the "core" component
 * So I'm leaving this file here because it might help some future developer see how to upload files from a block settings
 * and maybe THEY can figure out how to upload files into a specific component from here. I give up.
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.svg'), 'maxfiles' => -1);

    $settings->add(new admin_setting_configstoredfile('block_category_tiles_images',
             get_string('category_icons', 'block_category_tiles'),
             get_string('category_icons_description', 'block_category_tiles'), 'images', 0, $opts));

}