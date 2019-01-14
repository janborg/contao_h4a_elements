<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2019 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'H4aElements',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'H4aElements\ContentH4aTabelle' => 'system/modules/contao_h4a_elements/elements/ContentH4aTabelle.php',
	'H4aElements\ContentH4aSpiele'  => 'system/modules/contao_h4a_elements/elements/ContentH4aSpiele.php',

	// Helper
	'H4aElements\Helper'            => 'system/modules/contao_h4a_elements/Helper/Helper.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_h4a_tabelle' => 'system/modules/contao_h4a_elements/templates',
	'ce_h4a_spiele'  => 'system/modules/contao_h4a_elements/templates',
));
