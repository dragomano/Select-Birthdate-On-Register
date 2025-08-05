<?php

/**
 * Class-SelectBirthdateOnRegister.php
 *
 * @package SelectBirthdateOnRegister
 * @link https://github.com/dragomano/smf-select-birthdate-on-register
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2024 Bugo
 * @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
 *
 * @version 0.1
 */

namespace Bugo;

class SelectBirthdateOnRegister
{
	public function hooks(): void
	{
		add_integration_function(
			'integrate_load_custom_profile_fields',
			__CLASS__ . '::loadCustomProfileFields#',
			false,
			__FILE__
		);

		add_integration_function(
			'integrate_register',
			__CLASS__ . '::register#',
			false,
			__FILE__
		);
	}

	/**
	 * @hook integrate_load_custom_profile_fields
	 */
	public function loadCustomProfileFields(): void
	{
		global $context, $txt;

		if (in_array($context['current_action'], ['admin', 'signup', 'signup2']) === false)
			return;

		loadLanguage('Profile');

		$context['custom_fields'][] = [
			'name' => $txt['dob'],
			'desc' => '',
			'input_html' => '<input id="birthdate" name="birthdate" type="date">',
			'show_reg' => '2'
		];

		$context['custom_fields_required'] = true;
	}

	/**
	 * @hook integrate_register
	 */
	public function register(array &$regOptions): void
	{
		$regOptions['register_vars']['birthdate'] = $_POST['birthdate'] ?: '1004-01-01';
	}
}
