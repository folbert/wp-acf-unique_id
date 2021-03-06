<?php

class acf_field_unique_id extends acf_field {

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'unique_id';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Unique ID', 'acf-unique_id');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'layout';


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('unique_id', 'error');
		*/

		$this->l10n = array(
		);


		// do not delete!
    	parent::__construct();
    
	}


	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field( $field ) {

	    if(isset($field['hide_field']) && $field['hide_field'] != false) {
            echo '<style>[data-key="' . $field['key'] . '"] { display: none; }</style>';
        }

		?>
		<input type="text" readonly="readonly" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" />
		<?php
	}


	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	function update_value( $value, $post_id, $field ) {

		if (empty($value)) {

            $prefix = '';

            if(!empty($post_id) && (isset($field['prefix_with_post_id']) && $field['prefix_with_post_id'] != false)) {

                $divider = (isset($field['divider']) ? $field['divider'] : '-');

                $prefix = $post_id . $divider;
            }

            if(isset($field['more_entropy']) && $field['more_entropy'] != false) {
                $value = uniqid($prefix, true);
            } else {
                $value = uniqid($prefix);
            }

		}

		return $value;
		
	}

    /**
     * @param $field
     */
	function render_field_settings($field) {

        acf_render_field_setting( $field, array(
            'label'			=> __('Hide field','acf-unique_id'),
            'instructions'	=> __('Do you want to hide the field in the admin area?','acf-unique_id'),
            'name'			=> 'hide_field',
            'type'			=> 'true_false',
            'ui'			=> 1,
        ));

        acf_render_field_setting( $field, array(
            'label'			=> __('Prepend value with post id','acf-unique_id'),
            'instructions'	=> __('Do you want to prepend the value with the id of the post (or "options" if used on an options page)?.','acf-unique_id'),
            'name'			=> 'prepend_with_post_id',
            'type'			=> 'true_false',
            'ui'			=> 1,
        ));

        acf_render_field_setting( $field, array(
            'label'			=> __('Use more entropy','acf-unique_id'),
            'instructions'	=> __('Do you want the code to pass <code>true</code> as second parameter to <code>uniqid()</code> in order to increase likelihood of a truly unique value?','acf-unique_id'),
            'name'			=> 'more_entropy',
            'type'			=> 'true_false',
            'ui'			=> 1,
        ));

        acf_render_field_setting( $field, array(
            'label'			=> __('Post-id and unique id divider','acf-unique_id'),
            'instructions'	=> __('What to use as sepratator between post id and the unique id. You must also enable "Prepend value with post id" for this to have an effect.'),
            'name'			=> 'divider',
            'type'			=> 'text',
            'default_value' => '-',
        ));

    }


	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	function validate_value( $valid, $value, $field, $input ){
		return true;
	}
}


// create field
new acf_field_unique_id();
