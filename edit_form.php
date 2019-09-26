<?php
class block_category_tiles_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        $mform->addElement('filemanager',
            'config_images',
            get_string('category_icons', 'block_category_tiles'),
            null,
            array('subdirs' => 0,
                'maxfiles' => -1,
                'accepted_types' => array('.png', '.jpg', '.jpeg', '.gif', '.svg', '.webp'),
            )
        );

    }

    public function set_data($defaults)
    {

        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }

        $draftitemid = file_get_submitted_draft_itemid('config_images');

        file_prepare_draft_area($draftitemid,
            $this->block->context->id,
            'block_category_tiles',
            'content',
            0,
            array('subdirs' => true)
        );

        $entry->attachments = $draftitemid;

        parent::set_data($defaults);
        if ($data = parent::get_data()) {

            file_save_draft_area_files($data->config_images,
                $this->block->context->id,
                'block_category_tiles',
                'content',
                0,
                array('subdirs' => true)
            );

        }
    }
}
