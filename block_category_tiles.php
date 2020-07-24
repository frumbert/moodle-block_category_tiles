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

class block_category_tiles extends block_base {
    function init() {
            $this->title = get_string('pluginname', 'block_category_tiles');
    }

   function instance_allow_multiple() {
        return true;
    }

    function has_config() {
        return true;
    }

    function applicable_formats() {
        return array(
                'admin' => false,
                'site-index' => true,
                'course-view' => true,
                'course-index-category' => true,
                'mod' => false,
                'my' => true
        );
    }

    public function specialization() {
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_category_tiles');
        } else {
            $this->title = $this->config->title;
        }
    }

    function get_content() {
        global $CFG, $USER, $DB, $OUTPUT;

        if (isset($this->content)) {
            return $this->content;
        }

        // category might be present if the block is used on a course category index page
        $categoryid = optional_param('categoryid', 0, PARAM_INT);

        // get the template renderer and initialise the tiles generator
        $renderable = new \block_category_tiles\output\tiles($this->config, $categoryid);
        $renderer = $this->page->get_renderer('block_category_tiles');

        // output the block
        $this->content = new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';

        return $this->content;

    }

}
