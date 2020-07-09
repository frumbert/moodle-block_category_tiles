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
 * Category Tiles block.
 *
 * @package    block_category_tiles
 * @copyright  1999 onwards tim.stclair@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * A block for linking to top-level categories in visual way.
 */

include_once($CFG->dirroot . '/course/lib.php');
include_once($CFG->dirroot . '/course/renderer.php');

class block_category_tiles extends block_list {
    function init() {
        $this->title = get_string('configtitle', 'block_category_tiles');
    }

    function has_config() {
        return false;
    }

    // single instance, as it has no options
    function instance_allow_multiple() {
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

        $categories = core_course_category::get(0)->get_children();  // Parent = 0   ie top-level categories only
        if ($categories) {   //Check we have categories
            if (count($categories) > 1 || (count($categories) == 1 && $DB->count_records('course') > 200)) {     // Just print top level category links
                foreach ($categories as $category) {

                    if (is_object($category) && $category instanceof core_course_category) {
                        $coursecat = $category;
                    } else {
                        $coursecat = core_course_category::get(is_object($category) ? $category->id : $category);
                    }

                    $chelper = new coursecat_helper();
                    if ($description = $chelper->get_category_formatted_description($coursecat)) {
                        $categoryimage = $this->get_category_image($description);
                        if ($categoryimage) {
                            $this->content->icons[] = "<a href='{$CFG->wwwroot}/course/index.php?categoryid={$category->id}'><img src='$categoryimage' class='course-tile-image'></a>";
                        }
                    }
                    $categoryname = $category->get_formatted_name();

                    if (!$category->visible && !is_siteadmin()) continue;
                    $this->content->items[] = "<a href=\"$CFG->wwwroot/course/index.php?categoryid=$category->id\">$categoryname</a>";
                 }
            }
        }

        return $this->content;
    }

    function get_category_image($html){
        if (strlen(trim($html)) === 0) return false;
        $dom = new DOMDocument;
        $dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            return $image->getAttribute('src');
        }
        return false;
    }

}
