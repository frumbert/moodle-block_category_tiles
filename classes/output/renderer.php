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
namespace block_category_tiles\output;
defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use renderable;

class renderer extends plugin_renderer_base {

    /**
     * Defer to template.
     * @param tiles $tiles
     * @return string
     */
    public function render_tiles(tiles $tiles) {
        return parent::render_from_template('block_category_tiles/main', $tiles->export_for_template($this));
    }

}
