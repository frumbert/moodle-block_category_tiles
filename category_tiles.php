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
 * Course list block.
 *
 * @package    block_category_tiles
 * @copyright  1999 onwards Oliver Redding (oliverredding at catalyst dot net dot nz)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include_once($CFG->dirroot . '/course/lib.php');
include_once($CFG->libdir . '/coursecatlib.php');
require_once($CFG->libdir . '/filestorage/file_storage.php');

class block_category_tiles extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_category_tiles');
    }

    function has_config() {
        return false;
    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        $this->page->requires->js_call_amd('block_category_tiles/category_tiles', 'init');

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        $categories = coursecat::get(0)->get_children();  // Parent = 0   ie top-level categories only
        if ($categories) {   //Check we have categories
            if (count($categories) > 1 || (count($categories) == 1 && $DB->count_records('course') > 200)) {     // Just print top level category links
                foreach ($categories as $category) {
                    $categoryname = $category->get_formatted_name();
                    $categoryimage = $this->get_category_image($category);
                    $dimmed = $category->visible ? "" : " dimmed";
                    $this->content->items[]="<a class=\"category-tile$dimmed\" href=\"$CFG->wwwroot/course/index.php?categoryid=$category->id\"><div class=\"category-tile-title\">$categoryname</div><div class=\"category-tile-image\" style=\"background-image: url('$categoryimage')\"></div></a>";
                }
            }
        }

        return $this->content;
    }

    function get_category_image($coursecat) {
        $contextid = $coursecat->get_context()->id;
        $fs = get_file_storage();
        if ($files = $fs->get_area_files($contextid, 'coursecat', 'categoryimage', 0)) {
            foreach($files as $file) {
                // Do not return unknown files.
                if ($file->get_filename() === ".") {
                    continue;
                }
                // Return url of the file.
                return moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $file->get_filename())->out();
            }
        }
        // If no files for this category, return false.
        return false;
    }

}
