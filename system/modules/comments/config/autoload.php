<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.3
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Comments
 * @license    LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\\Comments'           => 'system/modules/comments/Comments.php',
	'Contao\\ContentComments'    => 'system/modules/comments/ContentComments.php',
	'Contao\\ModuleComments'     => 'system/modules/comments/ModuleComments.php',

	// Models
	'Contao\\CommentsCollection' => 'system/modules/comments/models/CommentsCollection.php',
	'Contao\\CommentsModel'      => 'system/modules/comments/models/CommentsModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_comments' => 'system/modules/comments/templates',
	'com_default' => 'system/modules/comments/templates',
));
