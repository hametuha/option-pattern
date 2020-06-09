<?php

namespace Hametuha\OptionPattern\Views\Pattern;

/**
 * Class Hidden
 *
 * @package option-pattern
 */
abstract class Hidden extends AbstractInput {
	
	const TYPE = 'hidden';
	
	protected function get_input_type() {
		return 'hidden';
	}
}
