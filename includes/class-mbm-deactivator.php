<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MBM_Deactivator {

	public static function deactivate(): void {
		flush_rewrite_rules();
	}
}
