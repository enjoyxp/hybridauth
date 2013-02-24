<?php
/*!
* This file is part of the HybridAuth PHP Library (hybridauth.sourceforge.net | github.com/hybridauth/hybridauth)
*
* This branch contains work in progress toward the next HybridAuth 3 release and may be unstable.
*/

namespace Hybridauth\Adapter\Api;

abstract class AbstractApi
{
	public $application = null;
	public $endpoints   = null;
	public $tokens      = null;
	public $httpClient  = null;
}