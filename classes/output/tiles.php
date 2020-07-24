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
 * tiles renderable.
 *
 * @package    block_category_tile
 * @copyright  tim.stclair@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_category_tiles\output;
defined('MOODLE_INTERNAL') || die();

include_once($CFG->dirroot . '/course/renderer.php'); // for coursecat_helper
include_once($CFG->libdir.'/enrollib.php'); // for filtering

use renderable;
use renderer_base;
use templatable;

class tiles implements renderable, templatable {

	protected $options;
	protected $categoryid;

    public function __construct($config, $categoryid = 0) {
        $this->options = $config;
        $this->categoryid = $categoryid;
    }

    public function export_for_template(\renderer_base $output) {
    	global $DB, $CFG;

        $potential_courses = [];
        if ($filtered = isset($this->options->filter) && $this->options->filter === "1" && !is_siteadmin()) {
            $potential_courses = enrol_get_my_courses(['id','category'],null,0,[],true);
        }
        $data = [];

        $categories = \core_course_category::get($this->categoryid)->get_children();  // Parent = 0   ie top-level categories only
        if ($categories) {   //Check we have categories
            foreach ($categories as $category) {

                // exit early if we can't see this category
                if (!$category->visible && !is_siteadmin()) continue; // hidden
                if ($filtered && $this->count_courses_in_categories($category->id) < 1) continue; // no courses in category
                if ($filtered && !$this->category_contains_enrollable_course($category, $potential_courses)) continue; // no enrollable courses

                if (is_object($category) && $category instanceof \core_course_category) {
                    $coursecat = $category;
                } else {
                    $coursecat = \core_course_category::get(is_object($category) ? $category->id : $category);
                }

                $chelper = new \coursecat_helper();
                $categoryname = $category->get_formatted_name();
                if ($description = $chelper->get_category_formatted_description($coursecat)) {
                    $categoryimage = $this->get_category_image($description);
                }
                if (empty($categoryimage)) {
                    $categoryimage = $output->get_generated_image_for_id($category->id * 65535);
                }
                $data[] = [
                	"name" => $categoryname,
                	"image" => $categoryimage,
                	"url" => $CFG->wwwroot . "/course/index.php?categoryid=" . $category->id,
                	"visible" => $category->visible
                ];
            }
        }
        return ["categories"=>$data];
    }

    // helper method to find first image in html
    protected function get_category_image($html){
        if (strlen(trim($html)) === 0) return false;
        $dom = new \DOMDocument;
        $dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            return $image->getAttribute('src');
        }
        return false;
    }

    // count courses in categories or their subcategories
    // TODO: pass in course context and figure out if user has viewhiddencourses capability
    protected function count_courses_in_categories($categoryid) {
        global $DB;
        $i = $DB->get_record_sql("
                SELECT COUNT(1) c FROM {course}
                WHERE visible = 1
                AND category IN (
                    SELECT id FROM {course_categories}
                    WHERE path LIKE ?
                    OR path LIKE ?
                )", ["%/{$categoryid}", "%/{$categoryid}/%"]);
        return intval($i->c);
    }

    // helper method to determine if a category contains a course you can enrol into / are enrolled in
    protected function category_contains_enrollable_course($category, $courses) {

        // are we already enrolled?
        foreach ($courses as $course) {
            if (0===strcasecmp($course->category,$category->id)) return true;
        }

        // check the enrolment plugins for each course to see if we can self-enrol
        foreach ($courses as $course) {
            $instances = enrol_get_instances($course->id, true);
            $plugins = enrol_get_plugins(true);
            foreach ($plugins as $name => $plugin) {
                foreach ($instances as $instance) {
                    // skip bad instances
                    if ($instance->status != ENROL_INSTANCE_ENABLED or $instance->courseid != $course->id) continue;
                    // can_enrol_self (inst, check_enrolents -> false because we already know)
                    if ($plugin->can_self_enrol($instance, false)) return true;
                }
            }

        }

        // we can't see this category
        return false;
    }


}
