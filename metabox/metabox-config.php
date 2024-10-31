<?php


add_action('cmb2_admin_init', 'rubsum_metabox_fields_add');

function rubsum_metabox_fields_add(){

	$prefix = '_prefix_';

	$metaboxSection = new_cmb2_box(array(
		'title'			=> __('Informations', 'rubsum_info'),
		'id'			=> 'employees-info-fields',
		'object_types'	=> array('rs_employees_info')
	));

	$metaboxSection->add_field(array(
		'name'		=> __('Name', 'rubsum_info'),
		'type'		=> 'text',
		'id'		=> $prefix . 'employees_name',
	));

	$metaboxSection->add_field(array(
		'name'		=> __('Age', 'rubsum_info'),
		'type'		=> 'text',
		'id'		=> $prefix . 'employees_age',
	));

	$metaboxSection->add_field(array(
		'name'		=> __('Degree/Education', 'rubsum_info'),
		'type'		=> 'text',
		'id'		=> $prefix . 'employees_degree',
	));
	
	$metaboxSection->add_field(array(
		'name'		=> __('Chember/Job Responsibility', 'rubsum_info'),
		'type'		=> 'wysiwyg',
		'id'		=> $prefix . 'employees_chember',
	));



}